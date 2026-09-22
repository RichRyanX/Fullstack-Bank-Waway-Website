@extends('layouts.admin')

@section('title', 'Repositori Laporan Institusional - Bank Waway Admin CMS')

@section('styles')
<link rel="stylesheet" href="{{ asset('admin/CSS/laporan-kepatuhan.css') }}">
@endsection

@section('content')
<div class="page-header">
  <div>
    <h2>Repositori Laporan Institusional</h2>
    <p>Kelola, verifikasi, dan publikasikan dokumen kepatuhan Bank Waway Lampung.</p>
  </div>
  <button class="btn-primary" type="button" id="btnUploadModal">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="17 8 12 3 7 8"></polyline><line x1="12" y1="3" x2="12" y2="15"></line></svg>
    Upload New Version
  </button>
</div>

<section class="metric-grid">
  <div class="metric-card" id="metricTotal">
    <div class="metric-icon metric-icon-blue">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><path d="M14 2v6h6"></path></svg>
    </div>
    <div class="metric-info">
      <span class="metric-label">Total Dokumen</span>
      <span class="metric-value" id="metricTotalValue">0</span>
      <span class="metric-sub">Dokumen</span>
    </div>
  </div>
  <div class="metric-card" id="metricPublished">
    <div class="metric-icon metric-icon-green">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
    </div>
    <div class="metric-info">
      <span class="metric-label">Status Publikasi</span>
      <span class="metric-value" id="metricPublishedValue">0</span>
      <span class="metric-sub">Published</span>
    </div>
  </div>
  <div class="metric-card" id="metricDraft">
    <div class="metric-icon metric-icon-amber">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
    </div>
    <div class="metric-info">
      <span class="metric-label">Menunggu Review</span>
      <span class="metric-value" id="metricDraftValue">0</span>
      <span class="metric-sub">Draft</span>
    </div>
  </div>
  <div class="metric-card" id="metricArchived">
    <div class="metric-icon metric-icon-archived">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="21 8 21 21 3 21 3 8"></polyline><rect x="1" y="3" width="22" height="5"></rect><line x1="10" y1="12" x2="14" y2="12"></line></svg>
    </div>
    <div class="metric-info">
      <span class="metric-label">Dokumen Diarsipkan</span>
      <span class="metric-value" id="metricArchivedValue">0</span>
      <span class="metric-sub">Archived</span>
    </div>
  </div>
</section>

