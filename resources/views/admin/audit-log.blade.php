@extends('layouts.admin')

@section('title', 'Log Aktivitas Sistem - Bank Waway Admin CMS')

@section('styles')
<link rel="stylesheet" href="{{ asset('admin/CSS/audit-log.css') }}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endsection

@section('content')
<div class="page-header">
  <div>
    <h2>Log Aktivitas Sistem</h2>
    <p>Pemantauan keamanan dan audit perubahan data secara real-time.</p>
  </div>
  <div class="page-header-actions">
    <button type="button" class="btn-outline btn-export-audit" id="btnExport">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
      Ekspor Laporan
    </button>
    <a href="{{ route('admin.audit-log') }}" class="btn-primary-dark" id="btnRefresh">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="23 4 23 10 17 10"></polyline><path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"></path></svg>
      Refresh Data
    </a>
  </div>
</div>

<section class="panel filter-panel">
  <div class="filter-group">
    <label>Admin User</label>
    <select id="filterUser">
      <option>Semua Admin</option>
    </select>
  </div>
  <div class="filter-group">
    <label>Tipe Aksi</label>
    <select id="filterAction">
      <option value="">Semua Aksi</option>
      <option value="CREATE">Create</option>
      <option value="UPDATE">Update</option>
      <option value="DELETE">Delete</option>
      <option value="LOGIN">Login</option>
    </select>
  </div>
  <div class="filter-group">
    <label>Rentang Tanggal</label>
    <div class="input-wrapper date-wrapper">
      <svg class="input-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
      <input type="text" id="filterDate" placeholder="Pilih rentang tanggal..." autocomplete="off">
    </div>
  </div>
  <div class="filter-group">
    <label>Modul</label>
    <select id="filterModule">
      <option>Semua Modul</option>
      <option>Autentikasi</option>
      <option>Konten Website</option>
      <option>Auth Service</option>
      <option>Laporan & Kepatuhan</option>
    </select>
  </div>
  <button type="button" class="btn-primary-dark btn-apply" id="btnApplyFilter">Terapkan Filter</button>
</section>

<section class="panel log-panel">
  <div class="table-scroll">
    <table class="log-table">
      <thead>
        <tr>
          <th>TIMESTAMP</th>
          <th>PENGGUNA</th>
          <th>AKTIVITAS</th>
          <th>MODUL</th>
          <th>ALAMAT IP</th>
          <th>DETAIL</th>
        </tr>
      </thead>
      <tbody id="logTableBody">
      </tbody>
    </table>
  </div>

  <div class="table-footer">
    <span class="table-count"></span>
    <div class="pagination">
      <button type="button" class="page-btn" aria-label="Sebelumnya">&lsaquo;</button>
      <button type="button" class="page-btn active">1</button>
      <button type="button" class="page-btn">2</button>
      <button type="button" class="page-btn">3</button>
      <span class="page-ellipsis">&hellip;</span>
      <button type="button" class="page-btn">32</button>
      <button type="button" class="page-btn" aria-label="Berikutnya">&rsaquo;</button>
    </div>
  </div>
</section>

<section class="log-stat-grid">
  <div class="panel log-stat-card">
    <p class="log-stat-label">Total Aktivitas (12 Jam)</p>
    <p class="log-stat-value" id="statTotal12h">0</p>
    <p class="log-stat-meta log-stat-up" id="statTrend12h">-</p>
  </div>
  <div class="panel log-stat-card">
    <p class="log-stat-label">Login Gagal Terdeteksi (12 Jam)</p>
    <p class="log-stat-value log-stat-value-red" id="statFailedLogins">0</p>
    <p class="log-stat-meta log-stat-safe" id="statFailedLoginsMeta">&#10003; Aman &mdash; Tidak ada ancaman</p>
  </div>
  <div class="panel log-stat-card">
    <p class="log-stat-label">Perubahan Konten (12 Jam)</p>
    <p class="log-stat-value" id="statContentChanges">0</p>
    <p class="log-stat-meta" id="statContentMeta">&#9998; 0 Update Terakhir oleh 0 admin berbeda</p>
  </div>
</section>

<div class="audit-modal" id="auditModal" aria-hidden="true">
  <div class="audit-modal-backdrop" data-audit-close></div>
  <div class="audit-modal-dialog" role="dialog" aria-modal="true" aria-labelledby="auditModalTitle">
    <div class="audit-modal-header">
      <div>
        <h3 id="auditModalTitle">Detail Log Aktivitas</h3>
        <p id="auditModalSubtitle">Informasi lengkap perubahan data</p>
      </div>
      <button type="button" class="audit-modal-close" data-audit-close aria-label="Tutup">&times;</button>
    </div>
    <div class="audit-modal-body">
      <div class="audit-modal-section">
        <h4>Perubahan Data (JSON Diff)</h4>
        <div class="audit-diff" id="auditDiff">
          <p class="audit-empty">Tidak ada perubahan data.</p>
        </div>
      </div>
      <div class="audit-modal-section">
        <h4>Metadata Permintaan</h4>
        <dl class="audit-meta" id="auditMeta"></dl>
      </div>
      <div class="audit-modal-section">
        <h4>Konteks Sesi</h4>
        <dl class="audit-meta" id="auditSession"></dl>
      </div>
    </div>
    <div class="audit-modal-footer">
      <button type="button" class="btn-primary-dark" data-audit-close>Tutup</button>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('admin/JS/audit-log.js') }}"></script>
@endsection