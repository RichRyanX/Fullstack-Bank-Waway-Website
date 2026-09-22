@extends('layouts.admin')

@section('title', 'Pusat Bantuan - Bank Waway Admin CMS')

@section('styles')
<link rel="stylesheet" href="{{ asset('admin/CSS/bantuan.css') }}">
@endsection

@section('content')
<section class="help-hero">
  <h2>Pusat Bantuan Admin</h2>
  <p>Kami hadir untuk membantu pengelolaan sistem CMS Bank Waway Lampung.</p>

  <div class="help-contact-grid">
    <a href="#" class="help-contact-card">
      <span class="help-contact-icon">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 8V4H8"></path><rect x="4" y="8" width="16" height="12" rx="2"></rect><path d="M2 14h2"></path><path d="M20 14h2"></path><path d="M15 13v2"></path><path d="M9 13v2"></path></svg>
      </span>
      <span class="help-contact-title">Tim IT Support</span>
      <span class="help-contact-meta">Ext. 8888</span>
    </a>
    <a href="mailto:admin-support@bankwaway.co.id" class="help-contact-card">
      <span class="help-contact-icon">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="4" width="20" height="16" rx="2"></rect><path d="m22 6-10 7L2 6"></path></svg>
      </span>
      <span class="help-contact-title">Email Dukungan</span>
      <span class="help-contact-meta">bankwawaylampung@yahoo.com</span>
    </a>
    <a href="#" class="help-contact-card">
      <span class="help-contact-icon">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path></svg>
      </span>
      <span class="help-contact-title">WhatsApp Internal</span>
      <span class="help-contact-meta">+0721 266 869</span>
    </a>
  </div>
</section>

