@extends('layouts.public')

@section('title', 'Bank Waway Lampung - Laporan Keberlanjutan')

@section('bodyClass', 'class="kb-page"')

@section('content')

<section class="page-hero">
  <div class="page-hero-overlay"></div>
  <div class="container hero-content">
    <div class="breadcrumb">
      <a href="{{ route('home') }}">Beranda</a> <span>/</span> <a href="{{ route('public.laporan.index') }}">Laporan</a> <span>/</span> <span class="active">Laporan Keberlanjutan</span>
    </div>
    <h1>Laporan Keberlanjutan</h1>
    <p class="hero-description">
      Bank Waway Lampung berkomitmen untuk menjalankan operasional perbankan yang bertanggung jawab dan berkelanjutan. Transparansi adalah kunci dalam perjalanan kami mewujudkan dampak positif bagi lingkungan dan masyarakat.
    </p>
    <a href="#dokumen" class="btn btn-white">📄 Lihat Dokumen</a>
  </div>
</section>

<section class="section" style="background:var(--bg-soft)">
  <div class="container esg-grid">
    <div class="esg-card e">
      <div class="ic">🌿</div>
      <h4>Lingkungan (E)</h4>
      <p>Mengurangi jejak karbon operasional melalui digitalisasi layanan dan pembiayaan proyek-proyek ramah
        lingkungan di Lampung.</p>
    </div>
    <div class="esg-card s">
      <div class="ic">👥</div>
      <h4>Sosial (S)</h4>
      <p>Mendorong inklusi keuangan bagi UMKM lokal dan mendukung pemberdayaan masyarakat melalui program CSR yang
        berkelanjutan.</p>
    </div>
    <div class="esg-card g">
      <div class="ic">⚖️</div>
      <h4>Tata Kelola (G)</h4>
      <p>Menjunjung tinggi standar etika bisnis, transparansi laporan, dan manajemen risiko yang kokoh untuk
        kepercayaan nasabah.</p>
    </div>
  </div>
</section>

<section class="section" id="dokumen">
  <div class="container">
    <div class="kb-arsip-header">
      <h2>Laporan Keberlanjutan</h2>
      <div class="view-toggle">
        <button class="active" aria-label="Tampilan grid">⊞</button>
      </div>
    </div>

    <div class="laporan-grid">
      @forelse($reports as $report)
      <article class="laporan-card" data-year="{{ $report->fiscal_year }}" data-keyword="{{ strtolower($report->title) }}">
        <div class="laporan-cover" style="background-color:var(--navy);background-image:url('{{ asset('admin/images/Bangunan.png') }}')">
          @if($loop->first)
          <span class="badge-terbaru">Terbaru</span>
          @endif
          <h4>Laporan Keberlanjutan {{ $report->fiscal_year }}</h4>
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
        <div class="ic">🌿</div>
        <h5>Belum Ada Laporan</h5>
        <p>Laporan keberlanjutan belum tersedia. Silakan kembali lagi nanti untuk memperoleh laporan terbaru kami.</p>
      </div>
      @endforelse
    </div>
  </div>
</section>

@endsection
