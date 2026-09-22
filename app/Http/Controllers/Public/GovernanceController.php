<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\ComplianceReport;

class GovernanceController extends Controller
{
    public function laporanTahunan()
    {
        $reports = ComplianceReport::where('status', 'PUBLISHED')
            ->where('category', 'Tahunan')
            ->orderBy('fiscal_year', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('public.laporan.tahunan', ['reports' => $reports]);
    }

    public function laporanKeberlanjutan()
    {
        $reports = ComplianceReport::where('status', 'PUBLISHED')
            ->where('category', 'Keberlanjutan')
            ->orderBy('fiscal_year', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('public.laporan.keberlanjutan', ['reports' => $reports]);
    }

    public function tataKelola()
    {
        $reports = ComplianceReport::where('status', 'PUBLISHED')
            ->where('category', 'Tata Kelola / GCG')
            ->orderBy('fiscal_year', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('public.laporan.tata-kelola', ['reports' => $reports]);
    }

    public function pelayanan()
    {
        $reports = ComplianceReport::where('status', 'PUBLISHED')
            ->where('category', 'Pelayanan')
            ->orderBy('fiscal_year', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('public.laporan.pelayanan', ['reports' => $reports]);
    }
}
