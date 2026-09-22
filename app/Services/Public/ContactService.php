<?php

namespace App\Services\Public;

use App\Models\AuditLog;
use App\Models\SupportTicket;
use Illuminate\Http\Request;

class ContactService
{
    public function inquiryRules(): array
    {
        return [
            'nama' => 'required|string|max:150',
            'email' => 'required|email|max:255',
            'subjek' => 'required|string|max:255',
            'modul' => 'required|string|max:100',
            'pesan' => 'required|string|max:5000',
        ];
    }

    public function sanitize(array $payload): array
    {
        $fields = ['nama', 'email', 'subjek', 'modul', 'pesan'];

        foreach ($fields as $field) {
            $value = $payload[$field] ?? null;

            if ($field === 'email') {
                $payload[$field] = $value !== null ? trim($value) : null;
                continue;
            }

            if (is_string($value)) {
                $payload[$field] = trim(strip_tags($value));
            }
        }

        return $payload;
    }

    public function createInquiry(array $payload, Request $request): SupportTicket
    {
        $payload = $this->sanitize($payload);

        $ticket = SupportTicket::create([
            'ticket_id' => $this->generateTicketId('TK', $request),
            'sender_name' => $payload['nama'],
            'sender_email' => $payload['email'],
            'subjek' => $payload['subjek'],
            'modul' => $payload['modul'],
            'deskripsi' => $payload['pesan'],
            'status' => 'BARU',
        ]);

        AuditLog::create([
            'admin_id' => null,
            'document_id' => null,
            'action' => 'PUBLIC_INQUIRY_CREATED',
            'module' => 'Kontak Publik',
            'detail' => 'Pertanyaan publik baru dari ' . $payload['nama'] . ': ' . $payload['subjek'],
            'ip_address' => $request->ip(),
            'old_values' => [],
            'new_values' => [
                'ticket_id' => $ticket->ticket_id,
                'subjek' => $payload['subjek'],
                'modul' => $payload['modul'],
            ],
            'user_agent' => $request->userAgent(),
            'method' => $request->method(),
            'route' => $request->path(),
            'session_id' => $request->session()->getId(),
            'auth_guard' => 'public',
        ]);

        return $ticket;
    }

    protected function generateTicketId(string $prefix, Request $request): string
    {
        $nextId = (int) SupportTicket::max('id') + 1;

        return $prefix . '-' . date('Y') . '-' . str_pad((string) $nextId, 3, '0', STR_PAD_LEFT);
    }
}
