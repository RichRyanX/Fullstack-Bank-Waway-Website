@extends('layouts.admin')

@section('title', 'Hasil Pencarian - Bank Waway Admin CMS')

@section('styles')
<link rel="stylesheet" href="{{ asset('admin/CSS/search.css') }}">
@endsection

@section('content')
<div class="page-header">
  <div>
    <h2 id="search-query-display">Hasil Pencarian</h2>
    <p>Menampilkan hasil untuk pencarian Anda.</p>
  </div>
</div>

<div class="panel" id="search-results-panel">
</div>
@endsection

@section('scripts')
<script src="{{ asset('admin/JS/script.js') }}"></script>
<script src="{{ asset('admin/JS/logout.js') }}"></script>
<script>
  // Directory of every function & crucial info across the admin CMS.
  // Audit log detail entries (e.g. login failed) are intentionally excluded.
  const DIRECTORY = [
    // Dashboard
    { type: 'Dashboard', label: 'Total Berita', meta: 'Dashboard', href: '{{ route("admin.dashboard") }}' },
    { type: 'Dashboard', label: 'Total Laporan', meta: 'Dashboard', href: '{{ route("admin.dashboard") }}' },
    { type: 'Dashboard', label: 'Aktivitas Log Terkini', meta: 'Dashboard', href: '{{ route("admin.dashboard") }}' },
    { type: 'Dashboard', label: 'Aktivitas 7 Hari Terakhir', meta: 'Dashboard', href: '{{ route("admin.dashboard") }}' },
    { type: 'Dashboard', label: 'Aksi Cepat', meta: 'Dashboard', href: '{{ route("admin.dashboard") }}' },
    { type: 'Dashboard', label: 'Tambah Informasi', meta: 'Dashboard', href: '{{ route("admin.konten-website") }}' },
    { type: 'Dashboard', label: 'Upload Laporan', meta: 'Dashboard', href: '{{ route("admin.dashboard") }}' },
    { type: 'Dashboard', label: 'Peringatan Keamanan (Brute Force)', meta: 'Dashboard', href: '{{ route("admin.dashboard") }}' },
    { type: 'Dashboard', label: 'Kapasitas Log & Database Health', meta: 'Dashboard', href: '{{ route("admin.dashboard") }}' },
    { type: 'Dashboard', label: 'Total Log Stored', meta: 'Dashboard', href: '{{ route("admin.dashboard") }}' },
    { type: 'Dashboard', label: 'Database Health Status', meta: 'Dashboard', href: '{{ route("admin.dashboard") }}' },
    { type: 'Dashboard', label: 'Arsip Otomatis', meta: 'Dashboard', href: '{{ route("admin.dashboard") }}' },
    { type: 'Dashboard', label: 'Status Publikasi Web', meta: 'Dashboard', href: '{{ route("admin.dashboard") }}' },
    { type: 'Dashboard', label: 'Berita Terbit', meta: 'Dashboard', href: '{{ route("admin.dashboard") }}' },
    { type: 'Dashboard', label: 'Draft Disimpan', meta: 'Dashboard', href: '{{ route("admin.dashboard") }}' },
    { type: 'Dashboard', label: 'Laporan Compliance', meta: 'Dashboard', href: '{{ route("admin.dashboard") }}' },

    // Konten Website
    { type: 'Konten', label: 'Kelola Informasi & Berita', meta: 'Konten Website', href: '{{ route("admin.konten-website") }}' },
    { type: 'Konten', label: 'Tambah Berita Baru', meta: 'Konten Website', href: '{{ route("admin.konten-website") }}' },
    { type: 'Konten', label: 'Total Berita', meta: 'Konten Website', href: '{{ route("admin.konten-website") }}' },
    { type: 'Konten', label: 'Published', meta: 'Konten Website', href: '{{ route("admin.konten-website") }}' },
    { type: 'Konten', label: 'Draft', meta: 'Konten Website', href: '{{ route("admin.konten-website") }}' },
    { type: 'Konten', label: 'Terjadwal', meta: 'Konten Website', href: '{{ route("admin.konten-website") }}' },
    { type: 'Konten', label: 'Filter Berita', meta: 'Konten Website', href: '{{ route("admin.konten-website") }}' },
    { type: 'Konten', label: 'Edit Berita', meta: 'Konten Website', href: '{{ route("admin.konten-website") }}' },
    { type: 'Konten', label: 'Hapus Berita', meta: 'Konten Website', href: '{{ route("admin.konten-website") }}' },
    { type: 'Konten', label: 'Lihat Berita', meta: 'Konten Website', href: '{{ route("admin.konten-website") }}' },
    { type: 'Konten', label: 'Performa Konten Bulan Ini', meta: 'Konten Website', href: '{{ route("admin.konten-website") }}' },
    { type: 'Konten', label: 'Tips Admin: Optimasi Visual', meta: 'Konten Website', href: '{{ route("admin.konten-website") }}' },

    // Laporan & Kepatuhan
    { type: 'Laporan', label: 'Repositori Laporan Institusional', meta: 'Laporan & Kepatuhan', href: '{{ route("admin.laporan-kepatuhan") }}' },
    { type: 'Laporan', label: 'Upload New Version', meta: 'Laporan & Kepatuhan', href: '{{ route("admin.laporan-kepatuhan") }}' },
    { type: 'Laporan', label: 'Kategori Laporan', meta: 'Laporan & Kepatuhan', href: '{{ route("admin.laporan-kepatuhan") }}' },
    { type: 'Laporan', label: 'Laporan Tahunan', meta: 'Laporan & Kepatuhan', href: '{{ route("admin.laporan-kepatuhan") }}' },
    { type: 'Laporan', label: 'Laporan Keberlanjutan', meta: 'Laporan & Kepatuhan', href: '{{ route("admin.laporan-kepatuhan") }}' },
    { type: 'Laporan', label: 'Laporan Publikasi', meta: 'Laporan & Kepatuhan', href: '{{ route("admin.laporan-kepatuhan") }}' },
    { type: 'Laporan', label: 'Tata Kelola / GCG', meta: 'Laporan & Kepatuhan', href: '{{ route("admin.laporan-kepatuhan") }}' },
    { type: 'Laporan', label: 'Laporan Pelayanan', meta: 'Laporan & Kepatuhan', href: '{{ route("admin.laporan-kepatuhan") }}' },
    { type: 'Laporan', label: 'Filter Tahun Buku', meta: 'Laporan & Kepatuhan', href: '{{ route("admin.laporan-kepatuhan") }}' },
    { type: 'Laporan', label: 'Download Dokumen', meta: 'Laporan & Kepatuhan', href: '{{ route("admin.laporan-kepatuhan") }}' },
    { type: 'Laporan', label: 'Riwayat Dokumen', meta: 'Laporan & Kepatuhan', href: '{{ route("admin.laporan-kepatuhan") }}' },
    { type: 'Laporan', label: 'Metadata Dokumen', meta: 'Laporan & Kepatuhan', href: '{{ route("admin.laporan-kepatuhan") }}' },
    { type: 'Laporan', label: 'Activity Timeline', meta: 'Laporan & Kepatuhan', href: '{{ route("admin.laporan-kepatuhan") }}' },

    // Pengaturan
    { type: 'Pengaturan', label: 'Pengaturan Umum', meta: 'Pengaturan', href: '{{ route("admin.pengaturan") }}' },
    { type: 'Pengaturan', label: 'Kontak & Informasi Footer', meta: 'Pengaturan', href: '{{ route("admin.pengaturan") }}' },
    { type: 'Pengaturan', label: 'Nomor Telepon (CS)', meta: 'Pengaturan', href: '{{ route("admin.pengaturan") }}' },
    { type: 'Pengaturan', label: 'Alamat Email', meta: 'Pengaturan', href: '{{ route("admin.pengaturan") }}' },
    { type: 'Pengaturan', label: 'Alamat Kantor Pusat', meta: 'Pengaturan', href: '{{ route("admin.pengaturan") }}' },
    { type: 'Pengaturan', label: 'Media Sosial', meta: 'Pengaturan', href: '{{ route("admin.pengaturan") }}' },
    { type: 'Pengaturan', label: 'Simpan Perubahan', meta: 'Pengaturan', href: '{{ route("admin.pengaturan") }}' },
    { type: 'Pengaturan', label: 'Lencana Kepatuhan (Trust Badges)', meta: 'Pengaturan', href: '{{ route("admin.pengaturan") }}' },
    { type: 'Pengaturan', label: 'Logo OJK', meta: 'Pengaturan', href: '{{ route("admin.pengaturan") }}' },
    { type: 'Pengaturan', label: 'Logo LPS', meta: 'Pengaturan', href: '{{ route("admin.pengaturan") }}' },
    { type: 'Pengaturan', label: 'Tambah Lencana Kepatuhan', meta: 'Pengaturan', href: '{{ route("admin.pengaturan") }}' },
    { type: 'Pengaturan', label: 'Pratinjau Footer Publik', meta: 'Pengaturan', href: '{{ route("admin.pengaturan") }}' },

    // Audit Log
    { type: 'Log', label: 'Log Aktivitas Sistem', meta: 'Audit Log', href: '{{ route("admin.audit-log") }}' },
    { type: 'Log', label: 'Ekspor Laporan', meta: 'Audit Log', href: '{{ route("admin.audit-log") }}' },
    { type: 'Log', label: 'Refresh Data', meta: 'Audit Log', href: '{{ route("admin.audit-log") }}' },
    { type: 'Log', label: 'Filter Admin User', meta: 'Audit Log', href: '{{ route("admin.audit-log") }}' },
    { type: 'Log', label: 'Filter Tipe Aksi', meta: 'Audit Log', href: '{{ route("admin.audit-log") }}' },
    { type: 'Log', label: 'Filter Rentang Tanggal', meta: 'Audit Log', href: '{{ route("admin.audit-log") }}' },
    { type: 'Log', label: 'Filter Modul', meta: 'Audit Log', href: '{{ route("admin.audit-log") }}' },
    { type: 'Log', label: 'Terapkan Filter', meta: 'Audit Log', href: '{{ route("admin.audit-log") }}' },

    // Bantuan
    { type: 'Bantuan', label: 'Pusat Bantuan Admin', meta: 'Bantuan', href: '{{ route("admin.bantuan") }}' },
    { type: 'Bantuan', label: 'Tim IT Support', meta: 'Bantuan', href: '{{ route("admin.bantuan") }}' },
    { type: 'Bantuan', label: 'Email Dukungan', meta: 'Bantuan', href: '{{ route("admin.bantuan") }}' },
    { type: 'Bantuan', label: 'WhatsApp Internal', meta: 'Bantuan', href: '{{ route("admin.bantuan") }}' },
    { type: 'Bantuan', label: 'Pertanyaan yang Sering Diajukan', meta: 'Bantuan', href: '{{ route("admin.bantuan") }}' },
    { type: 'Bantuan', label: 'Reset Password Staf', meta: 'Bantuan', href: '{{ route("admin.bantuan") }}' },
    { type: 'Bantuan', label: 'Upload Dokumen Laporan Gagal', meta: 'Bantuan', href: '{{ route("admin.bantuan") }}' },
    { type: 'Bantuan', label: 'Export Data ke Excel', meta: 'Bantuan', href: '{{ route("admin.bantuan") }}' },
    { type: 'Bantuan', label: 'Prosedur Pengelolaan CMS', meta: 'Bantuan', href: '{{ route("admin.bantuan") }}' },
    { type: 'Bantuan', label: 'Unduh Manual Book', meta: 'Bantuan', href: '{{ route("admin.bantuan") }}' },
    { type: 'Bantuan', label: 'Hubungi Kami', meta: 'Bantuan', href: '{{ route("admin.bantuan") }}' }
  ];

  const params = new URLSearchParams(window.location.search);
  const query = (params.get('q') || '').trim().toLowerCase();
  const display = document.getElementById('search-query-display');
  const panel = document.getElementById('search-results-panel');

  function escapeHtml(str) {
    const div = document.createElement('div');
    div.textContent = str;
    return div.innerHTML;
  }

  function highlight(text, q) {
    const lower = text.toLowerCase();
    const idx = lower.indexOf(q);
    if (idx === -1 || q === '') return escapeHtml(text);
    return escapeHtml(text.slice(0, idx)) +
      '<mark>' + escapeHtml(text.slice(idx, idx + q.length)) + '</mark>' +
      escapeHtml(text.slice(idx + q.length));
  }

  let rows = DIRECTORY;
  if (query) {
    display.textContent = 'Hasil Pencarian: ' + params.get('q');
    rows = DIRECTORY.filter(function (row) {
      return (row.label + ' ' + row.meta + ' ' + row.type).toLowerCase().indexOf(query) !== -1;
    });
  } else {
    display.textContent = 'Semua Fungsi & Informasi';
  }

  const table = document.createElement('table');
  table.className = 'search-result-table';
  const thead = document.createElement('thead');
  const headRow = document.createElement('tr');
  ['Tipe', 'Hasil', 'Kategori'].forEach(function (text) {
    const th = document.createElement('th');
    th.textContent = text;
    headRow.appendChild(th);
  });
  thead.appendChild(headRow);
  table.appendChild(thead);

  const tbody = document.createElement('tbody');
  if (rows.length === 0) {
    const tr = document.createElement('tr');
    const td = document.createElement('td');
    td.setAttribute('colspan', '3');
    td.textContent = 'Tidak ada hasil untuk "' + params.get('q') + '"';
    tr.appendChild(td);
    tbody.appendChild(tr);
  } else {
    rows.forEach(function (row) {
      const tr = document.createElement('tr');
      const tdType = document.createElement('td');
      const badge = document.createElement('span');
      badge.className = 'search-result-badge';
      badge.textContent = row.type;
      tdType.appendChild(badge);
      const tdTitle = document.createElement('td');
      const link = document.createElement('a');
      link.className = 'search-result-title';
      link.href = row.href;
      link.innerHTML = highlight(row.label, query);
      tdTitle.appendChild(link);
      const tdMeta = document.createElement('td');
      tdMeta.className = 'search-result-meta';
      tdMeta.textContent = row.meta;
      tr.appendChild(tdType);
      tr.appendChild(tdTitle);
      tr.appendChild(tdMeta);
      tbody.appendChild(tr);
    });
  }
  table.appendChild(tbody);
  panel.appendChild(table);
</script>
@endsection