<?php

namespace App\Http\Controllers\Admin;

use App\Models\ComplianceReport;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Admin\StoreComplianceReportRequest;
use App\Http\Requests\Admin\UpdateComplianceReportStatusRequest;
use App\Http\Requests\Admin\UpdateComplianceReportRequest;

class LaporanKepatuhanController extends BaseAdminController
{
    public function index()
    {
        return $this->view('laporan-kepatuhan');
    }

    public function apiIndex(Request $request)
    {
        $query = ComplianceReport::query();

        if ($request->filled('sort_order') && $request->input('sort_order') === 'oldest') {
            $query->orderBy('created_at', 'asc');
        } else {
            $query->orderBy('created_at', 'desc');
        }

        if ($request->filled('category')) {
            $query->where('category', $request->input('category'));
        }

        if ($request->filled('status')) {
            $status = strtoupper($request->input('status'));
            if (in_array($status, ['DRAFT', 'PUBLISHED', 'ARCHIVED'], true)) {
                $query->where('status', $status);
            }
        }

        if ($request->filled('year')) {
            $year = preg_replace('/\D/', '', $request->input('year'));
            if (strlen($year) >= 4) {
                $year = substr($year, -4);
                $query->where(function ($q) use ($year) {
                    $q->where('fiscal_year', $year)
                        ->orWhere('fiscal_year', 'like', '%' . $year . '%');
                });
            }
        }

        if ($request->filled('q')) {
            $search = $request->input('q');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                    ->orWhere('original_filename', 'like', '%' . $search . '%')
                    ->orWhere('category', 'like', '%' . $search . '%')
                    ->orWhere('fiscal_year', 'like', '%' . $search . '%');
            });
        }

        $perPage = 5;
        $page = max(1, (int) $request->input('page', 1));

        $paginator = $query->paginate($perPage, ['*'], 'page', $page);

        $reports = $paginator->getCollection()->map(function ($report) {
            $report->retention_period = $report->retention_date
                ? $report->retention_date->format('Y')
                : null;
            $report->security_level = $report->security_level ?? 'INTERNAL CONFIDENTIAL';
            return $report;
        });

        $years = ComplianceReport::query()
            ->whereNotNull('fiscal_year')
            ->where('fiscal_year', '!=', '')
            ->distinct()
            ->orderBy('fiscal_year', 'desc')
            ->pluck('fiscal_year')
            ->values();

        $countQuery = ComplianceReport::query();

        if ($request->filled('category')) {
            $countQuery->where('category', $request->input('category'));
        }

        if ($request->filled('year')) {
            $year = preg_replace('/\D/', '', $request->input('year'));
            if (strlen($year) >= 4) {
                $year = substr($year, -4);
                $countQuery->where(function ($q) use ($year) {
                    $q->where('fiscal_year', $year)
                        ->orWhere('fiscal_year', 'like', '%' . $year . '%');
                });
            }
        }

        if ($request->filled('q')) {
            $search = $request->input('q');
            $countQuery->where(function ($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                    ->orWhere('original_filename', 'like', '%' . $search . '%')
                    ->orWhere('category', 'like', '%' . $search . '%')
                    ->orWhere('fiscal_year', 'like', '%' . $search . '%');
            });
        }

        $totalCount = $countQuery->count();
        $draftCount = (clone $countQuery)->where('status', 'DRAFT')->count();
        $publishedCount = (clone $countQuery)->where('status', 'PUBLISHED')->count();
        $archivedCount = (clone $countQuery)->where('status', 'ARCHIVED')->count();

        return response()->json([
            'success' => true,
            'data' => $reports,
            'current_page' => $paginator->currentPage(),
            'last_page' => $paginator->lastPage(),
            'per_page' => $paginator->perPage(),
            'total' => $paginator->total(),
            'years' => $years,
            'stats' => [
                'total' => $totalCount,
                'draft' => $draftCount,
                'published' => $publishedCount,
                'archived' => $archivedCount,
            ],
        ]);
    }

    public function show($id)
    {
        $report = ComplianceReport::findOrFail($id);
        $report->retention_period = $report->retention_date ? $report->retention_date->format('Y') : null;
        $report->security_level = $report->security_level ?? 'INTERNAL CONFIDENTIAL';

        return response()->json([
            'success' => true,
            'data' => $report,
        ]);
    }

    public function store(StoreComplianceReportRequest $request)
    {
        $status = strtoupper($request->input('status', 'DRAFT'));
        $file = $request->file('file');

        $path = null;
        $originalFilename = null;
        $fileSize = null;
        $mimeType = null;
        $fileHash = null;

        if ($file) {
            $path = $file->store('documents', 'public');
            $originalFilename = $file->getClientOriginalName();
            $fileSize = $file->getSize();
            $mimeType = $file->getMimeType();
            $fullPath = Storage::disk('public')->path($path);
            if (file_exists($fullPath)) {
                $fileHash = hash_file('sha256', $fullPath);
            }
        }

        $fiscalYear = $request->input('fiscal_year');
        if (!$fiscalYear && $file) {
            preg_match('/\b(20\d{2})\b/', $originalFilename, $matches);
            $fiscalYear = $matches[1] ?? (string) date('Y');
        } elseif (!$fiscalYear) {
            $fiscalYear = (string) date('Y');
        }

        $title = $request->input('title');
        if (!$title && $originalFilename) {
            $title = pathinfo($originalFilename, PATHINFO_FILENAME);
        } elseif (!$title) {
            $title = 'Laporan Kepatuhan ' . $fiscalYear;
        }

        $retentionYears = (int) $request->input('retention_period', 5);
        $retentionDate = now()->addYears($retentionYears);

        $report = ComplianceReport::create([
            'title' => $title,
            'category' => $request->input('category', 'Tata Kelola'),
            'fiscal_year' => $fiscalYear,
            'status' => $status,
            'file_path' => $path,
            'original_filename' => $originalFilename,
            'file_size' => $fileSize,
            'mime_type' => $mimeType,
            'file_hash' => $fileHash,
            'document_id' => 'CR-' . date('Y') . '-' . strtoupper(substr(uniqid(), -6)),
            'retention_date' => $retentionDate,
            'security_level' => $request->input('security_level', 'INTERNAL CONFIDENTIAL'),
        ]);

        AuditLog::record(
            'CREATE',
            'Laporan Kepatuhan',
            'Menambahkan laporan kepatuhan baru: ' . $report->title,
            null,
            $report->toArray()
        );

        return response()->json([
            'success' => true,
            'message' => 'Laporan kepatuhan berhasil ditambahkan.',
            'data' => $report,
        ]);
    }

    public function updateStatus(UpdateComplianceReportStatusRequest $request, $id)
    {
        $report = ComplianceReport::findOrFail($id);
        $oldStatus = $report->status;
        $newStatus = strtoupper($request->input('status'));

        $report->status = $newStatus;
        $report->save();

        AuditLog::record(
            'UPDATE_STATUS',
            'Laporan Kepatuhan',
            'Mengubah status laporan ' . $report->title . ' dari ' . $oldStatus . ' menjadi ' . $newStatus,
            ['status' => $oldStatus],
            ['status' => $newStatus]
        );

        return response()->json([
            'success' => true,
            'message' => 'Status laporan berhasil diperbarui.',
            'data' => $report,
        ]);
    }

    public function update(UpdateComplianceReportRequest $request, $id)
    {
        $report = ComplianceReport::findOrFail($id);
        $oldValues = $report->toArray();

        $file = $request->file('file');
        if ($file) {
            if ($report->file_path && Storage::disk('public')->exists($report->file_path)) {
                Storage::disk('public')->delete($report->file_path);
            }

            $path = $file->store('documents', 'public');
            $report->file_path = $path;
            $report->original_filename = $file->getClientOriginalName();
            $report->file_size = $file->getSize();
            $report->mime_type = $file->getMimeType();
            $fullPath = Storage::disk('public')->path($path);
            if (file_exists($fullPath)) {
                $report->file_hash = hash_file('sha256', $fullPath);
            }
        }

        if ($request->filled('title')) {
            $report->title = $request->input('title');
        }
        if ($request->filled('category')) {
            $report->category = $request->input('category');
        }
        if ($request->filled('fiscal_year')) {
            $report->fiscal_year = $request->input('fiscal_year');
        }
        if ($request->filled('status')) {
            $report->status = strtoupper($request->input('status'));
        }
        if ($request->filled('security_level')) {
            $report->security_level = $request->input('security_level');
        }
        if ($request->filled('retention_period')) {
            $retentionYears = (int) $request->input('retention_period');
            $report->retention_date = now()->addYears($retentionYears);
        }

        $report->save();

        AuditLog::record(
            'UPDATE',
            'Laporan Kepatuhan',
            'Memperbarui laporan kepatuhan: ' . $report->title,
            $oldValues,
            $report->toArray()
        );

        return response()->json([
            'success' => true,
            'message' => 'Laporan kepatuhan berhasil diperbarui.',
            'data' => $report,
        ]);
    }

    public function destroy($id)
    {
        $report = ComplianceReport::findOrFail($id);
        $oldValues = $report->toArray();

        if ($report->file_path && Storage::disk('public')->exists($report->file_path)) {
            Storage::disk('public')->delete($report->file_path);
        }

        $report->delete();

        AuditLog::record(
            'DELETE',
            'Laporan Kepatuhan',
            'Menghapus laporan kepatuhan: ' . $oldValues['title'],
            $oldValues,
            null
        );

        return response()->json([
            'success' => true,
            'message' => 'Laporan kepatuhan berhasil dihapus.',
        ]);
    }

    private function formatFileSize($bytes)
    {
        if ($bytes >= 1073741824) {
            return number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            return number_format($bytes / 1024, 2) . ' KB';
        } elseif ($bytes > 1) {
            return $bytes . ' bytes';
        } elseif ($bytes == 1) {
            return '1 byte';
        } else {
            return '0 bytes';
        }
    }
}
