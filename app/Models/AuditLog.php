<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class AuditLog extends Model
{
    protected $table = 'audit_logs';

    protected $casts = [
        'old_values' => 'array',
        'new_values' => 'array',
    ];

    protected $fillable = [
        'admin_id', 'document_id', 'action', 'module', 'detail', 'ip_address',
        'old_values', 'new_values', 'user_agent', 'method', 'route',
        'status_code', 'session_id', 'auth_guard', 'failure_reason',
        'hash', 'previous_hash',
    ];

    protected static function booted(): void
    {
        static::creating(function (AuditLog $log) {
            $previous = static::query()->orderByDesc('id')->first();
            $previousHash = $previous ? $previous->hash : str_repeat('0', 64);
            $payload = json_encode([
                'admin_id' => $log->admin_id,
                'document_id' => $log->document_id,
                'action' => $log->action,
                'module' => $log->module,
                'detail' => $log->detail,
                'ip_address' => $log->ip_address,
                'old_values' => $log->old_values,
                'new_values' => $log->new_values,
                'user_agent' => $log->user_agent,
                'method' => $log->method,
                'route' => $log->route,
                'status_code' => $log->status_code,
                'session_id' => $log->session_id,
                'auth_guard' => $log->auth_guard,
                'failure_reason' => $log->failure_reason,
            ]);
            $log->previous_hash = $previousHash;
            $log->hash = hash('sha256', $previousHash . $payload);
        });
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }

    public static function record(
        string $action,
        string $module,
        ?string $detail = null,
        ?array $oldValues = null,
        ?array $newValues = null,
        ?string $failureReason = null,
        ?int $documentId = null
    ): void {
        $request = request();
        $guard = Auth::guard('admin')->check() ? 'admin' : Auth::getDefaultDriver();
        static::create([
            'admin_id' => Auth::guard('admin')->id(),
            'document_id' => $documentId,
            'action' => $action,
            'module' => $module,
            'detail' => $detail,
            'ip_address' => static::resolveClientIp($request),
            'old_values' => static::scrubSensitiveFields($oldValues ?? []),
            'new_values' => static::scrubSensitiveFields($newValues ?? []),
            'user_agent' => $request->userAgent(),
            'method' => $request->method(),
            'route' => $request->path(),
            'status_code' => $request->get('status_code'),
            'session_id' => $request->session()->getId(),
            'auth_guard' => $guard,
            'failure_reason' => $failureReason,
        ]);
    }

    protected static function resolveClientIp($request): ?string
    {
        $forwarded = $request->header('x-forwarded-for');
        if ($forwarded && trim($forwarded) !== '') {
            $first = trim(explode(',', $forwarded)[0]);
            if (filter_var($first, FILTER_VALIDATE_IP)) {
                return $first;
            }
        }

        $serverForwarded = $_SERVER['HTTP_X_FORWARDED_FOR'] ?? null;
        if ($serverForwarded && trim($serverForwarded) !== '') {
            $first = trim(explode(',', $serverForwarded)[0]);
            if (filter_var($first, FILTER_VALIDATE_IP)) {
                return $first;
            }
        }

        $realIp = $request->header('x-real-ip');
        if ($realIp && trim($realIp) !== '') {
            $realIp = trim($realIp);
            if (filter_var($realIp, FILTER_VALIDATE_IP)) {
                return $realIp;
            }
        }

        return $request->ip();
    }

    protected static function scrubSensitiveFields(array $data): array
    {
        $patterns = ['password', 'password_confirmation', 'token', 'secret', 'credit_card', 'pin', 'nik'];

        foreach ($data as $key => $value) {
            if (is_array($value)) {
                $data[$key] = static::scrubSensitiveFields($value);
                continue;
            }

            foreach ($patterns as $pattern) {
                if (stripos((string) $key, $pattern) !== false) {
                    $data[$key] = '***REDACTED***';
                    break;
                }
            }
        }

        return $data;
    }
}