<section class="repo-grid">
  <div class="panel category-panel">
    <h3 class="panel-subtitle">KATEGORI LAPORAN</h3>
    <nav class="category-list" id="categoryList">
      <a href="#" class="category-item active" data-count="12" data-category="Tahunan">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
        <span>Tahunan</span>
        <span class="count-pill">12</span>
      </a>
      <a href="#" class="category-item" data-count="08" data-category="Keberlanjutan">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
        <span>Keberlanjutan</span>
        <span class="count-pill">08</span>
      </a>
      <a href="#" class="category-item" data-count="05" data-category="Publikasi">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><path d="M14 2v6h6"></path></svg>
        <span>Publikasi</span>
        <span class="count-pill">05</span>
      </a>
      <a href="#" class="category-item" data-count="24" data-category="Tata Kelola / GCG">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
        <span>Tata Kelola / GCG</span>
        <span class="count-pill">24</span>
      </a>
      <a href="#" class="category-item" data-count="18" data-category="Pelayanan">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>
        <span>Pelayanan</span>
        <span class="count-pill">18</span>
      </a>
    </nav>
  </div>

  <div class="panel doc-panel">
    <div class="doc-panel-header">
      <div class="doc-panel-title">
        <h3 id="categoryTitle">Laporan Tahunan</h3>
        <span class="badge-directory">ACTIVE DIRECTORY</span>
      </div>
      <div class="doc-panel-actions">
        <div class="table-search">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><path d="M21 21l-4.35-4.35"></path></svg>
          <input type="text" id="tableSearchInput" placeholder="Cari nama atau versi...">
        </div>
        <select class="select-filter" id="yearFilter">
          <option value="">Semua Tahun</option>
          <option value="2026">2026</option>
          <option value="2025">2025</option>
          <option value="2024">2024</option>
          <option value="2023">2023</option>
          <option value="2022">2022</option>
        </select>
        <div class="filter-wrap">
          <button class="icon-action icon-action-bordered" id="filterBtn" aria-label="Filter">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="4" y1="21" x2="4" y2="14"></line><line x1="4" y1="10" x2="4" y2="3"></line><line x1="12" y1="21" x2="12" y2="12"></line><line x1="12" y1="8" x2="12" y2="3"></line><line x1="20" y1="21" x2="20" y2="16"></line><line x1="20" y1="12" x2="20" y2="3"></line><line x1="1" y1="14" x2="7" y2="14"></line><line x1="9" y1="8" x2="15" y2="8"></line><line x1="17" y1="16" x2="23" y2="16"></line></svg>
          </button>
          <div class="filter-popover" id="filterPopover">
            <div class="filter-popover-header">
              <span>Filter Lanjutan</span>
            </div>
            <div class="filter-popover-body">
              <div class="filter-field">
                <label class="filter-label" for="filterSortOrder">Sort Order</label>
                <select class="filter-select" id="filterSortOrder">
                  <option value="newest">Newest First</option>
                  <option value="oldest">Oldest First</option>
                </select>
              </div>
            </div>
            <div class="filter-popover-actions">
              <button type="button" class="filter-btn filter-btn-reset" id="filterResetBtn">Reset</button>
              <button type="button" class="filter-btn filter-btn-apply" id="filterApplyBtn">Apply Filters</button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="status-tabs" id="statusTabs">
      <button type="button" class="status-tab active" data-status="all">Semua <span class="count-pill">0</span></button>
      <button type="button" class="status-tab" data-status="published">Published <span class="count-pill">0</span></button>
      <button type="button" class="status-tab" data-status="draft">Draft <span class="count-pill">0</span></button>
      <button type="button" class="status-tab" data-status="archived">Archived <span class="count-pill">0</span></button>
    </div>

    <div class="bulk-bar" id="bulkBar">
      <span class="bulk-count" id="bulkCount">0 dipilih</span>
      <div class="bulk-actions">
        <button type="button" class="bulk-btn" id="bulkDownloadBtn">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
          Unduh Terpilih
        </button>
        <button type="button" class="bulk-btn" id="bulkStatusBtn">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9"></path><path d="M16.5 3.5a2.12 2.12 0 0 1 3 3L7 19l-4 1 1-4z"></path></svg>
          Ubah Status
        </button>
        <button type="button" class="bulk-btn bulk-btn-danger" id="bulkArchiveBtn">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="21 8 21 21 3 21 3 8"></polyline><rect x="1" y="3" width="22" height="5"></rect><line x1="10" y1="12" x2="14" y2="12"></line></svg>
          Arsipkan
        </button>
      </div>
    </div>

    <div class="table-responsive">
    <table class="doc-table">
      <thead>
        <tr>
          <th>FILE NAME & VERSION</th>
          <th>TAHUN BUKU</th>
          <th>UPLOAD DATE</th>
          <th>STATUS</th>
          <th>AKSI</th>
        </tr>
      </thead>
      <tbody id="docTableBody">
        <!-- Data will be populated by JavaScript -->
      </tbody>
    </table>
    </div>

    <div class="table-footer">
      <span class="table-count" id="tableCount">0 dokumen</span>
      <div class="pagination" id="pagination"></div>
    </div>
  </div>
</section>

<section class="bottom-grid">
  <div class="panel meta-panel">
    <div class="panel-header">
      <h3>Metadata Dokumen</h3>
      <a href="#" class="link-small" id="editMetaBtn">Edit Meta</a>
    </div>
    <dl class="meta-list">
      <div class="meta-row">
        <dt>Document ID</dt>
        <dd id="metaDocumentId">-</dd>
      </div>
      <div class="meta-row">
        <dt>Last Modified</dt>
        <dd id="metaLastModified">-</dd>
      </div>
      <div class="meta-row">
        <dt>Retention Period</dt>
        <dd id="metaRetention">-</dd>
      </div>
      <div class="meta-row">
        <dt>Security Level</dt>
        <dd><span class="tag-confidential" id="metaSecurityLevel">-</span></dd>
      </div>
    </dl>
  </div>

  <div class="panel timeline-panel">
    <h3 class="panel-title">Activity Timeline</h3>
    <ul class="timeline-list timeline-scroll" id="activityTimelineList"></ul>
  </div>
</section>