<main class="dash-content help-content">

  <section class="help-faq">
    <div class="help-section-title">
      <h3>Pertanyaan yang Sering Diajukan</h3>
      <p>Informasi cepat mengenai pengelolaan operasional Bank Waway.</p>
    </div>

    <div class="faq-list">
      <div class="faq-item">
        <button type="button" class="faq-question">
          Bagaimana prosedur reset password jika staf atau admin lupa kata sandi?
          <svg class="faq-chevron" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
        </button>
        <div class="faq-answer">
          <p>Demi menjaga keamanan sistem dan pembatasan hak akses (RBAC), perubahan dan reset password pengguna hanya dapat dilakukan oleh Super Admin. Silakan ajukan permohonan ke Super Admin atau hubungi Tim IT Support (Ext. 8888) untuk pembaruan kredensial.</p>
        </div>
      </div>

      <div class="faq-item">
        <button type="button" class="faq-question">
          Kenapa upload dokumen laporan gagal?
          <svg class="faq-chevron" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
        </button>
        <div class="faq-answer">
          <p>Kegagalan unggah umumnya disebabkan oleh ukuran file yang melebihi batas kuota atau format yang tidak didukung. Pastikan dokumen berformat PDF atau PNG.</p>
        </div>
      </div>

      <div class="faq-item">
        <button type="button" class="faq-question">
          Bagaimana cara mengunduh data Audit Log atau Laporan?
          <svg class="faq-chevron" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
        </button>
        <div class="faq-answer">
          <p>Buka menu Audit Log atau Laporan & Kepatuhan, atur filter rentang tanggal dan tipe aksi, lalu klik tombol "Ekspor Laporan" di pojok kanan atas tabel.</p>
        </div>
      </div>

      <div class="faq-item">
        <button type="button" class="faq-question">
          Mengapa muncul status LOGIN_2FA_SENT pada riwayat aktivitas?
          <svg class="faq-chevron" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
        </button>
        <div class="faq-answer">
          <p>Status ini menandakan sistem telah berhasil mengirimkan kode OTP Two-Factor Authentication (2FA) ke email admin saat proses verifikasi masuk.</p>
        </div>
      </div>

      <div class="faq-item">
        <button type="button" class="faq-question">
          Apa yang harus dilakukan jika kapasitas penyimpanan sistem penuh?
          <svg class="faq-chevron" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
        </button>
        <div class="faq-answer">
          <p>Hapus dokumen arsip yang sudah tidak terpakai melalui menu Laporan & Kepatuhan, atau hubungi Tim IT Support (Ext. 8888) untuk pengajuan penambahan kuota.</p>
        </div>
      </div>
    </div>
  </section>

  <section class="help-procedure">
    <div class="help-procedure-header">
      <div class="help-section-title help-section-title-left">
        <h3>Prosedur Pengelolaan CMS</h3>
        <p>Ikuti langkah-langkah standar operasional prosedur untuk menjaga kualitas data dan konten portal Bank Waway.</p>
      </div>
      <a href="{{ url('/admin-api/bantuan/manual-book') }}" class="btn-download-manual" download>
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
        <span>Unduh Manual Book</span>
      </a>
    </div>

    <div class="procedure-grid">
      <div class="procedure-card">
        <span class="procedure-number">01</span>
        <span class="procedure-icon">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7" rx="1"></rect><rect x="14" y="3" width="7" height="7" rx="1"></rect><rect x="3" y="14" width="7" height="7" rx="1"></rect><rect x="14" y="14" width="7" height="7" rx="1"></rect></svg>
        </span>
        <h4>Pilih Modul</h4>
        <p>Akses navigasi di samping untuk memilih modul yang akan dikelola seperti Konten Website, Laporan & Kepatuhan, atau Pengaturan.</p>
      </div>
      <div class="procedure-card">
        <span class="procedure-number">02</span>
        <span class="procedure-icon">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.12 2.12 0 0 1 3 3L12 15l-4 1 1-4z"></path></svg>
        </span>
        <h4>Update Konten</h4>
        <p>Lakukan perubahan data atau unggah dokumen baru sesuai dengan kebutuhan operasional divisi masing-masing.</p>
      </div>
      <div class="procedure-card">
        <span class="procedure-number">03</span>
        <span class="procedure-icon">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><path d="M9 12l2 2 4-4"></path></svg>
        </span>
        <h4>Verifikasi & Publish</h4>
        <p>Periksa kembali akurasi data sebelum melakukan simpan atau publish agar perubahan dapat terlihat di website publik.</p>
      </div>
    </div>
  </section>

  <section class="help-cta">
    <h3>Belum menemukan yang Anda cari?</h3>
    <p>Tim spesialis IT kami siap membantu Anda menyelesaikan kendala teknis CMS dengan cepat dan efisien.</p>
    <div class="help-cta-actions">
      <button type="button" class="btn-cta-primary" id="btnBukaTiket">Buka Tiket Internal</button>
    </div>
  </section>

  <div id="superadmin-ticket-section" class="superadmin-ticket-card">
    <div class="superadmin-ticket-header">
      <div>
        <h3>Kelola Tiket Support (Super Admin)</h3>
        <p>Daftar kendala teknis yang diajukan oleh pengguna CMS Bank Waway.</p>
      </div>
    </div>

    <div class="ticket-status-tabs" id="ticket-status-tabs">
      <button type="button" class="ticket-status-tab active" data-status="ALL">Semua <span class="ticket-tab-badge" id="badge-ALL">0</span></button>
      <button type="button" class="ticket-status-tab" data-status="BARU">Baru <span class="ticket-tab-badge" id="badge-BARU">0</span></button>
      <button type="button" class="ticket-status-tab" data-status="DIPROSES">Diproses <span class="ticket-tab-badge" id="badge-DIPROSES">0</span></button>
      <button type="button" class="ticket-status-tab" data-status="SELESAI">Selesai <span class="ticket-tab-badge" id="badge-SELESAI">0</span></button>
    </div>

    <div class="ticket-filter-toolbar">
      <div class="ticket-filter-field ticket-filter-search">
        <svg class="ticket-filter-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><path d="M21 21l-4.35-4.35"></path></svg>
        <input type="text" id="ticket-search-input" placeholder="Cari ID Tiket, Subjek, atau Pengirim...">
      </div>
      <div class="ticket-filter-field">
        <select id="ticket-module-filter">
          <option value="ALL">Semua Modul</option>
        </select>
      </div>
      <div class="ticket-filter-field">
        <input type="date" id="ticket-end-date" aria-label="Tanggal Akhir">
      </div>
      <button type="button" class="ticket-filter-reset" id="ticket-reset-filters">Reset Filter</button>
    </div>

    <div class="superadmin-ticket-table-wrap">
      <table class="superadmin-ticket-table">
        <thead>
          <tr>
            <th class="col-id">ID Tiket</th>
            <th class="col-date">Tanggal</th>
            <th class="col-sender">Pengirim</th>
            <th class="col-module">Modul</th>
            <th class="col-subject">Subjek</th>
            <th class="col-status">Status</th>
            <th class="col-action">Aksi</th>
          </tr>
        </thead>
        <tbody id="ticket-table-body">
        </tbody>
      </table>
    </div>

    <div class="ticket-pagination">
      <span class="ticket-pagination-info" id="ticket-pagination-info">Menampilkan 0-0 dari 0</span>
      <div class="ticket-pagination-controls">
        <button type="button" class="ticket-page-btn ticket-page-prev" id="ticket-page-prev">Previous</button>
        <div class="ticket-page-numbers" id="ticket-page-numbers"></div>
        <button type="button" class="ticket-page-btn ticket-page-next" id="ticket-page-next">Next</button>
      </div>
    </div>
  </div>

