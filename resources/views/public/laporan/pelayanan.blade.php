@extends('layouts.public')

@section('title', 'Bank Waway Lampung - Pelayanan Konsumen')

@section('content')

<section class="page-hero">
  <div class="page-hero-overlay"></div>
  <div class="container hero-content">
    <div class="breadcrumb">
      <a href="{{ route('home') }}">Beranda</a> <span>/</span> <a href="{{ route('public.laporan.index') }}">Laporan</a> <span>/</span> <span class="active">Pelayanan Konsumen</span>
    </div>
    <h1>Pelayanan Konsumen</h1>
    <p class="hero-description">
      Wujud komitmen kami dalam transparansi dan perlindungan konsumen. Temukan laporan layanan, tingkat kepuasan nasabah, serta publikasi perlindungan konsumen terkini.
    </p>
    <a href="#dokumen" class="btn btn-white">📄 Lihat Dokumen</a>
  </div>
</section>

<section class="section pelayanan-head" id="dokumen">
  <div class="container">
    <div class="pelayanan-stats">
      <div class="stat-emoji-card">
        <div class="val">94.2%</div>
        <div class="lbl">Indeks Kepuasan Nasabah</div>
      </div>
      <div class="stat-emoji-card">
        <div class="val">99.8%</div>
        <div class="lbl">Penyelesaian Pengaduan</div>
      </div>
      <div class="stat-emoji-card">
        <div class="val">< 2 Hari</div>
        <div class="lbl">Waktu Respon Rata-rata</div>
      </div>
      <div class="stat-emoji-card">
        <div class="val">ISO 9001</div>
        <div class="lbl">Standar Mutu Layanan</div>
      </div>
    </div>

    <div class="laporan-grid">
      @forelse($reports->take(2) as $report)
      <article class="laporan-card" data-year="{{ $report->fiscal_year }}" data-keyword="{{ strtolower($report->title) }}">
        <div class="laporan-cover">
          <img src="{{ asset('admin/images/Bangunan.png') }}" alt="Laporan Bangunan Bank Waway Lampung">
          @if($loop->first)
          <span class="badge-terbaru">Terbaru</span>
          @endif
          <h4>Laporan Pelayanan {{ $report->fiscal_year }}</h4>
        </div>
        <div class="laporan-body">
          <p class="laporan-subtitle">{{ $report->title }}</p>
          <div class="laporan-meta">
            <div class="laporan-meta-info">
              <span class="size">📄 {{ $report->file_size ?? 'PDF' }}</span>
              <span class="date">🗓 {{ $report->created_at->format('d M Y') }}</span>
            </div>
            <a href="{{ route('public.laporan.download', ['complianceReport' => $report->id]) }}" class="dl">⬇ Download PDF</a>
          </div>
        </div>
      </article>
      @empty
      <article class="laporan-card">
        <div class="laporan-cover">
          <img src="{{ asset('admin/images/Bangunan.png') }}" alt="Laporan Bangunan Bank Waway Lampung">
          <h4>Belum Ada Publikasi Pelayanan</h4>
        </div>
        <div class="laporan-body">
          <p class="laporan-subtitle">Laporan pelayanan konsumen belum tersedia. Silakan kembali lagi nanti untuk memperoleh publikasi terbaru kami.</p>
        </div>
      </article>
      @endforelse

      <div class="panduan-card">
        <div class="ic">📜</div>
        <h4>Mekanisme Pengaduan Nasabah</h4>
        <p>Panduan langkah-demi-langkah bagi nasabah untuk menyampaikan keluhan dan transparansi proses penyelesaian
          kami.</p>
        <a href="{{ route('public.kontak.index') }}" class="btn btn-outline">📄 Lihat Panduan</a>
        <a href="https://script.google.com/macros/s/AKfycbz2irj4A4hK90MEkrkybbPXAfiA56ojK0PZg48Kz2TqeLLTaxPAcmNfBX09AcKEY9SF/exec"
          class="btn btn-primary btn-block">Form Pengaduan</a>
      </div>
    </div>

  </div>
</section>

<section class="commitment-section">
  <div class="container">
    <div class="commitment-grid">
      <div>
        <h2>Komitmen Perlindungan Konsumen</h2>

        <div class="commitment-item">
          <div class="ic">🛡️</div>
          <div>
            <h5>Kerahasiaan Data</h5>
            <p>Kami menjamin keamanan data pribadi Anda sesuai dengan standar sistem manajemen keamanan informasi ISO
              27001.</p>
          </div>
        </div>

        <div class="commitment-item">
          <div class="ic">⚖️</div>
          <div>
            <h5>Keadilan & Transparansi</h5>
            <p>Sajian informasi produk yang jujur, tidak menyesatkan, dan akses penyelesaian sengketa yang adil.</p>
          </div>
        </div>

        <div class="commitment-item">
          <div class="ic">🎧</div>
          <div>
            <h5>Akses Pengaduan 24/7</h5>
            <p>Layanan Waway Care tersedia kapan saja untuk mendengarkan dan membantu kendala transaksi Anda.</p>
          </div>
        </div>
      </div>

      <div class="commitment-image-wrap">
        <img src="{{ asset('frontend/images/pelayanan-komitmen.jpg') }}" alt="Pelayanan nasabah Bank Waway Lampung">
        <div class="quote-badge">"Melayani dengan Hati, Membangun Negeri"</div>
      </div>
    </div>
  </div>
</section>

@endsection
