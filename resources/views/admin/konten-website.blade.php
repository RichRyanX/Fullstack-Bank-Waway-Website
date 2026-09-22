@extends('layouts.admin')

@section('title', 'Kelola Informasi & Berita - Bank Waway Admin CMS')

@section('styles')
<link rel="stylesheet" href="{{ asset('admin/CSS/konten-website.css') }}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endsection

@section('content')
<div class="page-header">
  <div>
    <h2>Kelola Informasi & Berita</h2>
    <p>Kelola konten pengumuman, promo, dan edukasi nasabah Bank Waway.</p>
  </div>
  <button class="btn-primary" type="button" id="btnAddBerita">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
    Tambah Berita Baru
  </button>
</div>

<section class="stat-grid stat-grid-4">
  <div class="stat-card">
    <div class="stat-top">
      <p class="stat-label">TOTAL BERITA</p>
      <div class="stat-icon icon-blue">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path></svg>
      </div>
    </div>
    <p class="stat-value" id="statTotal">0</p>
  </div>

  <div class="stat-card">
    <div class="stat-top">
      <p class="stat-label">PUBLISHED</p>
      <div class="stat-icon icon-green">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
      </div>
    </div>
    <p class="stat-value stat-value-green" id="statPublished">0</p>
  </div>

  <div class="stat-card">
    <div class="stat-top">
      <p class="stat-label">DRAFT</p>
      <div class="stat-icon icon-gray">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><path d="M14 2v6h6"></path></svg>
      </div>
    </div>
    <p class="stat-value" id="statDraft">0</p>
  </div>

  <div class="stat-card">
    <div class="stat-top">
      <p class="stat-label">TERJADWAL</p>
      <div class="stat-icon icon-blue">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
      </div>
    </div>
    <p class="stat-value stat-value-blue" id="statScheduled">0</p>
  </div>
</section>

<div class="filter-bar">
  <div class="search-box search-box-filter">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><path d="M21 21l-4.35-4.35"></path></svg>
    <input type="text" id="searchInput" placeholder="Cari judul berita atau keyword...">
  </div>
  <select class="select-filter" id="categoryFilter">
    <option value="">Semua Kategori</option>
    <option value="Edukasi">Edukasi</option>
    <option value="Promo">Promo</option>
    <option value="Pengumuman">Pengumuman</option>
  </select>
  <select class="select-filter" id="statusFilter">
    <option value="">Semua Status</option>
    <option value="published">Published</option>
    <option value="draft">Draft</option>
    <option value="scheduled">Scheduled</option>
  </select>
  <div class="date-filter-wrap">
    <svg class="date-filter-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
    <input type="text" id="filterDate" placeholder="Pilih rentang tanggal..." autocomplete="off">
  </div>
  <button class="btn-outline" type="button" id="btnResetFilter" title="Kembalikan semua filter ke default">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="1 4 1 10 7 10"></polyline><path d="M3.51 15a9 9 0 1 0 2.13-9.36L1 10"></path></svg>
    Reset Filter
  </button>
</div>

<div class="panel table-panel">
  <div class="table-responsive">
    <table class="berita-table">
      <thead>
        <tr>
          <th>JUDUL BERITA</th>
          <th>KATEGORI</th>
          <th>STATUS</th>
          <th>TERAKHIR DIUBAH</th>
          <th>AKSI</th>
        </tr>
      </thead>
      <tbody id="beritaTableBody"></tbody>
    </table>
  </div>

  <div class="table-footer">
    <span class="table-count"></span>
    <div class="pagination" id="pagination"></div>
  </div>
</div>

<section class="bottom-grid">
  <div class="panel perf-panel">
    <h3 class="panel-title">Distribusi Kategori</h3>
    <p class="perf-desc">Sebaran berita berdasarkan kategori yang tersedia di Bank Waway.</p>
    <div class="donut-wrap">
      <div class="donut-chart" id="categoryDonut">
        <div class="donut-center">
          <span class="donut-total" id="donutTotal">0</span>
          <span class="donut-total-label">Berita</span>
        </div>
      </div>
      <ul class="donut-legend" id="donutLegend"></ul>
    </div>
    <div class="donut-tooltip" id="donutTooltip" style="display: none"></div>
  </div>

  <div class="panel tips-panel">
    <span class="tips-badge">TERPOPULER</span>
    <h3 class="tips-title">Top 5 Berita</h3>
    <ol class="leaderboard" id="leaderboard"></ol>
  </div>
</section>

<div class="modal-overlay" id="beritaModal" style="display: none">
  <div class="modal-box">
    <div class="modal-header">
      <div class="modal-header-icon">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9"></path><path d="M16.5 3.5a2.12 2.12 0 0 1 3 3L7 19l-4 1 1-4z"></path></svg>
      </div>
      <div class="modal-header-text">
        <h3 id="modalTitle">Tambah Berita Baru</h3>
        <p>Lengkapi detail berita di bawah ini untuk dipublikasikan.</p>
      </div>
      <button type="button" class="modal-close" id="btnCloseModal" aria-label="Tutup">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
      </button>
    </div>

    <form id="beritaForm">
      <input type="hidden" id="beritaId" value="">

      <div class="modal-body">
        <div class="form-group">
          <label for="beritaTitle">Judul Berita <span class="req">*</span></label>
          <div class="input-wrap">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path></svg>
            <input type="text" id="beritaTitle" placeholder="Contoh: Pembaruan Suku Bunga Tabungan" required>
          </div>
        </div>

        <div class="form-row">
          <div class="form-group">
            <label for="beritaCategory">Kategori <span class="req">*</span></label>
            <div class="input-wrap">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path><line x1="7" y1="7" x2="7.01" y2="7"></line></svg>
              <select id="beritaCategory" required>
                <option value="Edukasi">Edukasi</option>
                <option value="Promo">Promo</option>
                <option value="Pengumuman">Pengumuman</option>
              </select>
            </div>
          </div>

          <div class="form-group">
            <label for="beritaStatus">Status <span class="req">*</span></label>
            <div class="input-wrap">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
              <select id="beritaStatus" required>
                <option value="draft">Draft</option>
                <option value="published">Published</option>
                <option value="scheduled">Scheduled</option>
              </select>
            </div>
          </div>
        </div>

        <div class="form-group">
          <label for="beritaContent">Konten Berita <span class="req">*</span></label>
          <textarea id="beritaContent" rows="6" placeholder="Tulis isi berita di sini..." required></textarea>
          <span class="field-hint">Gunakan paragraf singkat agar mudah dibaca nasabah.</span>
        </div>
      </div>

      <div class="modal-actions">
        <button type="button" class="btn-cancel" id="btnCancelModal">Batal</button>
        <button type="submit" class="btn-save" id="btnSaveModal">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path><polyline points="17 21 17 13 7 13 7 21"></polyline><polyline points="7 3 7 8 15 8"></polyline></svg>
          Simpan Berita
        </button>
      </div>
    </form>
  </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('admin/JS/konten-website.js') }}"></script>
@endsection
