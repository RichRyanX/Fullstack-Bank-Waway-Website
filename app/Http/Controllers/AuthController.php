<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\AuditLog;
use App\Models\Setting;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\SecurityAlertMail;
use App\Http\Requests\Admin\AdminLoginRequest;
use App\Http\Requests\Admin\AdminVerify2faRequest;

class AuthController extends Controller
{
    protected const MAX_ATTEMPTS = 5;

    public function loginPage()
    {
        return view('admin.login');
    }

    public function login(AdminLoginRequest $request)
    {
        $credentials = $request->validated();

        $attemptedUser = Admin::where('username', $credentials['username'])->first();

        $settings = Setting::firstOrCreate(['id' => 1]);
        if ($settings->maintenance) {
            return response()->json([
                'status' => 'maintenance',
                'message' => 'Server is under maintenance'
            ], 503);
        }

        if ($attemptedUser && $attemptedUser->locked_until && $attemptedUser->locked_until->isFuture()) {
            $minutes = (int) ceil($attemptedUser->locked_until->diffInMinutes(now()));

            AuditLog::create([
                'admin_id' => $attemptedUser->id,
                'action' => 'LOGIN_BLOCKED',
                'module' => 'Autentikasi',
                'details' => 'Percobaan login ditolak karena akun sedang dikunci',
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'method' => $request->method(),
                'route' => $request->path(),
                'status_code' => 423,
                'session_id' => $request->session()->getId(),
                'auth_guard' => 'admin',
                'failure_reason' => 'Akun dikunci sementara',
            ]);

            return response()->json([
                'error' => 'Akun dikunci sementara. Coba lagi dalam ' . $minutes . ' menit.',
                'locked_until' => $attemptedUser->locked_until->toIso8601String(),
            ], 423);
        }

        $valid = $attemptedUser && Hash::check($credentials['password'], $attemptedUser->password_hash);

        if (! $valid) {
            $this->registerFailedAttempt($request, $attemptedUser, $credentials['username']);

            return response()->json(['error' => 'Username atau password salah.'], 401);
        }

        if ($attemptedUser->failed_attempts > 0 || $attemptedUser->locked_until) {
            $attemptedUser->forceFill([
                'failed_attempts' => 0,
                'locked_until' => null,
            ])->save();
        }

        $settings = Setting::firstOrCreate(['id' => 1]);
        if ($settings->two_factor) {
            $code = (string) random_int(100000, 999999);

            $request->session()->put('2fa_admin_id', $attemptedUser->id);
            $request->session()->put('2fa_code', Hash::make($code));
            $request->session()->put('2fa_expires_at', now()->addMinutes(5)->timestamp);

            Log::info('2FA code for admin ' . $attemptedUser->username . ': ' . $code);

            AuditLog::create([
                'admin_id' => $attemptedUser->id,
                'action' => 'LOGIN_2FA_SENT',
                'module' => 'Autentikasi',
                'details' => 'Kode verifikasi 2FA dikirim',
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'method' => $request->method(),
                'route' => $request->path(),
                'status_code' => 200,
                'session_id' => $request->session()->getId(),
                'auth_guard' => 'admin',
            ]);

            return response()->json([
                'requires_2fa' => true,
                'message' => 'Masukkan kode verifikasi yang dikirim.',
            ]);
        }

        return $this->completeLogin($request, $attemptedUser);
    }

    public function verify2fa(AdminVerify2faRequest $request)
    {
        $validated = $request->validated();

        $adminId = $request->session()->get('2fa_admin_id');
        $hashedCode = $request->session()->get('2fa_code');
        $expiresAt = $request->session()->get('2fa_expires_at');

        if (! $adminId || ! $hashedCode || ! $expiresAt) {
            return response()->json(['error' => 'Sesi verifikasi tidak ditemukan. Silakan login ulang.'], 400);
        }

        if (now()->timestamp > $expiresAt) {
            $this->clear2faSession($request);
            return response()->json(['error' => 'Kode verifikasi telah kedaluwarsa. Silakan login ulang.'], 410);
        }

        if (! Hash::check($validated['code'], $hashedCode)) {
            return response()->json(['error' => 'Kode verifikasi salah.'], 422);
        }

        $admin = Admin::find($adminId);
        if (! $admin) {
            $this->clear2faSession($request);
            return response()->json(['error' => 'Akun tidak ditemukan.'], 404);
        }

        $this->clear2faSession($request);

        return $this->completeLogin($request, $admin);
    }

