<?php

namespace App\Http\Controllers\Admin;

use App\Models\Berita;
use App\Models\Laporan;
use App\Models\AuditLog;
use App\Models\Setting;
use App\Models\Badge;
use Illuminate\Http\Request;

class SearchController extends BaseAdminController
{
    public function index()
    {
        return $this->view('search');
    }

    public function suggest(Request $request)
    {
        $q = trim((string) $request->input('q', ''));
        $limit = (int) $request->input('limit', 12);

        if ($q === '') {
            return response()->json(['suggestions' => []]);
        }

        $suggestions = [];

        Berita::where(function ($query) use ($q) {
            $query->where('title', 'like', '%'.$q.'%')
                ->orWhere('category', 'like', '%'.$q.'%')
                ->orWhere('content', 'like', '%'.$q.'%');
        })
            ->orderBy('updated_at', 'desc')
            ->limit($limit)
            ->get()
            ->each(function ($berita) use (&$suggestions) {
                $suggestions[] = [
                    'type' => 'Berita',
                    'label' => $berita->title,
                    'meta' => 'Konten Website',
                    'href' => route('admin.konten-website', ['q' => $berita->title]),
                ];
            });

        Laporan::where('status', 'active')
            ->where(function ($query) use ($q) {
                $query->where('file_name', 'like', '%'.$q.'%')
                    ->orWhere('category', 'like', '%'.$q.'%')
                    ->orWhere('tahun_buku', 'like', '%'.$q.'%');
            })
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get()
            ->each(function ($laporan) use (&$suggestions) {
                $suggestions[] = [
                    'type' => 'Laporan',
                    'label' => $laporan->file_name,
                    'meta' => 'Laporan & Kepatuhan',
                    'href' => route('admin.laporan-kepatuhan', ['q' => $laporan->file_name]),
                ];
            });

        Setting::where(function ($query) use ($q) {
            $query->where('phone_cs', 'like', '%'.$q.'%')
                ->orWhere('email_publik', 'like', '%'.$q.'%')
                ->orWhere('alamat_kantor', 'like', '%'.$q.'%')
                ->orWhere('whatsapp_url', 'like', '%'.$q.'%')
                ->orWhere('instagram_url', 'like', '%'.$q.'%')
                ->orWhere('x_url', 'like', '%'.$q.'%')
                ->orWhere('facebook_url', 'like', '%'.$q.'%');
        })
            ->get()
            ->each(function ($setting) use (&$suggestions, $q) {
                $fields = [
                    ['label' => 'Nomor Telepon (CS)', 'value' => $setting->phone_cs],
                    ['label' => 'Alamat Email', 'value' => $setting->email_publik],
                    ['label' => 'Alamat Kantor Pusat', 'value' => $setting->alamat_kantor],
                    ['label' => 'WhatsApp', 'value' => $setting->whatsapp_url],
                    ['label' => 'Instagram', 'value' => $setting->instagram_url],
                    ['label' => 'X (Twitter)', 'value' => $setting->x_url],
                    ['label' => 'Facebook', 'value' => $setting->facebook_url],
                ];
                foreach ($fields as $field) {
                    if ($field['value'] && stripos($field['value'], $q) !== false) {
                        $suggestions[] = [
                            'type' => 'Pengaturan',
                            'label' => $field['label'].' — '.$field['value'],
                            'meta' => 'Pengaturan',
                            'href' => route('admin.pengaturan', ['q' => $field['value']]),
                        ];
                    }
                }
            });

        Badge::where(function ($query) use ($q) {
            $query->where('name', 'like', '%'.$q.'%')
                ->orWhere('description', 'like', '%'.$q.'%');
        })
            ->get()
            ->each(function ($badge) use (&$suggestions) {
                $suggestions[] = [
                    'type' => 'Lencana',
                    'label' => $badge->name,
                    'meta' => 'Pengaturan',
                    'href' => route('admin.pengaturan', ['q' => $badge->name]),
                ];
            });

        $staticIndex = $this->staticIndex();
        foreach ($staticIndex as $entry) {
            if (stripos($entry['label'], $q) !== false || stripos($entry['keywords'], $q) !== false) {
                $suggestions[] = [
                    'type' => $entry['type'],
                    'label' => $entry['label'],
                    'meta' => $entry['meta'],
                    'href' => $entry['href'],
                ];
            }
        }

        $suggestions = array_slice($suggestions, 0, $limit);

        return response()->json(['suggestions' => $suggestions]);
    }

