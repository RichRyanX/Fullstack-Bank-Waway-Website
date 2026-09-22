<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\BadgeController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\AuditLogController as AdminAuditLogController;
use App\Http\Controllers\Admin\BantuanController as AdminBantuanController;
use App\Http\Controllers\Admin\KontenWebsiteController as AdminKontenWebsiteController;
use App\Http\Controllers\Admin\LaporanKepatuhanController as AdminLaporanKepatuhanController;
use App\Http\Controllers\Admin\PengaturanController as AdminPengaturanController;
use App\Http\Controllers\Admin\SearchController as AdminSearchController;
use App\Http\Controllers\Public\HomeController;
use App\Http\Controllers\Public\NewsController;
use App\Http\Controllers\Public\ProductController;
use App\Http\Controllers\Public\ReportController;
use App\Http\Controllers\Public\GovernanceController;
use App\Http\Controllers\Public\ContactController;
use App\Http\Controllers\Public\ApplicationController;

Route::get('/login', [AuthController::class, 'loginPage'])->name('admin.login');

Route::middleware('auth:admin')->group(function () {
    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/audit-log', [AdminAuditLogController::class, 'index'])->name('admin.audit-log');
    Route::get('/admin/bantuan', [AdminBantuanController::class, 'index'])->name('admin.bantuan');
    Route::get('/konten-website', [AdminKontenWebsiteController::class, 'index'])->name('admin.konten-website');
    Route::get('/laporan-kepatuhan', [AdminLaporanKepatuhanController::class, 'index'])->name('admin.laporan-kepatuhan');
    Route::get('/pengaturan', [AdminPengaturanController::class, 'index'])->name('admin.pengaturan');
    Route::get('/search', [AdminSearchController::class, 'index'])->name('admin.search');

    Route::redirect('/admin/HTML/dashboard.html', '/admin/dashboard');
    Route::redirect('/dashboard.html', '/admin/dashboard');
    Route::redirect('/search.html', '/search');
    Route::redirect('/audit-log.html', '/audit-log');
    Route::redirect('/konten-website.html', '/konten-website');
    Route::redirect('/laporan-kepatuhan.html', '/laporan-kepatuhan');
    Route::redirect('/bantuan.html', '/admin/bantuan');
    Route::redirect('/pengaturan.html', '/pengaturan');
});

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::view('/profil', 'public.profil.index')->name('public.profil.index');
Route::view('/profil/visi-misi', 'public.profil.visi-misi')->name('public.profil.visi-misi');
Route::view('/profil/susunan-pengurus', 'public.profil.susunan-pengurus')->name('public.profil.susunan-pengurus');
Route::view('/profil/maksud-tujuan', 'public.profil.maksud-tujuan')->name('public.profil.maksud-tujuan');
Route::view('/profil/perijinan-legalitas', 'public.profil.perijinan-legalitas')->name('public.profil.perijinan-legalitas');
Route::view('/profil/prestasi-penghargaan', 'public.profil.prestasi-penghargaan')->name('public.profil.prestasi-penghargaan');
Route::view('/profil/tempat-kedudukan', 'public.profil.tempat-kedudukan')->name('public.profil.tempat-kedudukan');
Route::get('/tata-kelola', [GovernanceController::class, 'tataKelola'])->name('public.governance.tata-kelola');
Route::get('/laporan-keberlanjutan', [GovernanceController::class, 'laporanKeberlanjutan'])->name('public.governance.laporan-keberlanjutan');
Route::get('/laporan-tahunan', [GovernanceController::class, 'laporanTahunan'])->name('public.governance.laporan-tahunan');

Route::view('/tabungan', 'public.produk.tabungan')->name('public.tabungan.index');
Route::view('/tabungan/cerdik', 'public.produk.cerdik')->name('public.tabungan.cerdik');
Route::view('/tabungan/pegawai', 'public.produk.pegawai')->name('public.tabungan.pegawai');
Route::view('/tabungan/tapis', 'public.produk.tapis')->name('public.tabungan.tapis');
Route::view('/deposito', 'public.produk.deposito')->name('public.deposito.index');
Route::get('/pelayanan', [GovernanceController::class, 'pelayanan'])->name('public.layanan.index');
Route::view('/modal', 'public.profil.modal')->name('public.layanan.modal');

Route::view('/pinjaman', 'public.produk.pinjaman')->name('public.kredit.pinjaman');
Route::view('/kredit/umkm', 'public.produk.kredit-umkm')->name('public.kredit.kredit-umkm');
Route::view('/kredit/multiguna', 'public.produk.kredit-multiguna')->name('public.kredit.kredit-multiguna');
Route::view('/kredit/b2b', 'public.produk.kredit-b2b')->name('public.kredit.kredit-b2b');
Route::view('/kredit/komersil', 'public.produk.kredit-komersil')->name('public.kredit.kredit-komersil');
Route::view('/kredit/konsumer', 'public.produk.kredit-konsumer')->name('public.kredit.kredit-konsumer');
Route::view('/kredit/pdrs', 'public.produk.kredit-pdrs')->name('public.kredit.kredit-pdrs');
Route::view('/kredit/pensiun', 'public.produk.kredit-pensiun')->name('public.kredit.kredit-pensiun');
Route::view('/kredit/pppk', 'public.produk.kredit-pppk')->name('public.kredit.kredit-pppk');
Route::view('/kredit/pppk-paruh-waktu', 'public.produk.kredit-pppk-paruh-waktu')->name('public.kredit.kredit-pppk-paruh-waktu');
Route::view('/kredit/prapensiun', 'public.produk.kredit-prapensiun')->name('public.kredit.kredit-prapensiun');
Route::view('/kredit/subsidi', 'public.produk.kredit-subsidi')->name('public.kredit.kredit-subsidi');
Route::view('/kredit/tukin', 'public.produk.kredit-tukin')->name('public.kredit.kredit-tukin');

