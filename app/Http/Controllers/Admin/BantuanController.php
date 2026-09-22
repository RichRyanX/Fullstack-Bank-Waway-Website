<?php

namespace App\Http\Controllers\Admin;

use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Http\Request;
use App\Models\AuditLog;
use App\Models\SupportTicket;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Admin\StoreBantuanTicketRequest;
use App\Http\Requests\Admin\UpdateBantuanTicketStatusRequest;

class BantuanController extends BaseAdminController
{
    public function index()
    {
        return $this->view('bantuan');
    }

    public function createTicket(StoreBantuanTicketRequest $request)
    {
        $validated = $request->validated();

        $admin = Auth::guard('admin')->user();

        $nextId = SupportTicket::max('id') + 1;
        $ticketId = 'TK-' . date('Y') . '-' . str_pad($nextId, 3, '0', STR_PAD_LEFT);

        $ticket = SupportTicket::create([
            'sender_name' => $admin ? $admin->name : null,
            'sender_email' => $admin ? $admin->username : null,
            'subjek' => $validated['subjek'],
            'modul' => $validated['modul'],
            'deskripsi' => $validated['deskripsi'],
            'status' => 'BARU',
            'ticket_id' => $ticketId,
        ]);

        AuditLog::record(
            'CREATE_TICKET',
            'Bantuan',
            'Tiket internal dibuat: ' . $ticketId,
            null,
            [
                'ticket_id' => $ticketId,
                'subjek' => $validated['subjek'],
                'modul' => $validated['modul'],
            ]
        );

        return response()->json([
            'success' => true,
            'ticket_id' => $ticketId,
            'message' => 'Tiket berhasil dibuat.',
        ], 200);
    }

    public function apiIndex(Request $request)
    {
        $admin = Auth::guard('admin')->user();

        if (! $admin || $admin->role !== 'super_admin') {
            return response()->json(['error' => 'Unauthorized.'], 403);
        }

        $tickets = SupportTicket::query()
            ->orderByDesc('created_at')
            ->get()
            ->map(function (SupportTicket $ticket) {
                return [
                    'id' => $ticket->id,
                    'ticket_id' => $ticket->ticket_id,
                    'sender_name' => $ticket->sender_name,
                    'sender_email' => $ticket->sender_email,
                    'subjek' => $ticket->subjek,
                    'modul' => $ticket->modul,
                    'deskripsi' => $ticket->deskripsi,
                    'status' => $ticket->status,
                    'created_at' => $ticket->created_at ? $ticket->created_at->format('d M Y H:i') : null,
                ];
            });

        return response()->json([
            'success' => true,
            'tickets' => $tickets,
        ], 200);
    }

    public function updateStatus(UpdateBantuanTicketStatusRequest $request, $id)
    {
        $admin = Auth::guard('admin')->user();

        if (! $admin || $admin->role !== 'super_admin') {
            return response()->json(['error' => 'Unauthorized.'], 403);
        }

        $validated = $request->validated();

        $ticket = SupportTicket::findOrFail($id);
        $oldStatus = $ticket->status;
        $ticket->status = $validated['status'];
        $ticket->save();

        AuditLog::record(
            'UPDATE_TICKET_STATUS',
            'Bantuan',
            'Status tiket ' . $ticket->ticket_id . ' diubah dari ' . $oldStatus . ' menjadi ' . $validated['status'],
            ['status' => $oldStatus],
            ['status' => $validated['status']]
        );

        return response()->json([
            'success' => true,
            'message' => 'Status tiket berhasil diperbarui.',
            'status' => $validated['status'],
        ], 200);
    }

    public function downloadManualBook()
    {
        $pdfContent = $this->buildPdf();
        return response()->streamDownload(function () use ($pdfContent) {
            echo $pdfContent;
        }, 'Buku_Manual_Admin_Bank_Waway.pdf', [
            'Content-Type' => 'application/pdf',
        ]);
    }

    private function buildPdf()
    {
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);

        $dompdf = new Dompdf($options);
        $html = view('pdf.manual_book')->render();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        return $dompdf->output();
    }
}
