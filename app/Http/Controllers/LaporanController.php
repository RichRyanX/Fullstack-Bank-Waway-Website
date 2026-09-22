<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Admin\AdminStoreLaporanRequest;
use App\Http\Requests\Admin\AdminNewLaporanVersionRequest;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $query = Laporan::where('status', 'active');

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }
        if ($request->filled('tahun')) {
            $query->where('tahun_buku', $request->tahun);
        }

        return $query->orderBy('created_at', 'desc')->get();
    }

    public function history(Laporan $laporan)
    {
        return Laporan::where('root_id', $laporan->root_id)
            ->orderBy('version', 'desc')
            ->get();
    }

    public function store(AdminStoreLaporanRequest $request)
    {
        $data = $request->validated();

        $path = $request->file('file')->store('laporan');

        $laporan = Laporan::create([
            'root_id' => 0,
            'category' => $data['category'],
            'file_name' => $request->file('file')->getClientOriginalName(),
            'file_path' => $path,
            'version' => 1,
            'tahun_buku' => $data['tahun_buku'],
            'uploaded_by' => auth('admin')->id(),
        ]);

        $laporan->update(['root_id' => $laporan->id]);

        AuditLog::record('Create', 'Laporan & Kepatuhan', 'Upload dokumen "'.$laporan->file_name.'"');

        return response()->json($laporan, 201);
    }

    public function newVersion(AdminNewLaporanVersionRequest $request, Laporan $laporan)
    {
        $request->validated();

        $laporan->update(['status' => 'archived']);

        $path = $request->file('file')->store('laporan');

        $newVersion = Laporan::create([
            'root_id' => $laporan->root_id,
            'category' => $laporan->category,
            'file_name' => $request->file('file')->getClientOriginalName(),
            'file_path' => $path,
            'version' => $laporan->version + 1,
            'tahun_buku' => $laporan->tahun_buku,
            'status' => 'active',
            'uploaded_by' => auth('admin')->id(),
        ]);

        AuditLog::record('Update', 'Laporan & Kepatuhan', 'Versi baru untuk "'.$laporan->file_name.'" -> v'.$newVersion->version);

        return response()->json($newVersion, 201);
    }

    public function download(Request $request, Laporan $laporan)
    {
        AuditLog::record(
            'EXPORT',
            'Laporan',
            'Mengunduh laporan "'.$laporan->file_name.'"',
            null,
            [
                'category' => $request->input('category'),
                'tahun' => $request->input('tahun'),
                'file_name' => $laporan->file_name,
                'version' => $laporan->version,
                'tahun_buku' => $laporan->tahun_buku,
            ]
        );

        return Storage::download($laporan->file_path, $laporan->file_name);
    }
}
