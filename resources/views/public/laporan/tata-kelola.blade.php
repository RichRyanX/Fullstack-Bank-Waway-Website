@extends('layouts.public')

@section('title', 'Tata Kelola Perusahaan (GCG) - Bank Waway Lampung')

@section('content')

<section class="page-hero">
  <div class="page-hero-overlay"></div>
  <div class="container hero-content">
    <div class="breadcrumb">
      <a href="{{ route('home') }}">Beranda</a> <span>/</span> <a href="{{ route('public.laporan.index') }}">Laporan</a> <span>/</span> <span class="active">Tata
        Kelola / GCG</span>
    </div>
    <h1>Tata Kelola Perusahaan (GCG)</h1>
    <p class="hero-description">
      Membangun kepercayaan melalui transparansi, akuntabilitas, dan profesionalisme yang berkelanjutan di Bank Waway
      Lampung.
    </p>
    <a href="#dokumen" class="btn btn-white">📄 Lihat Dokumen</a>
  </div>
</section>

<section class="gcg-section">
  <div class="container">

    <div class="gcg-intro-row">
      <div class="gcg-title-block">
        <span class="eyebrow">Kerangka Kerja</span>
        <h2>Pilar Tata Kelola Kami</h2>
      </div>
      <p>Kami menerapkan prinsip GCG (TARIF: Transparansi, Akuntabilitas, Responsibilitas, Independensi, dan Fairness)
        di setiap lini operasional.</p>
    </div>

    <div class="gcg-pillar-grid">
      <article class="gcg-struktur-card">
        <div class="gcg-icon-box">🏛️</div>
        <h3>Struktur Organisasi GCG</h3>
        <p>Struktur tata kelola kami didesain untuk memastikan adanya checks and balances yang efektif antara Rapat
          Umum Pemegang Saham (RUPS), Dewan Komisaris, dan Direksi. Komite-komite di bawah Dewan Komisaris berperan
          aktif dalam pengawasan independen.</p>
      </article>

      <article class="gcg-etika-card">
        <div class="gcg-icon-box">🌐</div>
        <h3>Etika & Budaya</h3>
        <p>Pedoman Etika dan Perilaku (Code of Conduct) menjadi landasan bagi setiap insan Bank Waway Lampung dalam
          berinteraksi dengan pemangku kepentingan.</p>
        <a href="{{ route('public.laporan.index') }}" class="btn">📖 Baca Pedoman Etika</a>
      </article>
    </div>

    <div class="gcg-tarif-grid">
      <div class="gcg-tarif-item">
        <h5>Transparansi</h5>
        <p>Penyajian informasi keuangan dan non-keuangan secara akurat dan tepat waktu kepada publik.</p>
      </div>
      <div class="gcg-tarif-item navy">
        <h5>Akuntabilitas</h5>
        <p>Kejelasan fungsi dan pelaksanaan pertanggungjawaban organ bank agar pengelolaan berjalan efektif.</p>
      </div>
      <div class="gcg-tarif-item">
        <h5>Independensi</h5>
        <p>Pengelolaan bank secara profesional tanpa benturan kepentingan dan pengaruh dari pihak manapun.</p>
      </div>
    </div>

  </div>
</section>

<section class="gcg-section" id="dokumen" style="padding-top:0">
  <div class="container">
    <div class="section-title-row" style="margin-bottom:6px">
      <span class="bar"></span>
      <h3 style="font-size:28px">Pusat Laporan & Dokumen</h3>
    </div>
    <p style="color:var(--text-muted);font-size:14.5px;margin-bottom:32px">Akses transparan ke seluruh dokumen tata
      kelola perusahaan kami.</p>

    <div class="laporan-grid">
      @forelse($reports as $report)
      <article class="laporan-card" data-year="{{ $report->fiscal_year }}" data-keyword="{{ strtolower($report->title) }}">
        <div class="laporan-cover">
          <img src="{{ asset('admin/images/Bangunan.png') }}" alt="Laporan Bangunan Bank Waway Lampung">
          @if($loop->first)
          <span class="badge-terbaru">Terbaru</span>
          @endif
          <h4>Laporan Tata Kelola {{ $report->fiscal_year }}</h4>
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
        <div class="ic">🗂️</div>
        <h5>Belum Ada Dokumen</h5>
        <p>Dokumen tata kelola belum tersedia. Silakan kembali lagi nanti untuk memperoleh laporan terbaru kami.</p>
      </div>
      @endforelse
    </div>

    <div class="wbs-banner" id="wbs">
      <div class="wbs-text">
        <h2>Whistleblowing System (WBS)</h2>
        <p>Wujud komitmen kami dalam menegakkan integritas. Laporkan setiap tindakan yang menyimpang dari prinsip GCG
          melalui saluran resmi kami yang aman dan rahasia.</p>
      </div>
      <div class="wbs-actions">
        <div class="wbs-contact"><a href="mailto:Bankwawaylampung@yahoo.com" target="_blank" rel="noopener">✉️
            Bankwawaylampung@yahoo.com</a></div>
        <div class="wbs-contact"><a
            href="https://api.whatsapp.com/send/?phone=6285382659996&text&type=phone_number&app_absent=0"
            target="_blank" rel="noopener">📞 +0721 266 869</a></div>
        <a href="{{ route('public.whistleblowing.index') }}" class="btn btn-primary">Laporkan Pelanggaran</a>
      </div>
    </div>

  </div>
</section>

@endsection