<!-- Upload Modal -->
<div class="modal-overlay" id="uploadModal">
  <div class="modal-box">
    <div class="modal-header">
      <div class="modal-header-icon">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="17 8 12 3 7 8"></polyline><line x1="12" y1="3" x2="12" y2="15"></line></svg>
      </div>
      <div class="modal-header-text">
        <h3 id="modalTitle">Upload Dokumen Baru</h3>
        <p id="modalSubtitle">Unggah versi terbaru dokumen kepatuhan untuk diverifikasi.</p>
      </div>
      <button type="button" class="modal-close" id="closeModalBtn" aria-label="Tutup">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
      </button>
    </div>

    <form id="uploadForm" enctype="multipart/form-data">
      <div class="modal-body">
        <div class="form-group">
          <label for="categorySelect">
            Kategori
            <span class="req">*</span>
          </label>
          <div class="input-wrap">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path><line x1="7" y1="7" x2="7.01" y2="7"></line></svg>
            <select id="categorySelect" name="category" required>
              <option value="Tahunan">Tahunan</option>
              <option value="Keberlanjutan">Keberlanjutan</option>
              <option value="Publikasi">Publikasi</option>
              <option value="Tata Kelola / GCG">Tata Kelola / GCG</option>
              <option value="Pelayanan">Pelayanan</option>
            </select>
          </div>
        </div>

        <div class="form-group">
          <label for="documentTitle">
            Judul Dokumen
          </label>
          <div class="input-wrap">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line></svg>
            <input type="text" id="documentTitle" name="title" placeholder="Contoh: FT 2026">
          </div>
        </div>

        <div class="form-group">
          <label for="tahunBuku">
            Tahun Buku
            <span class="req">*</span>
          </label>
          <div class="input-wrap">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
            <input type="text" id="tahunBuku" name="tahun_buku" placeholder="Contoh: FY 2024" required>
          </div>
        </div>

        <div class="form-group">
          <label for="statusSelect">
            Status
          </label>
          <div class="input-wrap">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9"></path><path d="M16.5 3.5a2.12 2.12 0 0 1 3 3L7 19l-4 1 1-4z"></path></svg>
            <select id="statusSelect" name="status">
              <option value="DRAFT">Draft</option>
              <option value="PUBLISHED">Published</option>
            </select>
          </div>
        </div>

        <div class="form-group">
          <label for="fileInput">
            File Dokumen
            <span class="req">*</span>
          </label>
          <div class="dropzone" id="fileDropzone">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="12" y1="18" x2="12" y2="12"></line><polyline points="9 15 12 12 15 15"></polyline></svg>
            <span class="dropzone-title" id="dropzoneTitle">Klik untuk memilih file</span>
            <span class="dropzone-hint" id="dropzoneHint">PDF, DOC, DOCX, XLS, XLSX · Maks 20MB</span>
            <input type="file" id="fileInput" name="file" accept=".pdf,.doc,.docx,.xls,.xlsx">
          </div>
          <div class="file-selected" id="fileSelected" hidden>
            <span class="file-selected-name" id="fileSelectedName"></span>
            <span class="file-selected-size" id="fileSelectedSize"></span>
            <button type="button" class="file-remove" id="fileRemoveBtn">Ubah File</button>
          </div>
          <div class="form-error" id="formError" hidden></div>
        </div>
      </div>

      <div class="modal-actions">
        <button type="button" class="btn-cancel" id="cancelModalBtn">Batal</button>
        <button type="button" class="btn-draft" id="draftUploadBtn">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9"></path><path d="M16.5 3.5a2.12 2.12 0 0 1 3 3L7 19l-4 1 1-4z"></path></svg>
          Simpan Draft
        </button>
        <button type="submit" class="btn-save" id="submitUploadBtn">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="17 8 12 3 7 8"></polyline><line x1="12" y1="3" x2="12" y2="15"></line></svg>
          Upload & Terbitkan
        </button>
      </div>
    </form>
  </div>
</div>