    protected function staticIndex(): array
    {
        return [
            ['type' => 'Dashboard', 'label' => 'Total Berita', 'keywords' => 'total berita jumlah berita statistik', 'meta' => 'Dashboard', 'href' => route('admin.dashboard')],
            ['type' => 'Dashboard', 'label' => 'Total Laporan', 'keywords' => 'total laporan jumlah laporan statistik', 'meta' => 'Dashboard', 'href' => route('admin.dashboard')],
            ['type' => 'Dashboard', 'label' => 'Aktivitas Log Terkini', 'keywords' => 'aktivitas log terkini recent logs pengguna aksi modul waktu', 'meta' => 'Dashboard', 'href' => route('admin.dashboard')],
            ['type' => 'Dashboard', 'label' => 'Aktivitas 7 Hari Terakhir', 'keywords' => 'aktivitas chart grafik 7 hari tren', 'meta' => 'Dashboard', 'href' => route('admin.dashboard')],
            ['type' => 'Dashboard', 'label' => 'Aksi Cepat', 'keywords' => 'aksi cepat quick action tambah informasi upload laporan', 'meta' => 'Dashboard', 'href' => route('admin.dashboard')],
            ['type' => 'Dashboard', 'label' => 'Tambah Informasi', 'keywords' => 'tambah informasi quick action berita', 'meta' => 'Dashboard', 'href' => route('admin.dashboard')],
            ['type' => 'Dashboard', 'label' => 'Upload Laporan', 'keywords' => 'upload laporan quick action dokumen', 'meta' => 'Dashboard', 'href' => route('admin.dashboard')],
            ['type' => 'Dashboard', 'label' => 'Peringatan Keamanan (Brute Force)', 'keywords' => 'peringatan keamanan brute force ancaman alert tinjau log reset', 'meta' => 'Dashboard', 'href' => route('admin.dashboard')],
            ['type' => 'Dashboard', 'label' => 'Kapasitas Log & Database Health', 'keywords' => 'kapasitas log database health total log stored arsip otomatis', 'meta' => 'Dashboard', 'href' => route('admin.dashboard')],
            ['type' => 'Dashboard', 'label' => 'Total Log Stored', 'keywords' => 'total log stored entri kapasitas', 'meta' => 'Dashboard', 'href' => route('admin.dashboard')],
            ['type' => 'Dashboard', 'label' => 'Database Health Status', 'keywords' => 'database health status optimal perhatian', 'meta' => 'Dashboard', 'href' => route('admin.dashboard')],
            ['type' => 'Dashboard', 'label' => 'Arsip Otomatis', 'keywords' => 'arsip otomatis auto archive', 'meta' => 'Dashboard', 'href' => route('admin.dashboard')],
            ['type' => 'Dashboard', 'label' => 'Status Publikasi Web', 'keywords' => 'status publikasi web berita terbit draft disimpan laporan compliance', 'meta' => 'Dashboard', 'href' => route('admin.dashboard')],
            ['type' => 'Dashboard', 'label' => 'Berita Terbit', 'keywords' => 'berita terbit published status publikasi', 'meta' => 'Dashboard', 'href' => route('admin.dashboard')],
            ['type' => 'Dashboard', 'label' => 'Draft Disimpan', 'keywords' => 'draft disimpan draft status publikasi', 'meta' => 'Dashboard', 'href' => route('admin.dashboard')],
            ['type' => 'Dashboard', 'label' => 'Laporan Compliance', 'keywords' => 'laporan compliance status publikasi', 'meta' => 'Dashboard', 'href' => route('admin.dashboard')],

            ['type' => 'Konten', 'label' => 'Kelola Informasi & Berita', 'keywords' => 'kelola informasi berita konten website pengumuman promo edukasi', 'meta' => 'Konten Website', 'href' => route('admin.konten-website')],
            ['type' => 'Konten', 'label' => 'Tambah Berita Baru', 'keywords' => 'tambah berita baru add buat', 'meta' => 'Konten Website', 'href' => route('admin.konten-website')],
            ['type' => 'Konten', 'label' => 'Total Berita', 'keywords' => 'total berita jumlah berita', 'meta' => 'Konten Website', 'href' => route('admin.konten-website')],
            ['type' => 'Konten', 'label' => 'Published', 'keywords' => 'published terbit berita status', 'meta' => 'Konten Website', 'href' => route('admin.konten-website')],
            ['type' => 'Konten', 'label' => 'Draft', 'keywords' => 'draft konsep berita status', 'meta' => 'Konten Website', 'href' => route('admin.konten-website')],
            ['type' => 'Konten', 'label' => 'Terjadwal', 'keywords' => 'terjadwal scheduled berita status', 'meta' => 'Konten Website', 'href' => route('admin.konten-website')],
            ['type' => 'Konten', 'label' => 'Filter Berita', 'keywords' => 'filter berita cari judul keyword kategori status filter lanjut', 'meta' => 'Konten Website', 'href' => route('admin.konten-website')],
            ['type' => 'Konten', 'label' => 'Edit Berita', 'keywords' => 'edit berita ubah', 'meta' => 'Konten Website', 'href' => route('admin.konten-website')],
            ['type' => 'Konten', 'label' => 'Hapus Berita', 'keywords' => 'hapus berita delete', 'meta' => 'Konten Website', 'href' => route('admin.konten-website')],
            ['type' => 'Konten', 'label' => 'Lihat Berita', 'keywords' => 'lihat berita preview', 'meta' => 'Konten Website', 'href' => route('admin.konten-website')],
            ['type' => 'Konten', 'label' => 'Performa Konten Bulan Ini', 'keywords' => 'performa konten bulan ini interaksi klik bar chart', 'meta' => 'Konten Website', 'href' => route('admin.konten-website')],
            ['type' => 'Konten', 'label' => 'Tips Admin: Optimasi Visual', 'keywords' => 'tips admin optimasi visual gambar rasio 16:9 resolusi', 'meta' => 'Konten Website', 'href' => route('admin.konten-website')],

            ['type' => 'Laporan', 'label' => 'Repositori Laporan Institusional', 'keywords' => 'repositori laporan institusional kepatuhan kelola verifikasi publikasi', 'meta' => 'Laporan & Kepatuhan', 'href' => route('admin.laporan-kepatuhan')],
            ['type' => 'Laporan', 'label' => 'Upload New Version', 'keywords' => 'upload new version unggah versi baru dokumen', 'meta' => 'Laporan & Kepatuhan', 'href' => route('admin.laporan-kepatuhan')],
            ['type' => 'Laporan', 'label' => 'Kategori Laporan', 'keywords' => 'kategori laporan tahunan keberlanjutan publikasi tata kelola gcg pelayanan', 'meta' => 'Laporan & Kepatuhan', 'href' => route('admin.laporan-kepatuhan')],
            ['type' => 'Laporan', 'label' => 'Laporan Tahunan', 'keywords' => 'laporan tahunan annual', 'meta' => 'Laporan & Kepatuhan', 'href' => route('admin.laporan-kepatuhan')],
            ['type' => 'Laporan', 'label' => 'Laporan Keberlanjutan', 'keywords' => 'laporan keberlanjutan sustainability', 'meta' => 'Laporan & Kepatuhan', 'href' => route('admin.laporan-kepatuhan')],
            ['type' => 'Laporan', 'label' => 'Laporan Publikasi', 'keywords' => 'laporan publikasi', 'meta' => 'Laporan & Kepatuhan', 'href' => route('admin.laporan-kepatuhan')],
            ['type' => 'Laporan', 'label' => 'Tata Kelola / GCG', 'keywords' => 'tata kelola gcg good corporate governance', 'meta' => 'Laporan & Kepatuhan', 'href' => route('admin.laporan-kepatuhan')],
            ['type' => 'Laporan', 'label' => 'Laporan Pelayanan', 'keywords' => 'laporan pelayanan', 'meta' => 'Laporan & Kepatuhan', 'href' => route('admin.laporan-kepatuhan')],
            ['type' => 'Laporan', 'label' => 'Filter Tahun Buku', 'keywords' => 'filter tahun buku fy 2023 2022 2021', 'meta' => 'Laporan & Kepatuhan', 'href' => route('admin.laporan-kepatuhan')],
            ['type' => 'Laporan', 'label' => 'Download Dokumen', 'keywords' => 'download dokumen unduh', 'meta' => 'Laporan & Kepatuhan', 'href' => route('admin.laporan-kepatuhan')],
            ['type' => 'Laporan', 'label' => 'Riwayat Dokumen', 'keywords' => 'riwayat dokumen history', 'meta' => 'Laporan & Kepatuhan', 'href' => route('admin.laporan-kepatuhan')],
            ['type' => 'Laporan', 'label' => 'Metadata Dokumen', 'keywords' => 'metadata dokumen document id last modified retention period security level edit meta', 'meta' => 'Laporan & Kepatuhan', 'href' => route('admin.laporan-kepatuhan')],
            ['type' => 'Laporan', 'label' => 'Activity Timeline', 'keywords' => 'activity timeline aktivitas riwayat published approved uploaded', 'meta' => 'Laporan & Kepatuhan', 'href' => route('admin.laporan-kepatuhan')],

            ['type' => 'Pengaturan', 'label' => 'Pengaturan Umum', 'keywords' => 'pengaturan umum settings kontak informasi footer media sosial lencana', 'meta' => 'Pengaturan', 'href' => route('admin.pengaturan')],
            ['type' => 'Pengaturan', 'label' => 'Kontak & Informasi Footer', 'keywords' => 'kontak informasi footer simpan perubahan', 'meta' => 'Pengaturan', 'href' => route('admin.pengaturan')],
            ['type' => 'Pengaturan', 'label' => 'Nomor Telepon (CS)', 'keywords' => 'nomor telepon cs phone kontak', 'meta' => 'Pengaturan', 'href' => route('admin.pengaturan')],
            ['type' => 'Pengaturan', 'label' => 'Alamat Email', 'keywords' => 'alamat email email publik kontak', 'meta' => 'Pengaturan', 'href' => route('admin.pengaturan')],
            ['type' => 'Pengaturan', 'label' => 'Alamat Kantor Pusat', 'keywords' => 'alamat kantor pusat alamat', 'meta' => 'Pengaturan', 'href' => route('admin.pengaturan')],
            ['type' => 'Pengaturan', 'label' => 'Media Sosial', 'keywords' => 'media sosial instagram facebook', 'meta' => 'Pengaturan', 'href' => route('admin.pengaturan')],
            ['type' => 'Pengaturan', 'label' => 'Simpan Perubahan', 'keywords' => 'simpan perubahan save footer', 'meta' => 'Pengaturan', 'href' => route('admin.pengaturan')],
            ['type' => 'Pengaturan', 'label' => 'Lencana Kepatuhan (Trust Badges)', 'keywords' => 'lencana kepatuhan trust badges logo ojk lps ganti file tambah lencana', 'meta' => 'Pengaturan', 'href' => route('admin.pengaturan')],
            ['type' => 'Pengaturan', 'label' => 'Logo OJK', 'keywords' => 'logo ojk otoritas jasa keuangan ganti file', 'meta' => 'Pengaturan', 'href' => route('admin.pengaturan')],
            ['type' => 'Pengaturan', 'label' => 'Logo LPS', 'keywords' => 'logo lps lembaga penjamin simpanan ganti file', 'meta' => 'Pengaturan', 'href' => route('admin.pengaturan')],
            ['type' => 'Pengaturan', 'label' => 'Tambah Lencana Kepatuhan', 'keywords' => 'tambah lencana kepatuhan add badge', 'meta' => 'Pengaturan', 'href' => route('admin.pengaturan')],
            ['type' => 'Pengaturan', 'label' => 'Pratinjau Footer Publik', 'keywords' => 'pratinjau footer publik preview berizin diawasi', 'meta' => 'Pengaturan', 'href' => route('admin.pengaturan')],

            ['type' => 'Log', 'label' => 'Log Aktivitas Sistem', 'keywords' => 'log aktivitas sistem audit log pemantauan keamanan real-time', 'meta' => 'Audit Log', 'href' => route('admin.audit-log')],
            ['type' => 'Log', 'label' => 'Ekspor Laporan', 'keywords' => 'ekspor laporan export audit', 'meta' => 'Audit Log', 'href' => route('admin.audit-log')],
            ['type' => 'Log', 'label' => 'Refresh Data', 'keywords' => 'refresh data muat ulang', 'meta' => 'Audit Log', 'href' => route('admin.audit-log')],
            ['type' => 'Log', 'label' => 'Filter Admin User', 'keywords' => 'filter admin user pengguna', 'meta' => 'Audit Log', 'href' => route('admin.audit-log')],
            ['type' => 'Log', 'label' => 'Filter Tipe Aksi', 'keywords' => 'filter tipe aksi create update delete login', 'meta' => 'Audit Log', 'href' => route('admin.audit-log')],
            ['type' => 'Log', 'label' => 'Filter Rentang Tanggal', 'keywords' => 'filter rentang tanggal date', 'meta' => 'Audit Log', 'href' => route('admin.audit-log')],
            ['type' => 'Log', 'label' => 'Filter Modul', 'keywords' => 'filter modul autentikasi konten website auth service formulir pengajuan laporan kepatuhan', 'meta' => 'Audit Log', 'href' => route('admin.audit-log')],
            ['type' => 'Log', 'label' => 'Terapkan Filter', 'keywords' => 'terapkan filter apply', 'meta' => 'Audit Log', 'href' => route('admin.audit-log')],

            ['type' => 'Bantuan', 'label' => 'Pusat Bantuan Admin', 'keywords' => 'pusat bantuan admin help center', 'meta' => 'Bantuan', 'href' => route('admin.bantuan')],
            ['type' => 'Bantuan', 'label' => 'Tim IT Support', 'keywords' => 'tim it support ext 8888', 'meta' => 'Bantuan', 'href' => route('admin.bantuan')],
            ['type' => 'Bantuan', 'label' => 'Email Dukungan', 'keywords' => 'email dukungan admin-support@bankwaway.co.id', 'meta' => 'Bantuan', 'href' => route('admin.bantuan')],
            ['type' => 'Bantuan', 'label' => 'WhatsApp Internal', 'keywords' => 'whatsapp internal kontak', 'meta' => 'Bantuan', 'href' => route('admin.bantuan')],
            ['type' => 'Bantuan', 'label' => 'Pertanyaan yang Sering Diajukan', 'keywords' => 'pertanyaan sering diajukan faq reset password upload laporan export excel', 'meta' => 'Bantuan', 'href' => route('admin.bantuan')],
            ['type' => 'Bantuan', 'label' => 'Reset Password Staf', 'keywords' => 'reset password staf faq', 'meta' => 'Bantuan', 'href' => route('admin.bantuan')],
            ['type' => 'Bantuan', 'label' => 'Upload Dokumen Laporan Gagal', 'keywords' => 'upload dokumen laporan gagal ukuran file format pdf png svg', 'meta' => 'Bantuan', 'href' => route('admin.bantuan')],
            ['type' => 'Bantuan', 'label' => 'Export Data ke Excel', 'keywords' => 'export data excel xlsx pengajuan', 'meta' => 'Bantuan', 'href' => route('admin.bantuan')],
            ['type' => 'Bantuan', 'label' => 'Prosedur Pengelolaan CMS', 'keywords' => 'prosedur pengelolaan cms manual book pilih modul update konten verifikasi publish', 'meta' => 'Bantuan', 'href' => route('admin.bantuan')],
            ['type' => 'Bantuan', 'label' => 'Unduh Manual Book', 'keywords' => 'unduh manual book download', 'meta' => 'Bantuan', 'href' => route('admin.bantuan')],
            ['type' => 'Bantuan', 'label' => 'Hubungi Kami', 'keywords' => 'hubungi kami buka tiket internal cta', 'meta' => 'Bantuan', 'href' => route('admin.bantuan')],
        ];
    }
}