</main>

<div class="modal-tiket" id="modal-tiket-internal" aria-hidden="true">
  <div class="modal-tiket-card" role="dialog" aria-modal="true" aria-labelledby="modal-tiket-title">
    <div class="modal-tiket-header">
      <h3 id="modal-tiket-title">Buka Tiket Internal</h3>
      <button type="button" class="modal-tiket-close" id="btnTutupModal" aria-label="Tutup">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
      </button>
    </div>
    <form id="form-tiket-internal" novalidate>
      <div class="modal-tiket-body">
        <div class="modal-tiket-field">
          <label for="tiket-subjek">Subjek / Judul Kendala <span class="req">*</span></label>
          <input type="text" id="tiket-subjek" name="subjek" placeholder="Contoh: Gagal upload dokumen laporan" required>
        </div>
        <div class="modal-tiket-field">
          <label for="tiket-modul">Modul Terkait</label>
          <select id="tiket-modul" name="modul">
            <option value="Konten Website">Konten Website</option>
            <option value="Laporan & Kepatuhan">Laporan & Kepatuhan</option>
          </select>
        </div>
        <div class="modal-tiket-field">
          <label for="tiket-deskripsi">Deskripsi Kendala <span class="req">*</span></label>
          <textarea id="tiket-deskripsi" name="deskripsi" rows="4" placeholder="Jelaskan kendala yang Anda alami secara detail..." required></textarea>
        </div>
      </div>
      <div class="modal-tiket-footer">
        <button type="button" class="modal-tiket-btn modal-tiket-btn-batal" id="btnBatalTiket">Batal</button>
        <button type="submit" class="modal-tiket-btn modal-tiket-btn-kirim" id="btnKirimTiket">Kirim Tiket</button>
      </div>
    </form>
  </div>
</div>

<div class="ticket-detail-overlay" id="modal-detail-tiket" aria-hidden="true">
  <div class="ticket-detail-card" role="dialog" aria-modal="true" aria-labelledby="detail-ticket-title">
    <div class="ticket-detail-header">
      <div class="ticket-detail-title-wrap">
        <h3 id="detail-ticket-title">Detail Tiket</h3>
        <span id="detail-ticket-status" class="ticket-detail-status"></span>
      </div>
      <button type="button" class="ticket-detail-close" id="close-detail-modal" aria-label="Tutup">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
      </button>
    </div>
    <div class="ticket-detail-body">
      <div class="ticket-detail-grid">
        <div class="ticket-detail-item">
          <span class="ticket-detail-label">ID Tiket</span>
          <strong id="detail-ticket-code">-</strong>
        </div>
        <div class="ticket-detail-item">
          <span class="ticket-detail-label">Tanggal</span>
          <strong id="detail-ticket-date">-</strong>
        </div>
        <div class="ticket-detail-item">
          <span class="ticket-detail-label">Pengirim</span>
          <strong id="detail-ticket-sender">-</strong>
        </div>
        <div class="ticket-detail-item">
          <span class="ticket-detail-label">Modul</span>
          <strong id="detail-ticket-module">-</strong>
        </div>
      </div>
      <div class="ticket-detail-content">
        <div class="ticket-detail-block">
          <span class="ticket-detail-label">Subjek</span>
          <p id="detail-ticket-subject">-</p>
        </div>
        <div class="ticket-detail-block">
          <span class="ticket-detail-label">Deskripsi Kendala</span>
          <div id="detail-ticket-message" class="ticket-detail-message">-</div>
        </div>
      </div>
    </div>
    <div class="ticket-detail-footer">
      <div id="modal-action-buttons" class="ticket-detail-actions"></div>
      <button type="button" class="ticket-detail-btn ticket-detail-btn-close" id="btn-close-detail">Tutup</button>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('admin/JS/bantuan.js') }}"></script>
@endsection