<!-- Preview Modal -->
<div class="modal-overlay" id="previewModal">
  <div class="modal-box modal-box-preview">
    <div class="modal-header">
      <div class="modal-header-icon">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
      </div>
      <div class="modal-header-text">
        <h3 id="previewTitle">Pratinjau Dokumen</h3>
        <p id="previewMeta">Pratinjau dokumen kepatuhan sebelum diunduh.</p>
      </div>
      <button type="button" class="modal-close" id="closePreviewBtn" aria-label="Tutup">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
      </button>
    </div>
    <div class="preview-body">
      <iframe class="preview-frame" id="previewFrame" title="Pratinjau Dokumen"></iframe>
    </div>
    <div class="modal-actions">
      <button type="button" class="btn-cancel" id="closePreviewCancelBtn">Tutup</button>
      <button type="button" class="btn-save" id="previewDownloadBtn">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
        Unduh Dokumen
      </button>
    </div>
  </div>
</div>

<!-- History Modal -->
<div class="modal-overlay" id="historyModal">
  <div class="modal-box modal-box-history">
    <div class="modal-header">
      <div class="modal-header-icon">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 12a9 9 0 1 0 3-6.7L3 8"></path><path d="M3 3v5h5"></path><path d="M12 7v5l4 2"></path></svg>
      </div>
      <div class="modal-header-text">
        <h3 id="historyTitle">Riwayat Dokumen</h3>
        <p>Riwayat aktivitas dan perubahan dokumen kepatuhan.</p>
      </div>
      <button type="button" class="modal-close" id="closeHistoryBtn" aria-label="Tutup">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
      </button>
    </div>
    <div class="history-body">
      <ul class="timeline-list" id="historyList"></ul>
    </div>
    <div class="modal-actions">
      <button type="button" class="btn-cancel" id="closeHistoryCancelBtn">Tutup</button>
    </div>
  </div>
</div>

<!-- Status Change Modal -->
<div class="modal-overlay" id="statusModal">
  <div class="modal-box">
    <div class="modal-header">
      <div class="modal-header-icon">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9"></path><path d="M16.5 3.5a2.12 2.12 0 0 1 3 3L7 19l-4 1 1-4z"></path></svg>
      </div>
      <div class="modal-header-text">
        <h3 id="statusModalTitle">Ubah Status Dokumen</h3>
        <p id="statusModalSubtitle">Pilih status baru untuk dokumen kepatuhan.</p>
      </div>
      <button type="button" class="modal-close" id="closeStatusBtn" aria-label="Tutup">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
      </button>
    </div>
    <div class="modal-body">
      <div class="form-group">
        <label for="statusSelectModal">Status Baru</label>
        <div class="input-wrap">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9"></path><path d="M16.5 3.5a2.12 2.12 0 0 1 3 3L7 19l-4 1 1-4z"></path></svg>
          <select id="statusSelectModal" name="status">
            <option value="DRAFT">Draft</option>
            <option value="PUBLISHED">Published</option>
            <option value="ARCHIVED">Archived</option>
          </select>
        </div>
      </div>
      <div class="form-error" id="statusFormError" hidden></div>
    </div>
    <div class="modal-actions">
      <button type="button" class="btn-cancel" id="cancelStatusBtn">Batal</button>
      <button type="button" class="btn-save" id="saveStatusBtn">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="17 8 12 3 7 8"></polyline><line x1="12" y1="3" x2="12" y2="15"></line></svg>
        Simpan Status
      </button>
    </div>
  </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal-overlay delete-modal-overlay" id="deleteModal">
  <div class="modal-box delete-modal-box">
    <form id="deleteForm" method="POST" action="{{ route('admin.compliance-reports.destroy', ['id' => 0]) }}">
      @csrf
      <input type="hidden" name="_method" value="DELETE">
      <input type="hidden" name="document_id" id="deleteDocumentId">
      <div class="delete-modal-header">
        <div class="delete-icon-badge">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path><line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>
        </div>
        <button type="button" class="modal-close" id="closeDeleteBtn" aria-label="Tutup">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>
      </div>
      <div class="delete-modal-body">
        <h3 id="deleteModalTitle">Hapus Dokumen</h3>
        <p id="deleteModalDescription">Dokumen akan dihapus secara permanen.</p>
      </div>
      <div class="modal-actions">
        <button type="button" class="btn-cancel" id="cancelDeleteBtn">Batal</button>
        <button type="submit" class="btn-danger" id="confirmDeleteBtn">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
          Hapus Permanen
        </button>
      </div>
    </form>
  </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('admin/JS/script.js') }}"></script>
<script src="{{ asset('admin/JS/laporan-kepatuhan.js') }}"></script>
<script src="{{ asset('admin/JS/logout.js') }}"></script>
@endsection