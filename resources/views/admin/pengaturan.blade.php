@extends('layouts.admin')

@section('title', 'Pengaturan Umum - Bank Waway Admin CMS')

@section('styles')
<link rel="stylesheet" href="{{ asset('admin/CSS/pengaturan.css') }}">
@endsection

@section('content')
<div class="page-header">
  <div>
    <h2>Pengaturan Umum</h2>
    <p>Kelola informasi kontak publik, tautan media sosial, dan lencana kepatuhan perbankan.</p>
  </div>
</div>

<!-- Section: Identitas, Keamanan & Preferensi -->
<section class="settings-section">
  <h3 class="settings-section-title">Identitas, Keamanan & Preferensi</h3>

  <div class="settings-grid settings-grid-wide">

  <!-- Keamanan -->
  <form class="panel settings-panel" id="securityForm">
    <div class="panel-header">
      <h3>
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
          stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
        </svg>
        Keamanan
      </h3>
      <button type="submit" class="btn-save">Simpan Perubahan</button>
    </div>

    <div class="toggle-row">
      <div class="toggle-info">
        <span class="toggle-title">Autentikasi Dua Faktor (2FA)</span>
        <span class="toggle-desc">Wajibkan kode verifikasi saat login admin.</span>
      </div>
      <label class="switch">
        <input type="checkbox" id="twoFactorToggle" checked>
        <span class="slider"></span>
      </label>
    </div>

    <div class="toggle-row">
      <div class="toggle-info">
        <span class="toggle-title">Kunci Akun Setelah Gagal Login</span>
        <span class="toggle-desc">Blokir sementara setelah 5 percobaan gagal.</span>
      </div>
      <label class="switch">
        <input type="checkbox" id="lockoutToggle" checked>
        <span class="slider"></span>
      </label>
    </div>

    <div class="form-group">
      <label for="lockoutDuration">Durasi Blokir Akun (menit)</label>
      <div class="input-wrapper">
        <svg class="input-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
          stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
          <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
        </svg>
        <input type="number" id="lockoutDuration" name="lockoutDuration" value="10" min="1" max="1440">
      </div>
    </div>

    <div class="form-group">
      <label for="sessionTimeout">Sesi Berakhir Otomatis (menit)</label>
      <div class="input-wrapper">
        <svg class="input-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
          stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <circle cx="12" cy="12" r="10"></circle>
          <polyline points="12 6 12 12 16 14"></polyline>
        </svg>
        <input type="number" id="sessionTimeout" name="sessionTimeout" value="30" min="5" max="240">
      </div>
    </div>
  </form>

  <!-- Notifikasi -->
  <form class="panel settings-panel" id="notifForm">
    <div class="panel-header">
      <h3>
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
          stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M18 8a6 6 0 0 0-12 0c0 7-3 9-3 9h18s-3-2-3-9"></path>
          <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
        </svg>
        Notifikasi Email
      </h3>
      <button type="submit" class="btn-save">Simpan Perubahan</button>
    </div>

    <div class="toggle-row">
      <div class="toggle-info">
        <span class="toggle-title">Peringatan Keamanan</span>
        <span class="toggle-desc">Kirim email saat terdeteksi ancaman atau percobaan brute-force.</span>
      </div>
      <label class="switch">
        <input type="checkbox" id="notifThreat" checked>
        <span class="slider"></span>
      </label>
    </div>

    <div class="toggle-row">
      <div class="toggle-info">
        <span class="toggle-title">Ringkasan Mingguan</span>
        <span class="toggle-desc">Laporan statistik konten dan aktivitas setiap minggu.</span>
      </div>
      <label class="switch">
        <input type="checkbox" id="notifWeekly">
        <span class="slider"></span>
      </label>
    </div>

    <div class="form-group">
      <label for="notifEmail">Email Penerima Notifikasi</label>
      <div class="input-wrapper">
        <svg class="input-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
          stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <rect x="2" y="4" width="20" height="16" rx="2"></rect>
          <path d="m22 6-10 7L2 6"></path>
        </svg>
        <input type="email" id="notifEmail" name="notifEmail" value="admin@bankwaway.co.id">
      </div>
    </div>
  </form>

  <!-- Pemeliharaan & Cadangan -->
  <div class="panel settings-panel maintenance-panel">
    <div class="panel-header">
      <h3>
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
          stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
          <path d="M14 2v6h6"></path>
          <path d="M12 18v-6"></path>
          <path d="M9 15l3 3 3-3"></path>
        </svg>
        Pemeliharaan & Cadangan
      </h3>
    </div>

    <div class="toggle-row">
      <div class="toggle-info">
        <span class="toggle-title">Mode Pemeliharaan</span>
        <span class="toggle-desc">Sembunyikan situs publik sementara untuk perawatan.</span>
      </div>
      <label class="switch">
        <input type="checkbox" id="maintenanceToggle">
        <span class="slider"></span>
      </label>
    </div>

    <div class="maintenance-actions">
      <button type="button" class="btn-outline" id="btnBackup">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
          stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
          <polyline points="7 10 12 15 17 10"></polyline>
          <line x1="12" y1="15" x2="12" y2="3"></line>
        </svg>
        Buat Cadangan Data
      </button>
      <button type="button" class="btn-outline btn-danger" id="btnClearCache">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
          stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <polyline points="3 6 5 6 21 6"></polyline>
          <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
        </svg>
        Bersihkan Cache
      </button>
    </div>

    <div class="backup-status" id="backupStatus">
      <span class="status-dot"></span>
      <span>Cadangan terakhir: Belum pernah</span>
    </div>
  </div>
  </div>
</section>

<!-- Preview -->
<section class="preview-section">
</section>
@endsection

@section('scripts')
<script src="{{ asset('admin/JS/pengaturan.js') }}"></script>
@endsection
