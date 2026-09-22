<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\AdminStoreBeritaRequest;
use App\Http\Requests\Admin\AdminUpdateBeritaRequest;

class BeritaController extends Controller
{
    public function index(Request $request)
    {
        $query = Berita::query();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('search')) {
            $query->where('title', 'like', '%'.$request->search.'%');
        }

        return $query->orderBy('updated_at', 'desc')->get();
    }

    public function show(Berita $berita)
    {
        return $berita;
    }

    public function recordView(Berita $berita)
    {
        $berita->increment('views');

        return response()->json([
            'id' => $berita->id,
            'views' => $berita->fresh()->views,
        ]);
    }

    public function store(AdminStoreBeritaRequest $request)
    {
        $data = $request->validated();

        $data['created_by'] = auth('admin')->id();
        $data['status'] = $data['status'] ?? 'draft';

        $berita = Berita::create($data);

        AuditLog::record(
            'Create',
            'Konten Website',
            'Membuat berita "'.$berita->title.'"',
            [],
            $berita->getChanges()
        );

        return response()->json($berita, 201);
    }

    public function update(AdminUpdateBeritaRequest $request, Berita $berita)
    {
        $data = $request->validated();

        $oldValues = $berita->getOriginal();
        $berita->update($data);

        AuditLog::record(
            'Update',
            'Konten Website',
            'Mengubah berita "'.$berita->title.'"',
            $oldValues,
            $berita->getChanges()
        );

        return $berita;
    }

    public function destroy(Berita $berita)
    {
        $snapshot = $berita->toArray();
        $title = $berita->title;
        $berita->delete();

        AuditLog::record('Delete', 'Konten Website', 'Menghapus berita "'.$title.'"', $snapshot);

        return response()->json(['ok' => true]);
    }
}
