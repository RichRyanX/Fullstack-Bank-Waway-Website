<?php

namespace App\Services;

use App\Models\AuditLog;
use App\Models\Berita;
use App\Models\ComplianceReport;
use App\Models\Laporan;
use App\Models\SupportTicket;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class DashboardService
{
    public function getDashboardPayload(): array
    {
        $totalBerita = Berita::count();
        $totalLaporan = Laporan::count();
        $beritaTerbit = Berita::where('status', 'published')->count();
        $beritaDraft = Berita::where('status', 'draft')->count();
        $totalReports = ComplianceReport::count();
        $publishedReports = ComplianceReport::where('status', 'PUBLISHED')->count();
        $draftReports = ComplianceReport::where('status', 'DRAFT')->count();
        $archivedReports = ComplianceReport::where('status', 'ARCHIVED')->count();

        return [
            'total_berita' => $totalBerita,
            'total_laporan' => $totalLaporan,
            'total_reports' => $totalReports,
            'published_reports_count' => $publishedReports,
            'draft_reports_count' => $draftReports,
            'archived_reports_count' => $archivedReports,
            'content_stats' => $this->buildContentStats($beritaTerbit, $beritaDraft, $totalReports, $publishedReports, $draftReports, $archivedReports),
            'recent_logs' => $this->getRecentLogs(),
            'activity_chart' => $this->getActivityChart(),
            'brute_force_alerts' => $this->getBruteForceAlerts(),
            'log_health' => $this->getLogHealth(),
            'storage_metrics' => $this->getStorageMetrics(),
            'ticket_metrics' => $this->getTicketMetrics(),
        ];
    }

    protected function buildContentStats(
        int $beritaTerbit,
        int $beritaDraft,
        int $totalReports,
        int $publishedReports,
        int $draftReports,
        int $archivedReports
    ): array {
        return [
            'berita_terbit' => $beritaTerbit,
            'berita_draft' => $beritaDraft,
            'laporan_publikasi' => $totalReports,
            'total_reports' => $totalReports,
            'published_reports_count' => $publishedReports,
            'draft_reports_count' => $draftReports,
            'archived_reports_count' => $archivedReports,
        ];
    }

    protected function getRecentLogs()
    {
        return AuditLog::with('admin')->latest()->take(5)->get();
    }

    protected function getActivityChart(): array
    {
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

        return [
            'labels' => $chartLabels,
            'data' => $chartData,
        ];
    }

    protected function getBruteForceAlerts()
    {
        $windowStart = Carbon::now('UTC')->subMinutes(5);
        $acknowledgedIps = session('acknowledged_threat_ips', []);

        return AuditLog::select('ip_address')
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
    }

    protected function getLogHealth(): array
    {
        $totalLogs = AuditLog::count();
        $latestLog = AuditLog::latest('created_at')->first();
        $estimatedBytes = $totalLogs * 2048;
        $estimatedMb = round($estimatedBytes / 1048576, 2);

        return [
            'total_logs' => $totalLogs,
            'estimated_storage_mb' => $estimatedMb,
            'latest_log_at' => $latestLog ? $latestLog->created_at : null,
        ];
    }

    protected function getStorageMetrics(): array
    {
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

        return [
            'used_bytes' => $usedBytes,
            'used_storage' => $this->formatStorageSize($usedBytes),
            'quota_bytes' => $storageQuotaBytes,
            'quota_storage' => $this->formatStorageSize($storageQuotaBytes),
            'usage_percentage' => $usagePercentage,
            'status' => $statusLabel,
            'document_count' => $documentCount,
        ];
    }

    protected function getTicketMetrics(): array
    {
        $baru = SupportTicket::where('status', 'BARU')->count();
        $diproses = SupportTicket::where('status', 'DIPROSES')->count();
        $selesai = SupportTicket::where('status', 'SELESAI')->count();

        return [
            'baru' => $baru,
            'diproses' => $diproses,
            'selesai' => $selesai,
            'total' => $baru + $diproses + $selesai,
        ];
    }

    protected function formatStorageSize($bytes): string
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
}