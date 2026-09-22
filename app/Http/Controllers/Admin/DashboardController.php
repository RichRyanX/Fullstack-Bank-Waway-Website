<?php

namespace App\Http\Controllers\Admin;

use App\Services\DashboardService;
use App\Models\Berita;
use App\Models\Laporan;
use App\Models\AuditLog;
use App\Models\ComplianceReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class DashboardController extends BaseAdminController
{
    protected DashboardService $dashboardService;

    public function __construct(DashboardService $dashboardService)
    {
        $this->dashboardService = $dashboardService;
    }

    public function index()
    {
        $payload = $this->dashboardService->getDashboardPayload();

        return $this->view('dashboard', [
            'totalBerita' => $payload['total_berita'],
            'totalLaporan' => $payload['total_laporan'],
            'totalReports' => $payload['total_reports'],
            'publishedReportsCount' => $payload['published_reports_count'],
            'draftReportsCount' => $payload['draft_reports_count'],
            'archivedReportsCount' => $payload['archived_reports_count'],
            'contentStats' => $payload['content_stats'],
            'recentLogs' => $payload['recent_logs'],
            'activityChart' => $payload['activity_chart'],
            'bruteForceAlerts' => $payload['brute_force_alerts'],
            'logHealth' => $payload['log_health'],
            'storageMetrics' => $payload['storage_metrics'],
            'ticketMetrics' => $payload['ticket_metrics'],
        ]);
    }

    public function apiIndex()
    {
        $totalBerita = Berita::count();
        $totalLaporan = Laporan::count();
        $beritaTerbit = Berita::where('status', 'published')->count();
        $beritaDraft = Berita::where('status', 'draft')->count();
        $totalReports = ComplianceReport::count();
        $publishedReports = ComplianceReport::where('status', 'PUBLISHED')->count();
        $draftReports = ComplianceReport::where('status', 'DRAFT')->count();
        $archivedReports = ComplianceReport::where('status', 'ARCHIVED')->count();
        $contentStats = [
            'berita_terbit' => $beritaTerbit,
            'berita_draft' => $beritaDraft,
            'laporan_publikasi' => $totalReports,
            'total_reports' => $totalReports,
            'published_reports_count' => $publishedReports,
            'draft_reports_count' => $draftReports,
            'archived_reports_count' => $archivedReports,
        ];
        $recentLogs = AuditLog::with('admin')->latest()->take(5)->get();

        $windowStartDate = Carbon::today()->subDays(6);
        $windowEndDate = Carbon::today();
        $activityRows = AuditLog::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->whereDate('created_at', '>=', $windowStartDate)
            ->whereDate('created_at', '<=', $windowEndDate)
            ->groupBy('date')
            ->orderBy('date', 'ASC')
            ->pluck('count', 'date');

        $chartLabels = [];
        $chartData = [];
        for ($i = 0; $i < 7; $i++) {
            $date = $windowStartDate->copy()->addDays($i);
            $key = $date->toDateString();
            $chartLabels[] = $key;
            $chartData[] = (int) ($activityRows[$key] ?? 0);
        }
        $activityChart = [
            'labels' => $chartLabels,
            'data' => $chartData,
        ];

        $windowStart = Carbon::now('UTC')->subMinutes(5);
        $acknowledgedIps = session('acknowledged_threat_ips', []);

        $bruteForceAlerts = AuditLog::select('ip_address')
            ->selectRaw('COUNT(*) as attempt_count')
            ->selectRaw('MAX(created_at) as last_attempt')
            ->where('action', 'LOGIN_FAILED')
            ->where('created_at', '>=', $windowStart)
            ->when(count($acknowledgedIps) > 0, function ($query) use ($acknowledgedIps) {
                $query->whereNotIn('ip_address', $acknowledgedIps);
            })
            ->groupBy('ip_address')
            ->havingRaw('COUNT(*) >= ?', [5])
            ->orderByDesc('last_attempt')
            ->get()
            ->map(function ($row) {
                return (object) [
                    'ip_address' => $row->ip_address,
                    'attempt_count' => (int) $row->attempt_count,
                    'last_attempt' => $row->last_attempt
                        ? \Illuminate\Support\Carbon::parse($row->last_attempt)->toIso8601String()
                        : null,
                ];
            })
            ->values();

        $totalLogs = AuditLog::count();
        $latestLog = AuditLog::latest('created_at')->first();
        $estimatedBytes = $totalLogs * 2048;
        $estimatedMb = round($estimatedBytes / 1048576, 2);
        $logHealth = [
            'total_logs' => $totalLogs,
            'estimated_storage_mb' => $estimatedMb,
            'latest_log_at' => $latestLog ? $latestLog->created_at : null,
        ];

        $storageQuotaBytes = (int) config('compliance.storage_quota_bytes', 2 * 1024 * 1024 * 1024);
        $usedBytes = 0;
        $documentCount = 0;
        $reports = ComplianceReport::whereNotNull('file_path')->get(['file_path']);
        foreach ($reports as $report) {
            $documentCount++;
            $path = $report->file_path;
            if (Storage::disk('public')->exists($path)) {
                $usedBytes += (int) Storage::disk('public')->size($path);
            }
        }
        $usagePercentage = $storageQuotaBytes > 0
            ? round(($usedBytes / $storageQuotaBytes) * 100, 2)
            : 0;
        $statusLabel = $usagePercentage >= 80 ? 'Peringatan' : 'Optimal';
        $storageMetrics = [
            'used_bytes' => $usedBytes,
            'used_storage' => $this->formatStorageSize($usedBytes),
            'quota_bytes' => $storageQuotaBytes,
            'quota_storage' => $this->formatStorageSize($storageQuotaBytes),
            'usage_percentage' => $usagePercentage,
            'status' => $statusLabel,
            'document_count' => $documentCount,
        ];

        return response()->json([
            'total_berita' => $totalBerita,
            'total_laporan' => $totalLaporan,
            'total_reports' => $totalReports,
            'published_reports_count' => $publishedReports,
            'draft_reports_count' => $draftReports,
            'archived_reports_count' => $archivedReports,
            'content_stats' => $contentStats,
            'recent_logs' => $recentLogs,
            'activity_chart' => $activityChart,
            'brute_force_alerts' => $bruteForceAlerts,
            'log_health' => $logHealth,
            'storage_metrics' => $storageMetrics,
        ]);
    }

    protected function formatStorageSize($bytes)
    {
        $bytes = (float) $bytes;
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $i = 0;
        while ($bytes >= 1024 && $i < count($units) - 1) {
            $bytes /= 1024;
            $i++;
        }
        return round($bytes, 1) . ' ' . $units[$i];
    }

    public function acknowledgeThreat(Request $request)
    {
        $ip = $request->input('ip');
        if (!$ip) {
            return response()->json(['success' => false, 'message' => 'IP address is required.'], 422);
        }

        $acknowledged = session('acknowledged_threat_ips', []);
        if (!in_array($ip, $acknowledged)) {
            $acknowledged[] = $ip;
            session(['acknowledged_threat_ips' => $acknowledged]);
        }

        return response()->json(['success' => true, 'message' => 'Threat acknowledged.']);
    }
}
