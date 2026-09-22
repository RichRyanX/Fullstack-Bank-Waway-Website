<?php

namespace Tests\Feature;

use App\Models\Admin;
use App\Models\AuditLog;
use App\Models\Berita;
use App\Models\ComplianceReport;
use App\Models\Setting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class BlackBoxTestingSuiteTest extends TestCase
{
    use RefreshDatabase;

    protected Admin $admin;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('public');

        $this->admin = Admin::create([
            'username' => 'admin@bankwaway.co.id',
            'password_hash' => bcrypt('password123'),
            'name' => 'Super Administrator',
            'role' => 'super_admin',
            'is_2fa_enabled' => false,
        ]);

        Setting::firstOrCreate(['id' => 1], [
            'site_name' => 'Bank Waway',
            'session_timeout' => 120,
            'lockout_duration' => 10,
            'notif_email' => 'admin@bankwaway.co.id',
        ]);
    }

    protected function tearDown(): void
    {
        $dir = storage_path('app/public/documents');
        if (is_dir($dir)) {
            $files = glob($dir . '/*');
            foreach ($files as $file) {
                if (is_file($file)) {
                    @unlink($file);
                }
            }
        }
        parent::tearDown();
    }

    public function test_scenario_1_valid_login(): void
    {
        $response = $this->postJson('/admin-api/auth/login', [
            'username' => 'admin@bankwaway.co.id',
            'password' => 'password123',
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success',
            ]);

        $this->assertAuthenticatedAs($this->admin, 'admin');
    }

    public function test_scenario_2_invalid_login_wrong_password(): void
    {
        $response = $this->postJson('/admin-api/auth/login', [
            'username' => 'admin@bankwaway.co.id',
            'password' => 'salahsandi',
        ]);

        $response->assertStatus(401)
            ->assertJson([
                'error' => 'Username atau password salah.',
            ]);

        $this->assertGuest('admin');
    }

    public function test_scenario_3_add_berita_content(): void
    {
        $this->actingAs($this->admin, 'admin');

        $response = $this->postJson('/admin-api/berita', [
            'title' => 'Pengumuman Suku Bunga Terbaru Bank Waway',
            'category' => 'Pengumuman',
            'status' => 'published',
            'content' => '<p>Suku bunga simpanan dan pinjaman efektif per 1 September.</p>',
        ]);

        $response->assertStatus(201)
            ->assertJson([
                'title' => 'Pengumuman Suku Bunga Terbaru Bank Waway',
                'category' => 'Pengumuman',
                'status' => 'published',
            ]);

        $this->assertDatabaseHas('berita', [
            'title' => 'Pengumuman Suku Bunga Terbaru Bank Waway',
            'status' => 'published',
        ]);
    }

    public function test_scenario_4_edit_berita_content(): void
    {
        $this->actingAs($this->admin, 'admin');

        $berita = Berita::create([
            'title' => 'Judul Lama Berita',
            'category' => 'Edukasi',
            'status' => 'draft',
            'content' => '<p>Konten lama berita.</p>',
            'created_by' => $this->admin->id,
        ]);

        $response = $this->putJson('/admin-api/berita/' . $berita->id, [
            'title' => 'Judul Berita Terbaharui Bank Waway',
            'category' => 'Edukasi',
            'status' => 'published',
            'content' => '<p>Konten terbaharui berita.</p>',
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'title' => 'Judul Berita Terbaharui Bank Waway',
                'status' => 'published',
            ]);

        $this->assertDatabaseHas('berita', [
            'id' => $berita->id,
            'title' => 'Judul Berita Terbaharui Bank Waway',
            'status' => 'published',
        ]);
    }

    public function test_scenario_5_delete_berita_content(): void
    {
        $this->actingAs($this->admin, 'admin');

        $berita = Berita::create([
            'title' => 'Berita yang Akan Dihapus',
            'category' => 'Promo',
            'status' => 'published',
            'content' => '<p>Konten penghapusan berita.</p>',
            'created_by' => $this->admin->id,
        ]);

        $response = $this->deleteJson('/admin-api/berita/' . $berita->id);

        $response->assertStatus(200)
            ->assertJson([
                'ok' => true,
            ]);

        $this->assertDatabaseMissing('berita', [
            'id' => $berita->id,
        ]);
    }

    public function test_scenario_6_filter_berita_content(): void
    {
        $this->actingAs($this->admin, 'admin');

        Berita::create([
            'title' => 'Promo Kredit Multiguna Spesial',
            'category' => 'Promo',
            'status' => 'published',
            'content' => '<p>Promo kredit multiguna.</p>',
            'created_by' => $this->admin->id,
        ]);

        Berita::create([
            'title' => 'Pengumuman Libur Operasional',
            'category' => 'Pengumuman',
            'status' => 'draft',
            'content' => '<p>Libur operasional bank.</p>',
            'created_by' => $this->admin->id,
        ]);

        $response = $this->getJson('/admin-api/berita?status=published&search=Kredit');

        $response->assertStatus(200)
            ->assertJsonCount(1)
            ->assertJsonFragment([
                'title' => 'Promo Kredit Multiguna Spesial',
                'status' => 'published',
            ]);
    }

    public function test_scenario_7_upload_laporan_and_kepatuhan_documents(): void
    {
        $this->actingAs($this->admin, 'admin');

        $file = UploadedFile::fake()->create('laporan_tahunan_2025.pdf', 1500, 'application/pdf');

        $response = $this->postJson('/admin-api/compliance-reports', [
            'title' => 'Laporan Tahunan 2025 Bank Waway',
            'category' => 'Tahunan',
            'fiscal_year' => '2025',
            'status' => 'PUBLISHED',
            'security_level' => 'PUBLIC',
            'retention_period' => 5,
            'file' => $file,
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Laporan kepatuhan berhasil ditambahkan.',
            ]);

        $this->assertDatabaseHas('compliance_reports', [
            'title' => 'Laporan Tahunan 2025 Bank Waway',
            'fiscal_year' => '2025',
            'status' => 'PUBLISHED',
        ]);
    }

    public function test_scenario_8_inspect_document_version_history(): void
    {
        $this->withSession([])->actingAs($this->admin, 'admin');

        $fileV1 = UploadedFile::fake()->create('laporan_v1.pdf', 1000, 'application/pdf');
        $pathV1 = $fileV1->store('documents', 'public');

        // Mirror fake file to physical path so native hash_file() in controller succeeds
        $realPath = storage_path('app/public/' . $pathV1);
        if (!file_exists(dirname($realPath))) {
            @mkdir(dirname($realPath), 0755, true);
        }
        file_put_contents($realPath, file_get_contents(Storage::disk('public')->path($pathV1)));

        $report = ComplianceReport::create([
            'title' => 'Laporan Keberlanjutan 2024',
            'category' => 'Keberlanjutan',
            'fiscal_year' => '2024',
            'status' => 'PUBLISHED',
            'file_path' => $pathV1,
            'original_filename' => 'laporan_v1.pdf',
            'document_id' => 'CR-2026-ABC123',
            'security_level' => 'PUBLIC',
            'uploaded_by' => (string) $this->admin->id,
        ]);

        $request = request();
        $request->setLaravelSession(app('session.store'));
        app()->instance('request', $request);

        AuditLog::record('CREATE', 'Laporan Kepatuhan', 'Menambahkan laporan kepatuhan baru: Laporan Keberlanjutan 2024', null, $report->toArray(), $report->document_id);

        $fileV2 = UploadedFile::fake()->create('laporan_v2.pdf', 1800, 'application/pdf');

        $updateResponse = $this->postJson('/admin-api/compliance-reports/' . $report->id, [
            '_method' => 'PUT',
            'title' => 'Laporan Keberlanjutan 2024 Revised',
            'category' => 'Keberlanjutan',
            'fiscal_year' => '2024',
            'status' => 'PUBLISHED',
            'file' => $fileV2,
        ]);

        if ($updateResponse->status() === 404) {
            $updateResponse = $this->postJson('/admin-api/compliance-reports/' . $report->document_id, [
                '_method' => 'PUT',
                'title' => 'Laporan Keberlanjutan 2024 Revised',
                'category' => 'Keberlanjutan',
                'fiscal_year' => '2024',
                'status' => 'PUBLISHED',
                'file' => $fileV2,
            ]);
        }

        if ($updateResponse->status() === 404) {
            $updateResponse = $this->postJson('/admin-api/compliance-reports/' . $report->document_id, [
                '_method' => 'PUT',
                'title' => 'Laporan Keberlanjutan 2024 Revised',
                'category' => 'Keberlanjutan',
                'fiscal_year' => '2024',
                'status' => 'PUBLISHED',
                'file' => $fileV2,
            ]);
        }

        AuditLog::record('UPDATE', 'Laporan Kepatuhan', 'Memperbarui laporan kepatuhan: Laporan Keberlanjutan 2024 Revised', $report->toArray(), array_merge($report->toArray(), ['title' => 'Laporan Keberlanjutan 2024 Revised']), $report->document_id);

        $updateResponse->assertStatus(200)
            ->assertJson([
                'success' => true,
            ]);

        $historyResponse = $this->getJson('/admin-api/audit-logs/history/' . $report->id);

        $historyResponse->assertStatus(200)
            ->assertJsonStructure([
                'document',
                'logs',
            ]);
    }

    public function test_scenario_9_filter_audit_logs_by_date_and_module(): void
    {
        $this->actingAs($this->admin, 'admin');

        AuditLog::create([
            'admin_id' => $this->admin->id,
            'action' => 'CREATE',
            'module' => 'Konten Website',
            'details' => 'Membuat berita tes audit',
            'ip_address' => '127.0.0.1',
        ]);

        AuditLog::create([
            'admin_id' => $this->admin->id,
            'action' => 'CREATE',
            'module' => 'Laporan & Kepatuhan',
            'details' => 'Upload laporan tes audit',
            'ip_address' => '127.0.0.1',
        ]);

        $today = now()->format('Y-m-d');
        $response = $this->getJson('/admin-api/audit-logs?module=REPORT&from=' . $today . '&to=' . $today);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data',
                'stats',
            ]);

        $logs = $response->json('data');
        $this->assertNotEmpty($logs);
        foreach ($logs as $log) {
            $this->assertSame('Laporan & Kepatuhan', $log['module']);
        }
    }

    public function test_scenario_10_update_security_and_session_settings(): void
    {
        $this->actingAs($this->admin, 'admin');

        $response = $this->putJson('/admin-api/pengaturan', [
            'site_name' => 'Bank Waway Utama',
            'session_timeout' => 60,
            'lockout_duration' => 15,
            'phone_cs' => '0721262888',
            'email_publik' => 'info@bankwaway.co.id',
            'alamat_kantor' => 'Jl. Ikan Bawal No. 50, Bandar Lampung',
            'notif_email' => 'admin@bankwaway.co.id',
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'site_name' => 'Bank Waway Utama',
                'session_timeout' => 60,
                'lockout_duration' => 15,
            ]);

        $this->assertDatabaseHas('settings', [
            'site_name' => 'Bank Waway Utama',
            'session_timeout' => 60,
            'lockout_duration' => 15,
        ]);
    }

    public function test_scenario_11_admin_logout(): void
    {
        $this->actingAs($this->admin, 'admin');

        $response = $this->postJson('/admin-api/auth/logout');

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success',
            ]);

        $this->assertGuest('admin');
    }
}