Route::view('/bantuan', 'public.bantuan.index')->name('public.bantuan.index');
Route::view('/karir', 'public.karir.index')->name('public.karir.index');
Route::get('/pengajuan/kredit-pegawai', [ApplicationController::class, 'kreditPegawai'])->name('public.pengajuan.kredit-pegawai');

Route::get('/berita', [NewsController::class, 'index'])->name('public.berita.index');
Route::get('/berita/{id}', [NewsController::class, 'show'])->name('public.berita.show');
Route::get('/produk/{slug}', [ProductController::class, 'show'])->name('public.produk.show');
Route::get('/laporan', [ReportController::class, 'index'])->name('public.laporan.index');
Route::get('/laporan/{complianceReport}/download', [ReportController::class, 'download'])->name('public.laporan.download');
Route::get('/kontak', [ContactController::class, 'contact'])->name('public.kontak.index');
Route::post('/kontak', [ContactController::class, 'storeContact'])->name('public.kontak.store')->middleware('throttle:contact');
Route::get('/whistleblowing', [ContactController::class, 'whistleblowing'])->name('public.whistleblowing.index');
Route::get('/kalkulator', [ApplicationController::class, 'kalkulator'])->name('public.kalkulator.index');
Route::post('/kalkulator/hitung', [ApplicationController::class, 'calculate'])->name('public.kalkulator.hitung');
Route::get('/pengajuan', [ApplicationController::class, 'index'])->name('public.pengajuan.index');
Route::post('/pengajuan', [ApplicationController::class, 'store'])->name('public.pengajuan.store')->middleware('throttle:application');

Route::redirect('/admin/HTML/index.html', '/login');
Route::redirect('/index.html', '/login');

Route::prefix('admin-api')->group(function () {
    Route::post('/auth/login', [AuthController::class, 'login']);
    Route::post('/auth/verify-2fa', [AuthController::class, 'verify2fa']);
    Route::post('/auth/logout', [AuthController::class, 'logout']);
    Route::get('/auth/me', [AuthController::class, 'me']);
    Route::apiResource('berita', BeritaController::class)->parameters(['berita' => 'berita']);
    Route::post('/berita/{berita}/view', [BeritaController::class, 'recordView']);
    Route::get('/laporan/{laporan}/history', [LaporanController::class, 'history']);
    Route::post('/laporan/{laporan}/version', [LaporanController::class, 'newVersion']);
    Route::apiResource('laporan', LaporanController::class)->only(['index', 'store']);
    Route::get('/laporan/{laporan}/download', [LaporanController::class, 'download']);
    Route::get('/compliance-reports', [AdminLaporanKepatuhanController::class, 'apiIndex']);
    Route::post('/compliance-reports', [AdminLaporanKepatuhanController::class, 'store']);
    Route::get('/compliance-reports/{id}', [AdminLaporanKepatuhanController::class, 'show']);
    Route::match(['put', 'patch'], '/compliance-reports/{id}', [AdminLaporanKepatuhanController::class, 'update']);
    Route::patch('/compliance-reports/{id}/status', [AdminLaporanKepatuhanController::class, 'updateStatus']);
    Route::delete('/compliance-reports/{id}', [AdminLaporanKepatuhanController::class, 'destroy'])->name('admin.compliance-reports.destroy');
    Route::get('/audit-logs/export', [AdminAuditLogController::class, 'export']);
    Route::get('/audit-logs/{documentId}/history', [AdminAuditLogController::class, 'history']);
    Route::get('/audit-logs', [AdminAuditLogController::class, 'apiIndex']);
    Route::get('/pengaturan', [AdminPengaturanController::class, 'show']);
    Route::put('/pengaturan', [AdminPengaturanController::class, 'update']);
    Route::get('/pengaturan/badges', [BadgeController::class, 'index']);
    Route::post('/pengaturan/badges', [BadgeController::class, 'store']);
    Route::delete('/pengaturan/badges/{badge}', [BadgeController::class, 'destroy']);
    Route::get('/dashboard', [AdminDashboardController::class, 'apiIndex']);
    Route::post('/dashboard/acknowledge-threat', [AdminDashboardController::class, 'acknowledgeThreat']);
    Route::get('/search/suggest', [AdminSearchController::class, 'suggest']);
    Route::post('/maintenance/toggle', [AdminPengaturanController::class, 'toggleMaintenance']);
    Route::post('/maintenance/clear-cache', [AdminPengaturanController::class, 'clearCache']);
    Route::post('/maintenance/backup', [AdminPengaturanController::class, 'createBackup']);
    Route::get('/backup/download/{filename}', [AdminPengaturanController::class, 'downloadBackup'])->name('admin.backup.download');
    Route::get('/bantuan/manual-book', [AdminBantuanController::class, 'downloadManualBook']);
    Route::post('/bantuan/tiket', [AdminBantuanController::class, 'createTicket']);
    Route::get('/bantuan/tiket', [AdminBantuanController::class, 'apiIndex']);
    Route::patch('/bantuan/tiket/{id}/status', [AdminBantuanController::class, 'updateStatus']);
});
