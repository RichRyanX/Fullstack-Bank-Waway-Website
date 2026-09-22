<?php

namespace App\Services\Public;

use App\Models\AuditLog;
use App\Models\ProductApplication;
use Illuminate\Http\Request;

class ApplicationService
{
    public const PRODUCT_TYPES = ['kredit', 'deposito', 'tabungan'];

    public function applicationRules(): array
    {
        return [
            'product_type' => 'required|string|in:' . implode(',', self::PRODUCT_TYPES),
            'product_id' => 'nullable|integer',
            'product_name' => 'nullable|string|max:255',
            'amount' => 'required|numeric|min:100000',
            'tenure' => 'required|integer|min:1|max:360',
            'applicant_name' => 'required|string|max:150',
            'nik' => 'required|string|size:16|regex:/^[0-9]+$/',
            'phone' => 'required|string|max:30|regex:/^[0-9\+\-\(\)\s]+$/',
            'email' => 'required|email|max:255',
            'address' => 'nullable|string|max:500',
            'notes' => 'nullable|string|max:2000',
        ];
    }

    public function sanitize(array $payload): array
    {
        $fields = ['product_type', 'product_id', 'product_name', 'amount', 'tenure', 'applicant_name', 'nik', 'phone', 'email', 'address', 'notes'];

        foreach ($fields as $field) {
            $value = $payload[$field] ?? null;

            if ($field === 'product_id') {
                $payload[$field] = $value !== null && $value !== '' ? (int) $value : null;
                continue;
            }

            if ($field === 'amount') {
                $payload[$field] = $value !== null ? round((float) $value, 2) : null;
                continue;
            }

            if ($field === 'tenure') {
                $payload[$field] = $value !== null ? (int) $value : null;
                continue;
            }

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

    public function createApplication(array $payload, Request $request): ProductApplication
    {
        $payload = $this->sanitize($payload);

        $number = str_pad((string) (ProductApplication::max('id') + 1), 5, '0', STR_PAD_LEFT);
        $applicationCode = 'PG-' . date('Y') . '-U' . $number;

        $application = ProductApplication::create([
            'application_code' => $applicationCode,
            'product_id' => $payload['product_id'] ?? null,
            'product_name' => $payload['product_name'] ?? null,
            'product_type' => $payload['product_type'],
            'amount' => $payload['amount'],
            'tenure' => $payload['tenure'],
            'applicant_name' => $payload['applicant_name'],
            'nik' => $payload['nik'],
            'phone' => $payload['phone'],
            'email' => $payload['email'],
            'address' => $payload['address'] ?? null,
            'notes' => $payload['notes'] ?? null,
            'status' => 'BARU',
        ]);

        AuditLog::create([
            'admin_id' => null,
            'document_id' => null,
            'action' => 'PUBLIC_PRODUCT_APPLICATION_CREATED',
            'module' => 'Pengajuan Produk',
            'detail' => 'Pengajuan produk online baru dari ' . $payload['applicant_name'] . ': ' . $payload['product_type'],
            'ip_address' => $request->ip(),
            'old_values' => [],
            'new_values' => [
                'application_code' => $applicationCode,
                'product_type' => $payload['product_type'],
                'applicant_name' => $payload['applicant_name'],
                'amount' => $payload['amount'],
            ],
            'user_agent' => $request->userAgent(),
            'method' => $request->method(),
            'route' => $request->path(),
            'session_id' => $request->session()->getId(),
            'auth_guard' => 'public',
        ]);

        return $application;
    }

    public function allProductTypes(): array
    {
        return self::PRODUCT_TYPES;
    }
}
