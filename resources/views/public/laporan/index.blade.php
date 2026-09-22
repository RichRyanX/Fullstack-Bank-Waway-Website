@extends('layouts.public')

@section('title', 'Bank Waway Lampung - Informasi & Publikasi')

@section('content')

<section class="page-hero">
  <div class="page-hero-overlay"></div>
  <div class="container hero-content">
    <div class="breadcrumb">
      <a href="{{ route('home') }}">Beranda</a> <span>/</span> <a href="{{ route('public.laporan.index') }}">Laporan</a> <span>/</span> <span class="active">Laporan Publikasi</span>
    </div>
    <h1>Informasi & Publikasi</h1>
    <p class="hero-description">
      Transparansi adalah inti dari operasional kami. Temukan laporan keuangan tahunan, laporan triwulanan, dan pengungkapan resmi dari Bank Waway Lampung dalam satu tempat.
    </p>
    <a href="#dokumen" class="btn btn-white">📄 Lihat Dokumen</a>
  </div>
</section>

<section class="section pub-head" id="dokumen">
  <div class="container">
    <div class="pub-search-actions">
      <div class="pub-search-box">🔍 <input type="text" id="pubSearch" placeholder="Cari laporan..."></div>
      <button class="pub-filter-btn">☰ Filter</button>
    </div>
  </div>
</section>

<section class="section" style="padding-top:0">
  <div class="container pub-layout">

    <aside>
      <div class="kategori-card">
        <h4>Kategori</h4>
        <div class="kategori-item active" data-cat="semua"><span>Semua Publikasi</span><span class="count">{{ $reports->count() }}</span></div>
        @foreach($categories ?? [] as $cat)
        <div class="kategori-item" data-cat="{{ strtolower($cat) }}"><span>{{ ucfirst($cat) }}</span></div>
        @endforeach
      </div>
    </aside>

    <div>
      <div class="pub-section-title"> Laporan Terbaru</div>

      <div class="featured-pub-grid">
        @forelse($reports as $report)
        <article class="laporan-card" data-year="{{ $report->fiscal_year }}" data-keyword="{{ strtolower($report->title) }}">
          <div class="laporan-cover">
            <img src="{{ asset('admin/images/Bangunan.png') }}" alt="Laporan Bangunan Bank Waway Lampung">
            @if($loop->first)
            <span class="badge-terbaru">Terbaru</span>
            @endif
            <h4>Laporan Publikasi {{ $report->fiscal_year }}</h4>
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
          <h5>Belum Ada Publikasi</h5>
          <p>Belum ada laporan yang diterbitkan. Silakan kembali lagi nanti.</p>
        </div>
        @endforelse
      </div>

      @if($reports->count() > 0)
      <div class="pagination">
        <button id="pubPagePrev">‹</button>
        <button class="active">1</button>
        <button id="pubPageNext">›</button>
      </div>
      @endif
    </div>
  </div>
</section>

@endsection
