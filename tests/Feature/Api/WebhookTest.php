<?php

namespace Tests\Feature\Api;

use App\Models\AuditLog;
use App\Models\ProductApplication;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WebhookTest extends TestCase
{
    use RefreshDatabase;

    private const WEBHOOK_SECRET = 'bank-waway-test-webhook-secret';

    protected function setUp(): void
    {
        parent::setUp();

        config(['services.webhook.secret' => self::WEBHOOK_SECRET]);
    }

    private function webhookEndpoint(): string
    {
        return route('api.webhooks.product-application');
    }

    private function validPayload(array $overrides = []): array
    {
        return array_merge([
            'product_type' => 'kredit',
            'product_id' => 1,
            'product_name' => 'Kredit Pegawai',
            'amount' => 50000000,
            'tenure' => 60,
            'applicant_name' => 'Budi Santoso',
            'nik' => '1234567890123456',
            'phone' => '081234567890',
            'email' => 'budi.santoso@example.com',
            'address' => 'Jl. Merdeka No. 1, Bandar Lampung',
            'notes' => 'Pengajuan kredit pegawai via webhook',
        ], $overrides);
    }

    private function hmacSignature(array $payload, ?string $secret = null): string
    {
        $secret = $secret ?? self::WEBHOOK_SECRET;

        return hash_hmac('sha256', json_encode($payload), $secret);
    }

    public function test_valid_webhook_with_hmac_signature_creates_application_and_audit_log(): void
    {
        $payload = $this->validPayload();

        $response = $this->postJson(
            $this->webhookEndpoint(),
            $payload,
            [
                'X-Webhook-Signature' => $this->hmacSignature($payload),
                'Accept' => 'application/json',
            ]
        );

        $response->assertStatus(201)
            ->assertJson([
                'success' => true,
                'message' => 'Application received.',
            ])
            ->assertJsonStructure(['application_code']);

        $application = ProductApplication::first();
        $this->assertDatabaseCount('product_applications', 1);
        $this->assertSame('PG-' . date('Y') . '-W00001', $application->application_code);
        $this->assertSame('kredit', $application->product_type);
        $this->assertSame('Budi Santoso', $application->applicant_name);
        $this->assertSame('1234567890123456', $application->nik);
        $this->assertSame('081234567890', $application->phone);
        $this->assertSame('budi.santoso@example.com', $application->email);
        $this->assertSame('BARU', $application->status);
        $this->assertSame($response->json('application_code'), $application->application_code);

        $this->assertDatabaseCount('audit_logs', 1);
        $log = AuditLog::first();
        $this->assertSame('WEBHOOK_PRODUCT_APPLICATION_CREATED', $log->action);
        $this->assertSame('Pengajuan Produk', $log->module);
        $this->assertSame($application->id, $log->document_id);
        $this->assertSame('webhook', $log->auth_guard);
        $this->assertNull($log->admin_id);
        $this->assertSame($application->application_code, $log->new_values['application_code']);
    }

    public function test_valid_webhook_with_token_header_is_accepted(): void
    {
        $payload = $this->validPayload();

        $response = $this->postJson(
            $this->webhookEndpoint(),
            $payload,
            [
                'X-Webhook-Token' => self::WEBHOOK_SECRET,
                'Accept' => 'application/json',
            ]
        );

        $response->assertStatus(201)->assertJson(['success' => true]);
        $this->assertDatabaseCount('product_applications', 1);
        $this->assertDatabaseCount('audit_logs', 1);
    }

    public function test_valid_webhook_with_bearer_authorization_is_accepted(): void
    {
        $payload = $this->validPayload();

        $response = $this->postJson(
            $this->webhookEndpoint(),
            $payload,
            [
                'Authorization' => 'Bearer ' . self::WEBHOOK_SECRET,
                'Accept' => 'application/json',
            ]
        );

        $response->assertStatus(201)->assertJson(['success' => true]);
        $this->assertDatabaseCount('product_applications', 1);
        $this->assertDatabaseCount('audit_logs', 1);
    }

    public function test_missing_signature_returns_401(): void
    {
        $response = $this->postJson(
            $this->webhookEndpoint(),
            $this->validPayload(),
            ['Accept' => 'application/json']
        );

        $response->assertStatus(401)
            ->assertJson([
                'success' => false,
                'message' => 'Unauthorized webhook request.',
            ]);

        $this->assertDatabaseCount('product_applications', 0);
        $this->assertDatabaseCount('audit_logs', 0);
    }

    public function test_invalid_signature_returns_401(): void
    {
        $response = $this->postJson(
            $this->webhookEndpoint(),
            $this->validPayload(),
            [
                'X-Webhook-Signature' => 'invalid-signature-value',
                'Accept' => 'application/json',
            ]
        );

        $response->assertStatus(401)
            ->assertJson([
                'success' => false,
                'message' => 'Unauthorized webhook request.',
            ]);

        $this->assertDatabaseCount('product_applications', 0);
        $this->assertDatabaseCount('audit_logs', 0);
    }

    public function test_signature_computed_with_wrong_secret_returns_401(): void
    {
        $payload = $this->validPayload();

        $response = $this->postJson(
            $this->webhookEndpoint(),
            $payload,
            [
                'X-Webhook-Signature' => $this->hmacSignature($payload, 'wrong-secret'),
                'Accept' => 'application/json',
            ]
        );

        $response->assertStatus(401);
        $this->assertDatabaseCount('product_applications', 0);
    }

    public function test_unconfigured_secret_returns_503(): void
    {
        config(['services.webhook.secret' => '']);

        $response = $this->postJson(
            $this->webhookEndpoint(),
            $this->validPayload(),
            [
                'X-Webhook-Token' => '',
                'Accept' => 'application/json',
            ]
        );

        $response->assertStatus(503)
            ->assertJson([
                'success' => false,
                'message' => 'Webhook is not configured.',
            ]);

        $this->assertDatabaseCount('product_applications', 0);
        $this->assertDatabaseCount('audit_logs', 0);
    }

    public function test_nik_with_invalid_length_returns_422(): void
    {
        $response = $this->postJson(
            $this->webhookEndpoint(),
            $this->validPayload(['nik' => '123456789012345']),
            [
                'X-Webhook-Signature' => $this->hmacSignature($this->validPayload(['nik' => '123456789012345'])),
                'Accept' => 'application/json',
            ]
        );

        $response->assertStatus(422)
            ->assertJsonValidationErrors('nik');

        $this->assertDatabaseCount('product_applications', 0);
    }

    public function test_nik_with_non_numeric_characters_returns_422(): void
    {
        $response = $this->postJson(
            $this->webhookEndpoint(),
            $this->validPayload(['nik' => '123456789012345a']),
            [
                'X-Webhook-Signature' => $this->hmacSignature($this->validPayload(['nik' => '123456789012345a'])),
                'Accept' => 'application/json',
            ]
        );

        $response->assertStatus(422)
            ->assertJsonValidationErrors('nik');

        $this->assertDatabaseCount('product_applications', 0);
    }

    public function test_phone_with_invalid_characters_returns_422(): void
    {
        $response = $this->postJson(
            $this->webhookEndpoint(),
            $this->validPayload(['phone' => '08123#invalid']),
            [
                'X-Webhook-Signature' => $this->hmacSignature($this->validPayload(['phone' => '08123#invalid'])),
                'Accept' => 'application/json',
            ]
        );

        $response->assertStatus(422)
            ->assertJsonValidationErrors('phone');

        $this->assertDatabaseCount('product_applications', 0);
    }

    public function test_missing_required_fields_returns_422(): void
    {
        $body = ['product_type' => 'kredit'];

        $response = $this->postJson(
            $this->webhookEndpoint(),
            $body,
            [
                'X-Webhook-Signature' => $this->hmacSignature($body),
                'Accept' => 'application/json',
            ]
        );

        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                'amount',
                'tenure',
                'applicant_name',
                'nik',
                'phone',
                'email',
            ]);

        $this->assertDatabaseCount('product_applications', 0);
    }

    public function test_invalid_product_type_returns_422(): void
    {
        $payload = $this->validPayload(['product_type' => 'asuransi']);

        $response = $this->postJson(
            $this->webhookEndpoint(),
            $payload,
            [
                'X-Webhook-Signature' => $this->hmacSignature($payload),
                'Accept' => 'application/json',
            ]
        );

        $response->assertStatus(422)
            ->assertJsonValidationErrors('product_type');

        $this->assertDatabaseCount('product_applications', 0);
    }

    public function test_amount_below_minimum_returns_422(): void
    {
        $payload = $this->validPayload(['amount' => 99999]);

        $response = $this->postJson(
            $this->webhookEndpoint(),
            $payload,
            [
                'X-Webhook-Signature' => $this->hmacSignature($payload),
                'Accept' => 'application/json',
            ]
        );

        $response->assertStatus(422)
            ->assertJsonValidationErrors('amount');

        $this->assertDatabaseCount('product_applications', 0);
    }

    public function test_invalid_email_returns_422(): void
    {
        $payload = $this->validPayload(['email' => 'not-an-email']);

        $response = $this->postJson(
            $this->webhookEndpoint(),
            $payload,
            [
                'X-Webhook-Signature' => $this->hmacSignature($payload),
                'Accept' => 'application/json',
            ]
        );

        $response->assertStatus(422)
            ->assertJsonValidationErrors('email');

        $this->assertDatabaseCount('product_applications', 0);
    }

    public function test_tenure_out_of_range_returns_422(): void
    {
        $payload = $this->validPayload(['tenure' => 400]);

        $response = $this->postJson(
            $this->webhookEndpoint(),
            $payload,
            [
                'X-Webhook-Signature' => $this->hmacSignature($payload),
                'Accept' => 'application/json',
            ]
        );

        $response->assertStatus(422)
            ->assertJsonValidationErrors('tenure');

        $this->assertDatabaseCount('product_applications', 0);
    }
}
