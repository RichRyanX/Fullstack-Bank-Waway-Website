<?php

namespace App\Http\Controllers;

use App\Models\Badge;
use App\Models\AuditLog;
use App\Http\Requests\Admin\AdminStoreBadgeRequest;

class BadgeController extends Controller
{
    public function index()
    {
        return Badge::where('active', true)->get();
    }

    public function store(AdminStoreBadgeRequest $request)
    {
        $data = $request->validated();

        $path = $request->file('logo')->store('badges', 'public');

        $badge = Badge::create([
            'name' => $data['name'],
            'description' => $data['description'] ?? '',
            'logo_path' => $path,
        ]);

        AuditLog::record(
            'Create',
            'Pengaturan',
            'Menambahkan lencana "'.$badge->name.'"',
            [],
            $badge->getChanges()
        );

        return response()->json($badge, 201);
    }

    public function destroy(Badge $badge)
    {
        $snapshot = $badge->toArray();
        $badge->update(['active' => false]);

        AuditLog::record(
            'Delete',
            'Pengaturan',
            'Menghapus lencana "'.$badge->name.'"',
            $snapshot,
            $badge->getChanges()
        );

        return response()->json(['ok' => true]);
    }
}
