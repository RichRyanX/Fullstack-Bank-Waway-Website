<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\ComplianceReport;
use Illuminate\Support\Facades\Storage;

class ReportController extends Controller
{
    public function index()
    {
        $reports = ComplianceReport::where('status', 'PUBLISHED')
            ->where('category', 'Publikasi')
            ->orderBy('fiscal_year', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();

        $categories = (new \Illuminate\Support\Collection($reports))
            ->pluck('category')
            ->filter()
            ->unique()
            ->values();

        return view('public.laporan.index', [
            'reports' => $reports,
            'categories' => $categories,
        ]);
    }

    public function download(ComplianceReport $complianceReport)
    {
        abort_unless($complianceReport->status === 'PUBLISHED', 404);

        return Storage::disk('public')->download($complianceReport->file_path, $complianceReport->original_filename);
    }
}