    protected function completeLogin(Request $request, Admin $admin)
    {
        Auth::guard('admin')->login($admin);
        $request->session()->regenerate();

        $settings = Setting::firstOrCreate(['id' => 1]);
        if ($settings->session_timeout) {
            $request->session()->put('admin_session_timeout', (int) $settings->session_timeout);
        }

        AuditLog::create([
            'admin_id' => $admin->id,
            'action' => 'LOGIN',
            'module' => 'Autentikasi',
            'details' => 'Berhasil login ke dalam sistem',
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'method' => $request->method(),
            'route' => $request->path(),
            'status_code' => 200,
            'session_id' => $request->session()->getId(),
            'auth_guard' => 'admin',
        ]);

        return response()->json([
            'status' => 'success',
            'redirect' => route('admin.dashboard'),
        ]);
    }

    protected function registerFailedAttempt(Request $request, ?Admin $attemptedUser, string $username)
    {
        if (! $attemptedUser) {
            AuditLog::create([
                'admin_id' => null,
                'action' => 'LOGIN_FAILED',
                'module' => 'Autentikasi',
                'details' => 'Percobaan login gagal untuk username: ' . $username,
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'method' => $request->method(),
                'route' => $request->path(),
                'status_code' => 401,
                'session_id' => $request->session()->getId(),
                'auth_guard' => 'admin',
                'failure_reason' => 'Username tidak ditemukan',
            ]);
            return;
        }

        $settings = Setting::firstOrCreate(['id' => 1]);
        $attempts = $attemptedUser->failed_attempts + 1;
        $updates = ['failed_attempts' => $attempts];

        $shouldLock = $settings->lockout_enabled && $attempts >= self::MAX_ATTEMPTS;

        if ($shouldLock) {
            $duration = $settings->lockout_duration ?? 15;
            $updates['locked_until'] = now()->addMinutes((int) $duration);
        }

        $attemptedUser->forceFill($updates)->save();

        $action = $shouldLock ? 'LOGIN_LOCKED' : 'LOGIN_FAILED';
        $reason = $shouldLock ? 'Akun dikunci karena terlalu banyak percobaan gagal' : 'Password salah';

        AuditLog::create([
            'admin_id' => $attemptedUser->id,
            'action' => $action,
            'module' => 'Autentikasi',
            'details' => $reason . ' (Percobaan ke-' . $attempts . ')',
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'method' => $request->method(),
            'route' => $request->path(),
            'status_code' => $shouldLock ? 423 : 401,
            'session_id' => $request->session()->getId(),
            'auth_guard' => 'admin',
            'failure_reason' => $reason,
        ]);

        if ($shouldLock) {
            try {
                Mail::to($attemptedUser->email ?? 'admin@bankwaway.co.id')->send(
                    new SecurityAlertMail(
                        'Peringatan Keamanan: Akun Dikunci',
                        'Akun Anda telah dikunci sementara karena terdeteksi ' . $attempts . ' kali percobaan login gagal dari IP ' . $request->ip() . '.'
                    )
                );
            } catch (\Exception $e) {
                Log::error('Gagal mengirim email security alert: ' . $e->getMessage());
            }
        }
    }

    protected function clear2faSession(Request $request)
    {
        $request->session()->forget(['2fa_admin_id', '2fa_code', '2fa_expires_at']);
    }

    public function me(Request $request)
    {
        $admin = Auth::guard('admin')->user();
        if (! $admin) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        return response()->json([
            'id' => $admin->id,
            'name' => $admin->name,
            'username' => $admin->username,
            'email' => $admin->email,
            'role' => $admin->role ?? 'Administrator',
        ]);
    }

    public function logout(Request $request)
    {
        $admin = Auth::guard('admin')->user();

        if ($admin) {
            AuditLog::create([
                'admin_id' => $admin->id,
                'action' => 'LOGOUT',
                'module' => 'Autentikasi',
                'details' => 'Berhasil logout dari sistem',
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'method' => $request->method(),
                'route' => $request->path(),
                'status_code' => 200,
                'session_id' => $request->session()->getId(),
                'auth_guard' => 'admin',
            ]);
        }

        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json(['status' => 'success', 'message' => 'Logged out successfully']);
    }
}
