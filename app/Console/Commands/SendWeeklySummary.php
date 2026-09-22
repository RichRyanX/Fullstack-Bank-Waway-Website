<?php

namespace App\Console\Commands;

use App\Models\AuditLog;
use App\Models\Setting;
use App\Mail\WeeklySummaryMail;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class SendWeeklySummary extends Command
{
    protected $signature = 'report:weekly-summary';

    protected $description = 'Send weekly summary statistics via email';

    public function handle()
    {
        $settings = Setting::firstOrCreate(['id' => 1]);
        if (!$settings->notif_summary) {
            Log::info('Weekly summary disabled by notif_summary setting.');
            return 0;
        }
        $recipient = $settings->notif_email;
        if (empty($recipient)) {
            Log::info('No notification email set for weekly summary.');
            return 0;
        }

        $start = Carbon::now()->subDays(7);
        $totalLogins = AuditLog::where('created_at', '>=', $start)
            ->where('action', 'like', '%login%')
            ->count();
        $failedAttempts = AuditLog::where('created_at', '>=', $start)
            ->where(function ($q) {
                $q->where('action', 'like', '%failed%')
                  ->orWhere('action', 'like', '%gagal%');
            })
            ->count();
        $auditLogs = AuditLog::where('created_at', '>=', $start)->count();
        $activeSessions = AuditLog::where('created_at', '>=', $start)
            ->where('action', 'like', '%login%')
            ->distinct('admin_id')
            ->count('admin_id');

        $stats = [
            'total_logins' => $totalLogins,
            'failed_attempts' => $failedAttempts,
            'audit_logs' => $auditLogs,
            'active_sessions' => $activeSessions,
        ];

        try {
            Mail::to($recipient)->send(new WeeklySummaryMail($stats));
            Log::info('Weekly summary email sent to ' . $recipient);
        } catch (\Exception $e) {
            Log::error('Failed to send weekly summary: ' . $e->getMessage());
        }

        return 0;
    }
}