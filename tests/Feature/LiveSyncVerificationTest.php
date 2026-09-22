<?php

namespace Tests\Feature;

use App\Models\Admin;
use App\Models\AuditLog;
use App\Models\Berita;
use App\Models\ComplianceReport;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LiveSyncVerificationTest extends TestCase
{
    use RefreshDatabase;

    private string $marker;
    private int $baselineBeritaCount;
    private int $baselineLaporanCount;
    private int $baselineAuditCount;

    protected function setUp(): void
    {
        parent::setUp();

        $this->marker = 'LIVE-SYNC-VERIFY-' . uniqid();

        Admin::create([
            'username' => 'admin-' . $this->marker,
            'password_hash' => 'password',
            'name' => 'Admin Test',
            'role' => 'super_admin',
        ]);

        $this->baselineBeritaCount = Berita::count();
        $this->baselineLaporanCount = ComplianceReport::count();
        $this->baselineAuditCount = AuditLog::count();
    }

    public function test_cms_content_syncs_immediately_to_public_index_pages(): void
    {
        $beritaTitle = $this->marker . ' Berita Sinkron';
        $laporanTitle = $this->marker . ' Laporan Tahunan';

        $news = Berita::create([
            'title' => $beritaTitle,
            'category' => 'Pengumuman',
            'status' => 'published',
            'content' => '<p>Paragraf satu sinkronisasi.</p><p>Paragraf dua sinkronisasi.</p>',
            'created_by' => 1,
        ]);

        $report = ComplianceReport::create([
            'title' => $laporanTitle,
            'original_filename' => $this->marker . ' Laporan Tahunan.pdf',
            'file_path' => 'laporan/' . $this->marker . '.pdf',
            'file_size' => '1 MB',
            'fiscal_year' => 'FY 2099',
            'category' => 'Publikasi',
            'status' => 'PUBLISHED',
            'uploaded_by' => '1',
        ]);

        $this->assertDatabaseHas('berita', ['id' => $news->id, 'status' => 'published']);
        $this->assertDatabaseHas('compliance_reports', ['id' => $report->id, 'status' => 'PUBLISHED']);

        $newsIndex = $this->get('/berita');
        $newsIndex->assertStatus(200);
        $newsIndex->assertSee($beritaTitle);

        $laporanIndex = $this->get('/laporan');
        $laporanIndex->assertStatus(200);
        $laporanIndex->assertSee($laporanTitle);

        $this->assertGreaterThan($this->baselineBeritaCount, Berita::count());
        $this->assertGreaterThan($this->baselineLaporanCount, ComplianceReport::count());
    }

    public function test_detail_route_helpers_generate_valid_urls_and_render_detail_content(): void
    {
        $beritaTitle = $this->marker . ' Detail Berita';

        $news = Berita::create([
            'title' => $beritaTitle,
            'category' => 'Pengumuman',
            'status' => 'published',
            'content' => '<p>Detail konten terverifikasi.</p>',
            'created_by' => 1,
        ]);

        $report = ComplianceReport::create([
            'title' => $this->marker . ' Laporan Detail',
            'original_filename' => $this->marker . ' Laporan Detail.pdf',
            'file_path' => 'laporan/' . $this->marker . '.pdf',
            'file_size' => '1 MB',
            'fiscal_year' => 'FY 2099',
            'category' => 'Publikasi',
            'status' => 'PUBLISHED',
            'uploaded_by' => '1',
        ]);

        $newsDetailUrl = route('public.berita.show', ['id' => $news->id]);
        $this->assertIsString($newsDetailUrl);
        $this->assertStringContainsString('/berita/' . $news->id, $newsDetailUrl);

        $laporanDownloadUrl = route('public.laporan.download', ['complianceReport' => $report->id]);
        $this->assertIsString($laporanDownloadUrl);
        $this->assertStringContainsString('/laporan/' . $report->id . '/download', $laporanDownloadUrl);

        $detail = $this->get('/berita/' . $news->id);
        $detail->assertStatus(200);
        $detail->assertSee($beritaTitle);
        $detail->assertSee($news->category, false);
        $detail->assertSee('Detail konten terverifikasi.', false);
        $detail->assertSee('Bank Waway', false);
    }

    public function test_cleanup_restores_production_state_and_leaves_no_audit_logs(): void
    {
        $beritaTitle = $this->marker . ' Cleanup Berita';

        $news = Berita::create([
            'title' => $beritaTitle,
            'category' => 'Pengumuman',
            'status' => 'published',
            'content' => '<p>Cleanup verification.</p>',
            'created_by' => 1,
        ]);

        $this->get('/berita/' . $news->id)->assertStatus(200);

        $news->delete();

        $this->assertDatabaseMissing('berita', ['id' => $news->id]);
        $this->get('/berita/' . $news->id)->assertNotFound();
        $this->get('/berita')->assertStatus(200)->assertDontSee($beritaTitle);
        $this->assertSame($this->baselineAuditCount, AuditLog::count());
    }
}
