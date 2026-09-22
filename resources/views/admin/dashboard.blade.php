@extends('layouts.admin')

@section('title', 'Dashboard - Bank Waway Admin CMS')

@section('content')
<div class="page-header">
  <div>
    <h2>Dashboard Ringkasan</h2>
    <p>Status operasional terkini dan pembaruan sistem Bank Waway Lampung.</p>
  </div>
  <div class="date-chip" id="current-date-display">{{ now()->translatedFormat('l, d F Y') }}</div>
</div>

<section class="stat-grid stat-grid-2">
  <div class="stat-card">
    <div class="stat-top">
      <div class="stat-icon icon-blue">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 5H7a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-2"></path><rect x="9" y="3" width="6" height="4" rx="1"></rect></svg>
      </div>
      <span class="badge badge-green">+2% Hari ini</span>
    </div>
    <p class="stat-label">TOTAL BERITA</p>
    <p class="stat-value" id="totalBerita">{{ $totalBerita ?? 0 }}</p>
  </div>

  <div class="stat-card">
    <div class="stat-top">
      <div class="stat-icon icon-amber">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 5H7a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-2"></path><rect x="9" y="3" width="6" height="4" rx="1"></rect></svg>
      </div>
      <span class="badge badge-green" id="laporanBadge">{{ $publishedReportsCount ?? 0 }} Terpublikasi</span>
    </div>
    <p class="stat-label">TOTAL LAPORAN</p>
    <p class="stat-value" id="totalLaporan">{{ $totalReports ?? 0 }}</p>
  </div>
</section>

<section class="content-grid">

  <div class="main-column">

    <div class="panel draft-panel">
      <div class="panel-header">
        <h3><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 11l3 3L22 4"></path><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path></svg> Aktivitas Log Terkini</h3>
        <a href="{{ route('admin.audit-log') }}" class="link-small">Lihat Semua Log</a>
      </div>

      <div class="table-responsive">
        <table class="draft-table">
          <thead>
            <tr>
              <th>PENGGUNA</th>
              <th>AKSI</th>
              <th>MODUL</th>
              <th>WAKTU</th>
            </tr>
          </thead>
          <tbody id="auditLogBody">
            @forelse ($recentLogs ?? [] as $log)
              <tr>
                <td class="content-name">{{ $log->admin->name ?? 'Unknown' }}</td>
                <td><span class="action-badge">{{ $log->action }}</span></td>
                <td class="content-cat">{{ $log->module }}</td>
                <td class="content-date">{{ $log->created_at ? $log->created_at->format('d M Y H:i') : '' }}</td>
              </tr>
            @empty
              <tr>
                <td colspan="4">Tidak ada aktivitas log.</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>

    <div class="panel chart-panel">
      <div class="panel-header">
        <h3><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 20V10"></path><path d="M12 20V4"></path><path d="M6 20v-6"></path></svg> Aktivitas 7 Hari Terakhir</h3>
      </div>
      <div class="chart-wrapper">
        <canvas id="activityTrendChart"></canvas>
      </div>
    </div>

  </div>

  <div class="side-panels">

    <div class="panel action-panel">
      <h3 class="action-title">Aksi Cepat</h3>
      <a href="{{ route('admin.konten-website') }}?open=add" class="btn-quick btn-quick-outline">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="16"></line><line x1="8" y1="12" x2="16" y2="12"></line></svg>
        Tambah Informasi
      </a>
      <a href="{{ route('admin.laporan-kepatuhan') }}?action=upload" id="quickActionUploadBtn" class="btn-quick btn-quick-filled">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="17 8 12 3 7 8"></polyline><line x1="12" y1="3" x2="12" y2="15"></line></svg>
        Upload Laporan
      </a>
    </div>

    <div class="panel alert-panel">
      <div class="panel-header">
        <h3>
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path><line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>
          Peringatan Keamanan (Brute Force)
        </h3>
        <span class="alert-badge" id="alertBadge">{{ count($bruteForceAlerts ?? []) }}</span>
      </div>
      <div class="alert-list" id="bruteForceList">
        @forelse ($bruteForceAlerts ?? [] as $alert)
          <div class="alert-item">
            <div class="alert-item-top">
              <span class="alert-ip">{{ $alert->ip_address }}</span>
              <span class="attempt-badge">{{ $alert->attempt_count }}x Gagal</span>
            </div>
            <span class="alert-time">{{ $alert->last_attempt }}</span>
          </div>
        @empty
          <div class="alert-empty">Tidak Ada Ancaman</div>
        @endforelse
        <div class="alert-payload" id="threatPayload"></div>
      </div>
    </div>

    <div class="panel log-health-panel">
      <h3 class="panel-subtitle">RINGKASAN TIKET SUPPORT</h3>
      <div class="health-row">
        <span><span class="status-dot status-dot-amber"></span>Tiket Baru</span>
        <span class="status" id="ticketBaru">{{ $ticketMetrics['baru'] ?? 0 }}</span>
      </div>
      <div class="health-row">
        <span><span class="status-dot status-dot-blue"></span>Dalam Proses</span>
        <span class="status" id="ticketDiproses">{{ $ticketMetrics['diproses'] ?? 0 }}</span>
      </div>
      <div class="health-row">
        <span><span class="status-dot status-dot-green"></span>Selesai</span>
        <span class="status" id="ticketSelesai">{{ $ticketMetrics['selesai'] ?? 0 }}</span>
      </div>
      <div class="health-row">
        <span><span class="status-dot status-dot-slate"></span>Total Tiket</span>
        <span class="status" id="ticketTotal">{{ $ticketMetrics['total'] ?? 0 }}</span>
      </div>
    </div>

    <div class="panel storage-panel">
      <div class="panel-header">
        <h3><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><ellipse cx="12" cy="5" rx="9" ry="3"></ellipse><path d="M21 12c0 1.66-4 3-9 3s-9-1.34-9-3"></path><path d="M3 5v14c0 1.66 4 3 9 3s9-1.34 9-3V5"></path></svg> Kapasitas Penyimpanan</h3>
      </div>
      <div class="storage-display">
        <span class="storage-used" id="storageUsed">{{ $storageMetrics['used_storage'] ?? '0 B' }}</span>
        <span class="storage-separator">/</span>
        <span class="storage-quota" id="storageQuota">{{ $storageMetrics['quota_storage'] ?? '2 GB' }}</span>
      </div>
      <div class="storage-progress">
        <div class="storage-progress-track">
          <div class="storage-progress-fill" id="storageProgressFill" style="width: {{ min(100, max(0, $storageMetrics['usage_percentage'] ?? 0)) }}%"></div>
        </div>
      </div>
      <div class="storage-detail">
        <div class="storage-detail-row">
          <span>Total File Document</span>
          <span class="storage-detail-value" id="storageDocumentCount">{{ $storageMetrics['document_count'] ?? 0 }}</span>
        </div>
        <div class="storage-detail-row">
          <span>Status System</span>
          <span class="status status-green" id="storageStatus">● {{ $storageMetrics['status'] ?? 'Optimal' }}</span>
        </div>
      </div>
    </div>

  </div>
</section>
@endsection

@section('scripts')
<script src="{{ asset('admin/JS/dashboard.js') }}"></script>
@endsection