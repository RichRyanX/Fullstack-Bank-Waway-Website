<?php

namespace App\Http\Controllers\Admin;

use App\Models\Setting;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;
use App\Http\Requests\Admin\UpdatePengaturanRequest;

class PengaturanController extends BaseAdminController
{
    public function index()
    {
        return $this->view('pengaturan');
    }

    public function show()
    {
        return Setting::firstOrCreate(['id' => 1]);
    }

    public function update(UpdatePengaturanRequest $request)
    {
        $data = $request->validated();

        $setting = Setting::firstOrCreate(['id' => 1]);
        $oldValues = $setting->getOriginal();
        $setting->update($data);

        AuditLog::record(
            'Update',
            'Pengaturan',
            'Memperbarui pengaturan situs',
            $oldValues,
            $setting->getChanges()
        );

        return $setting;
    }

    public function toggleMaintenance(Request $request)
    {
        $status = $request->boolean('status');
        $downFile = storage_path('framework/down');
        $frameworkDir = storage_path('framework');
        if (!File::exists($frameworkDir)) {
            File::makeDirectory($frameworkDir, 0755, true);
        }
        try {
            if ($status) {
                Artisan::call('down', ['--secret' => 'admin-bypass']);
            } else {
                Artisan::call('up');
            }
        } catch (\Exception $e) {
            \Log::error('Artisan maintenance command failed: ' . $e->getMessage());
        }
        if ($status) {
            if (!File::exists($downFile)) {
                File::put($downFile, json_encode(['secret' => 'admin-bypass', 'time' => time()]));
            }
            \Log::info('Maintenance ON: down file created at ' . $downFile . ', exists: ' . (File::exists($downFile) ? 'yes' : 'no'));
        } else {
            if (File::exists($downFile)) {
                File::delete($downFile);
            }
            \Log::info('Maintenance OFF: down file deleted');
        }
        return response()->json(['success' => true, 'maintenance' => $status]);
    }

    public function clearCache()
    {
        try {
            Artisan::call('cache:clear');
            Artisan::call('config:clear');
            Artisan::call('route:clear');
            Artisan::call('view:clear');
            return response()->json(['success' => true, 'message' => 'Cache berhasil dibersihkan']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function createBackup()
    {
        try {
            $backupName = 'backup-' . date('Y-m-d-His') . '.sqlite';
            $dbPath = database_path('database.sqlite');
            $backupPath = storage_path('app/backups/' . $backupName);

            if (!File::exists(storage_path('app/backups'))) {
                File::makeDirectory(storage_path('app/backups'), 0755, true);
            }

            if (File::exists($dbPath)) {
                File::copy($dbPath, $backupPath);
                return response()->json([
                    'success' => true,
                    'message' => 'Backup berhasil dibuat',
                    'filename' => $backupName
                ]);
            }

            return response()->json(['success' => false, 'message' => 'Database file tidak ditemukan'], 404);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function downloadBackup($filename)
    {
        $backupPath = storage_path('app/backups/' . $filename);
        if (File::exists($backupPath)) {
            return response()->download($backupPath);
        }
        abort(404, 'File backup tidak ditemukan');
    }
}
