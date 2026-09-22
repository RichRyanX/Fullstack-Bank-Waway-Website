<?php

namespace App\Console\Commands;

use App\Models\AuditLog;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class ArchiveAuditLogs extends Command
{
    protected $signature = 'audit:archive';

    protected $description = 'Archive audit logs older than 90 days into compressed JSON and purge them from the database';

    public function handle(): int
    {
        $cutoff = Carbon::now()->subDays(90);
        $logs = AuditLog::query()->where('created_at', '<', $cutoff)->get();

        if ($logs->isEmpty()) {
            $this->info('No audit logs older than 90 days to archive.');
            return self::SUCCESS;
        }

        $grouped = $logs->groupBy(function (AuditLog $log) {
            return $log->created_at->format('Y_m');
        });

        $archivedCount = 0;

        foreach ($grouped as $month => $monthLogs) {
            $payload = $monthLogs->map(function (AuditLog $log) {
                return $log->toArray();
            })->values()->toJson(JSON_PRETTY_PRINT);

            $filename = 'audit_log_' . $month . '.json.gz';
            $path = 'audit_archives/' . $filename;

            Storage::disk('local')->put($path, gzencode($payload, 9));

            $ids = $monthLogs->pluck('id')->all();
            AuditLog::query()->whereIn('id', $ids)->delete();

            $archivedCount += count($ids);
            $this->info('Archived ' . count($ids) . ' logs to ' . $path);
        }

        $this->info('Audit archiving complete. Total archived: ' . $archivedCount);

        return self::SUCCESS;
    }
}