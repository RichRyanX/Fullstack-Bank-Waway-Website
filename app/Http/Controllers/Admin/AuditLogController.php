<?php

namespace App\Http\Controllers\Admin;

use App\Models\AuditLog;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AuditLogController extends BaseAdminController
{
    public function index()
    {
        return $this->view('audit-log');
    }

    public function apiIndex(Request $request)
    {
        $query = AuditLog::with('admin');

        if ($request->filled('adminId')) {
            $query->where('admin_id', $request->adminId);
        }
        if ($request->filled('user_id')) {
            $query->where('admin_id', $request->user_id);
        }
        if ($request->filled('action')) {
            $action = strtoupper($request->action);
            if ($action === 'LOGIN') {
                $query->where('action', 'LIKE', 'LOGIN%');
            } else {
                $query->where('action', $action);
            }
        }
        $moduleMapping = [
            'AUTH' => ['Autentikasi', 'Auth Service'],
            'CONTENT' => ['Konten Website'],
            'FORM' => ['Formulir & Pengajuan'],
            'REPORT' => ['Laporan & Kepatuhan'],
        ];
        if ($request->filled('module')) {
            $module = $request->module;
            if (array_key_exists($module, $moduleMapping)) {
                $query->whereIn('module', $moduleMapping[$module]);
            } else {
                $query->where('module', $module);
            }
        }
        if ($request->filled('from')) {
            $query->whereDate('created_at', '>=', Carbon::parse($request->from)->format('Y-m-d'));
        }
        if ($request->filled('to')) {
            $query->whereDate('created_at', '<=', Carbon::parse($request->to)->format('Y-m-d'));
        }
        if ($request->filled('date_range')) {
            $range = is_array($request->date_range) ? $request->date_range : explode(',', $request->date_range);
            if (isset($range[0]) && $range[0] !== '') {
                $query->whereDate('created_at', '>=', Carbon::parse($range[0])->format('Y-m-d'));
            }
            if (isset($range[1]) && $range[1] !== '') {
                $query->whereDate('created_at', '<=', Carbon::parse($range[1])->format('Y-m-d'));
            }
        }

        $perPage = $request->input('per_page', 10);
        $logs = $query->orderBy('created_at', 'desc')->paginate($perPage);

        $now = Carbon::now();
        $last12h = AuditLog::where('created_at', '>=', $now->copy()->subHours(12))->count();
        $prev12h = AuditLog::whereBetween('created_at', [$now->copy()->subHours(24), $now->copy()->subHours(12)])->count();

        $percentageChange = 0;
        if ($prev12h > 0) {
            $percentageChange = round((($last12h - $prev12h) / $prev12h) * 100);
        } elseif ($last12h > 0) {
            $percentageChange = 100;
        }

        $failedLogins12h = AuditLog::where('module', 'Autentikasi')
            ->where('action', 'LOGIN_FAILED')
            ->where('created_at', '>=', $now->copy()->subHours(12))
            ->count();

        $contentQuery = AuditLog::where('module', 'Konten Website')
            ->where('created_at', '>=', $now->copy()->subHours(12));
        $contentChanges = (clone $contentQuery)->count();
        $recentUpdates = (clone $contentQuery)->whereIn('action', ['CREATE', 'UPDATE', 'DELETE'])->count();
        $uniqueAdmins = (clone $contentQuery)->whereNotNull('admin_id')->distinct('admin_id')->count('admin_id');

        $response = $logs->toArray();
        $response['data'] = collect($response['data'])->map(function ($log) {
            return array_merge($log, [
                'old_values' => $log['old_values'] ?? null,
                'new_values' => $log['new_values'] ?? null,
                'user_agent' => $log['user_agent'] ?? null,
                'method' => $log['method'] ?? null,
                'route' => $log['route'] ?? null,
                'status_code' => $log['status_code'] ?? null,
                'session_id' => $log['session_id'] ?? null,
                'auth_guard' => $log['auth_guard'] ?? null,
                'failure_reason' => $log['failure_reason'] ?? null,
            ]);
        })->values()->all();
        $response['stats'] = [
            'total_12h' => $last12h,
            'percentage_change' => $percentageChange,
            'failed_logins_12h' => $failedLogins12h,
            'content_changes' => $contentChanges,
            'recent_updates' => $recentUpdates,
            'unique_admins' => $uniqueAdmins,
        ];

        return response()->json($response);
    }

    public function history(Request $request, $documentId)
    {
        $report = \App\Models\ComplianceReport::where('id', $documentId)
            ->orWhere('document_id', $documentId)
            ->first();

        $logs = AuditLog::with('admin')
            ->where(function($query) use ($documentId, $report) {
                $query->where('document_id', $documentId);
                if ($report && $report->document_id) {
                    $query->orWhere('document_id', $report->document_id);
                }
            })
            ->orderBy('created_at', 'desc')
            ->get();

        if ($logs->isEmpty() && $report) {
            $logs = AuditLog::with('admin')
                ->where('document_id', $report->document_id)
                ->orderBy('created_at', 'desc')
                ->get();
        }

        if ($logs->isEmpty()) {
            $logs = AuditLog::with('admin')
                ->orderBy('created_at', 'desc')
                ->get();
        }

        $data = $logs->map(function ($log) {
            return array_merge($log->toArray(), [
                'old_values' => $log->old_values ?? null,
                'new_values' => $log->new_values ?? null,
                'user_agent' => $log->user_agent ?? null,
                'method' => $log->method ?? null,
                'route' => $log->route ?? null,
                'status_code' => $log->status_code ?? null,
                'session_id' => $log->session_id ?? null,
                'auth_guard' => $log->auth_guard ?? null,
                'failure_reason' => $log->failure_reason ?? null,
            ]);
        })->values();

        $document = \App\Models\ComplianceReport::find($documentId);
        if (!$document) {
            $document = \App\Models\ComplianceReport::where('document_id', $documentId)->first();
        }
        if (!$document && $report) {
            $document = $report;
        }

        return response()->json([
            'success' => true,
            'document' => $document ? $document->toArray() : null,
            'logs' => $data,
        ]);
    }

    public function export(Request $request)
    {
        $query = AuditLog::with('admin');

        if ($request->filled('adminId')) {
            $query->where('admin_id', $request->adminId);
        }
        if ($request->filled('action')) {
            $action = strtoupper($request->action);
            if ($action === 'LOGIN') {
                $query->where('action', 'LIKE', 'LOGIN%');
            } else {
                $query->where('action', $action);
            }
        }
        $moduleMapping = [
            'AUTH' => ['Autentikasi', 'Auth Service'],
            'CONTENT' => ['Konten Website'],
            'FORM' => ['Formulir & Pengajuan'],
            'REPORT' => ['Laporan & Kepatuhan'],
        ];
        if ($request->filled('module')) {
            $module = $request->module;
            if (array_key_exists($module, $moduleMapping)) {
                $query->whereIn('module', $moduleMapping[$module]);
            } else {
                $query->where('module', $module);
            }
        }
        if ($request->filled('from')) {
            $query->whereDate('created_at', '>=', $request->from);
        }
        if ($request->filled('to')) {
            $query->whereDate('created_at', '<=', $request->to);
        }

        $logs = $query->orderBy('created_at', 'desc')->get();

        $filename = 'audit_logs_' . date('Ymd_His') . '.csv';

        $headers = [
            'Content-type'        => 'text/csv',
            'Content-Disposition' => 'attachment; filename=' . $filename,
            'Pragma'              => 'no-cache',
            'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
            'Expires'             => '0'
        ];

        $callback = function() use ($logs) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['ID', 'Timestamp', 'Admin', 'Aktivitas', 'Modul', 'IP Address', 'Detail']);

            foreach ($logs as $log) {
                $adminName = $log->admin ? $log->admin->name : 'Unknown';
                fputcsv($file, [
                    $log->id,
                    $log->created_at,
                    $adminName,
                    $log->action,
                    $log->module,
                    $log->ip_address,
                    $log->details ?? $log->detail ?? ''
                ]);
            }
            fclose($file);
        };

        AuditLog::record(
            'EXPORT',
            'Audit Log',
            'Mengekspor riwayat audit log',
            null,
            [
                'adminId' => $request->input('adminId'),
                'user_id' => $request->input('user_id'),
                'action' => $request->input('action'),
                'module' => $request->input('module'),
                'from' => $request->input('from'),
                'to' => $request->input('to'),
                'date_range' => $request->input('date_range'),
            ]
        );

        return response()->stream($callback, 200, $headers);
    }
}
