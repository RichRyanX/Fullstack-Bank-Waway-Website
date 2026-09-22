@extends('layouts.public')

@section('title', 'Bank Waway Lampung - Laporan Tahunan')

@section('content')

<section class="page-hero">
  <div class="page-hero-overlay"></div>
  <div class="container hero-content">
    <div class="breadcrumb">
      <a href="{{ route('home') }}">Beranda</a> <span>/</span> <a href="{{ route('public.laporan.index') }}">Laporan</a> <span>/</span> <span class="active">Laporan Tahunan</span>
    </div>
    <h1>Laporan Tahunan</h1>
    <p class="hero-description">
      Bank Waway Lampung berkomitmen pada transparansi dan tata kelola perusahaan yang baik (Good Corporate Governance). Laporan tahunan kami menyajikan tinjauan komprehensif mengenai kinerja keuangan, pencapaian operasional, serta strategi keberlanjutan kami dalam melayani masyarakat Lampung dan sekitarnya.
    </p>
    <a href="#dokumen" class="btn btn-white">📄 Lihat Dokumen</a>
  </div>
</section>

<section class="section" id="dokumen">
  <div class="container">

    <div class="arsip-header">
      <h2>Laporan Tahunan</h2>
      <div class="arsip-search">🔍 <input type="text" id="arsipSearch" placeholder="Cari tahun atau kata kunci...">
      </div>
    </div>

    <div class="laporan-grid" id="laporanGrid">
      @forelse($reports as $report)
      <article class="laporan-card" data-year="{{ $report->fiscal_year }}" data-keyword="{{ strtolower($report->title) }}">
        <div class="laporan-cover" style="background-color:var(--navy);background-image:url('{{ asset('admin/images/Bangunan.png') }}')">
          @if($loop->first)
          <span class="badge-terbaru">Terbaru</span>
          @endif
          <h4>Laporan Tahunan {{ $report->fiscal_year }}</h4>
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
      <div class="laporan-alt">
        <div class="ic">📄</div>
        <h5>Belum Ada Laporan</h5>
        <p>Laporan tahunan belum tersedia. Silakan kembali lagi nanti untuk memperoleh laporan terbaru kami.</p>
      </div>
      @endforelse
    </div>

    <div style="height:44px"></div>

  </div>
</section>

@endsection
