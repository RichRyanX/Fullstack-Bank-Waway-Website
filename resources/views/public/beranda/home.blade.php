@extends('layouts.public')

@section('styles')
<style>
  .lps-section {
    padding: 80px 0 90px;
  }

  .lps-head {
    text-align: center;
    margin-bottom: 44px;
  }

  .lps-head h2 {
    font-size: 30px;
    font-weight: 800;
    color: var(--navy);
    letter-spacing: -.4px;
    margin-bottom: 10px;
  }

  .lps-head p {
    font-size: 15px;
    color: var(--text-muted);
    line-height: 1.6;
  }

  .lps-head .lps-period {
    display: block;
    margin-top: 2px;
  }

  .lps-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 24px;
    margin-bottom: 34px;
  }

  .lps-card {
    background: #fff;
    border: 1px solid var(--border);
    border-radius: var(--radius);
    padding: 36px 24px;
    text-align: center;
    transition: .25s;
  }

  .lps-card:hover {
    transform: translateY(-4px);
    box-shadow: var(--shadow);
  }

  .lps-card .lps-ic {
    font-size: 26px;
    margin-bottom: 16px;
    color: var(--navy);
  }

  .lps-card .lps-num {
    font-size: 32px;
    font-weight: 800;
    color: var(--navy);
    margin-bottom: 8px;
    letter-spacing: -.5px;
  }

  .lps-card .lps-lbl {
    font-size: 12.5px;
    font-weight: 700;
    letter-spacing: .5px;
    text-transform: uppercase;
    color: var(--text-muted);
  }

  .lps-card.highlight {
    background: var(--blue);
    border-color: var(--blue);
  }

  .lps-card.highlight .lps-ic,
  .lps-card.highlight .lps-num {
    color: #fff;
  }

  .lps-card.highlight .lps-lbl {
    color: rgba(255, 255, 255, .85);
  }

  .lps-note {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    font-size: 14px;
    color: var(--text);
    margin-bottom: 14px;
    flex-wrap: wrap;
    text-align: center;
  }

  .lps-note strong {
    color: var(--navy);
  }

  .lps-link-wrap {
    text-align: center;
  }

  .lps-link-wrap a {
    color: var(--blue);
    font-weight: 700;
    font-size: 14.5px;
    display: inline-flex;
    align-items: center;
    gap: 6px;
  }

  .lps-link-wrap a:hover {
    text-decoration: underline;
  }

  .info-section {
    padding: 72px 0 80px;
    background: var(--bg);
  }

  .info-section .section-title {
    margin-bottom: 8px;
  }

  .info-section .section-sub {
    margin-bottom: 44px;
  }

  .info-carousel {
    position: relative;
    width: 100%;
  }

  .info-slides {
    position: relative;
    background: #fff;
    border-radius: var(--radius);
    overflow: hidden;
    box-shadow: var(--shadow);
    border: 1px solid var(--border);
  }

  .info-slide {
    display: none;
    grid-template-columns: 1fr 1fr;
    min-height: 360px;
  }

  .info-slide.active {
    display: grid;
  }

  .info-slide-media {
    position: relative;
    min-height: 260px;
  }

  .info-slide-media img {
    position: absolute;
    inset: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
  }

  .info-slide-tag {
    position: absolute;
    top: 20px;
    left: 20px;
    z-index: 2;
    display: inline-block;
    background: var(--blue);
    color: #fff;
    font-size: 11.5px;
    font-weight: 800;
    letter-spacing: .5px;
    text-transform: uppercase;
    padding: 6px 14px;
    border-radius: 999px;
  }

  .info-slide-body {
    padding: 44px 46px;
    display: flex;
    flex-direction: column;
    justify-content: center;
  }

  .info-slide-date {
    display: block;
    font-size: 13px;
    color: var(--text-muted);
    margin-bottom: 12px;
    font-weight: 600;
  }

  .info-slide-body h3 {
    font-size: 23px;
    font-weight: 800;
    color: var(--navy);
    line-height: 1.35;
    margin-bottom: 14px;
    letter-spacing: -.3px;
  }

  .info-slide-body p {
    font-size: 14.5px;
    color: var(--text-muted);
    line-height: 1.7;
    margin-bottom: 22px;
  }

  .info-slide-link {
    color: var(--blue);
    font-weight: 700;
    font-size: 14.5px;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    width: fit-content;
  }

  .info-slide-link:hover {
    text-decoration: underline;
  }

  .info-nav-row {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 22px;
    margin-top: 28px;
  }

  .info-arrow {
    flex: none;
    width: 42px;
    height: 42px;
    border-radius: 50%;
    border: 1px solid var(--border);
    cursor: pointer;
    background: #fff;
    color: var(--navy);
    font-size: 16px;
    transition: .2s;
    display: flex;
    align-items: center;
    justify-content: center;
  }

  .info-arrow:hover {
    background: var(--navy);
    border-color: var(--navy);
    color: #fff;
  }

  .info-dots {
    display: flex;
    align-items: center;
    gap: 10px;
  }

  .info-dots .dot {
    width: 10px;
    height: 10px;
    border-radius: 50%;
    background: var(--border);
    cursor: pointer;
    border: none;
    padding: 0;
    transition: .2s;
  }

  .info-dots .dot.active {
    background: var(--blue);
    transform: scale(1.15);
  }

  @media(max-width:900px) {
    .info-slide.active {
      grid-template-columns: 1fr;
    }

    .info-slide-media {
      min-height: 200px;
    }

    .info-slide-body {
      padding: 30px 26px;
    }

    .info-slide-body h3 {
      font-size: 20px;
    }
  }

  @media(max-width:900px) {
    .lps-grid {
      grid-template-columns: 1fr;
    }
  }
</style>
@endsection

@section('content')

<section class="hero-carousel">
  <div class="slides">
    <div class="slide active">
      <img class="hero-bg" src="{{ asset('admin/images/Bangunan.png') }}" alt="Gedung Bank Waway Lampung">
      <div class="hero-overlay"></div>
      <div class="container hero-content">
        <h1>Membangun Ekonomi Lampung<br>Bersama Bank Waway</h1>
        <p>Solusi finansial terintegrasi untuk masyarakat Lampung yang lebih sejahtera dan mandiri.</p>
        <a href="{{ route('home') }}#profil" class="btn btn-primary">Pelajari Lebih Lanjut</a>
      </div>
    </div>
  </div>
</section>

<section class="info-section">
  <div class="container">
    <h2 class="section-title">Info Terkini</h2>
    <p class="section-sub">Update terbaru dan terpopuler seputar layanan Bank Waway Lampung.</p>

    <div class="info-carousel">
      <div class="info-slides">
        <div class="info-slide active">
          <div class="info-slide-media">
            <img src="{{ asset('admin/images/Bangunan.png') }}" alt="Layanan Tabungan Digital">
            <span class="info-slide-tag">Terbaru</span>
          </div>
          <div class="info-slide-body">
            <span class="info-slide-date">📅 01 Agustus 2026</span>
            <h3>Bank Waway Lampung Luncurkan Layanan Tabungan Digital Terbaru</h3>
            <p>Nikmati kemudahan membuka rekening dan bertransaksi secara online, kapan saja dan di mana saja,
              dengan proses yang lebih cepat dan aman.</p>
            <a href="{{ route('public.berita.index') }}" class="info-slide-link">Baca Selengkapnya →</a>
          </div>
        </div>

        <div class="info-slide">
          <div class="info-slide-media">
            <img src="{{ asset('admin/images/Bangunan.png') }}" alt="Promo Bunga Deposito">
            <span class="info-slide-tag">Terpopuler</span>
          </div>
          <div class="info-slide-body">
            <span class="info-slide-date">📅 28 Juli 2026</span>
            <h3>Promo Bunga Deposito Spesial Hingga Akhir Tahun 2026</h3>
            <p>Dapatkan penawaran bunga deposito terbaik untuk nasabah baru maupun lama, dengan tenor fleksibel
              dan proses pembukaan yang mudah.</p>
            <a href="{{ route('public.produk.show', ['slug' => 'deposito']) }}" class="info-slide-link">Baca Selengkapnya →</a>
          </div>
        </div>

        <div class="info-slide">
          <div class="info-slide-media">
            <img src="{{ asset('admin/images/Bangunan.png') }}" alt="Jadwal Operasional Kantor">
            <span class="info-slide-tag">Pengumuman</span>
          </div>
          <div class="info-slide-body">
            <span class="info-slide-date">📅 20 Juli 2026</span>
            <h3>Jadwal Operasional Kantor Selama Periode Libur Nasional</h3>
            <p>Simak jadwal layanan kantor cabang dan kantor kas Bank Waway Lampung agar transaksi Anda tetap
              berjalan lancar.</p>
            <a href="{{ route('public.berita.index') }}" class="info-slide-link">Baca Selengkapnya →</a>
          </div>
        </div>
      </div>

      <div class="info-nav-row">
        <button class="info-arrow prev" aria-label="Info Sebelumnya" onclick="infoGeser(-1)">&#10094;</button>
        <div class="info-dots">
          <button class="dot active" onclick="infoKe(0)" aria-label="Info 1"></button>
          <button class="dot" onclick="infoKe(1)" aria-label="Info 2"></button>
          <button class="dot" onclick="infoKe(2)" aria-label="Info 3"></button>
        </div>
        <button class="info-arrow next" aria-label="Info Berikutnya" onclick="infoGeser(1)">&#10095;</button>
      </div>
    </div>
  </div>
</section>

<section class="section">
  <div class="container">
    <h2 class="section-title">Produk Unggulan Kami</h2>
    <p class="section-sub">Pilih layanan perbankan yang tepat untuk kebutuhan pribadi maupun bisnis Anda.</p>

    <div class="grid-3" style="margin-top:52px">
      <article class="card">
        <img class="card-img" src="{{ asset('admin/images/Bangunan.png') }}" alt="Tabungan">
        <div class="card-body">
          <h3>Tabungan</h3>
          <p>Nikmati kemudahan menabung dengan bunga kompetitif dan biaya administrasi ringan untuk masa depan Anda.
          </p>
          <a href="{{ route('public.produk.show', ['slug' => 'tabungan']) }}" class="card-link">Lihat Selengkapnya →</a>
        </div>
      </article>

      <article class="card">
        <img class="card-img" src="{{ asset('admin/images/Bangunan.png') }}" alt="Deposito">
        <div class="card-body">
          <h3>Deposito</h3>
          <p>Investasi cerdas dengan jangka waktu fleksibel dan tingkat pengembalian yang maksimal serta terjamin.</p>
          <a href="{{ route('public.produk.show', ['slug' => 'deposito']) }}" class="card-link">Lihat Selengkapnya →</a>
        </div>
      </article>

      <article class="card">
        <img class="card-img" src="{{ asset('admin/images/Bangunan.png') }}" alt="Kredit">
        <div class="card-body">
          <h3>Kredit</h3>
          <p>Wujudkan impian memiliki hunian, kendaraan, atau pengembangan usaha dengan pembiayaan ringan kami.</p>
          <a href="{{ route('public.produk.show', ['slug' => 'pinjaman']) }}" class="card-link">Lihat Selengkapnya →</a>
        </div>
      </article>
    </div>
  </div>
</section>

<section class="lps-section">
  <div class="container">
    <div class="lps-head">
      <h2>Tingkat Bunga Penjaminan</h2>
      <p>
        Lembaga Penjamin Simpanan
        <span class="lps-period">(Periode 01 Juli 2026 - 30 September 2026)</span>
      </p>
    </div>

    <div class="lps-grid">
      <div class="lps-card">
        <div class="lps-ic">📊</div>
        <div class="lps-num">3.75%</div>
        <div class="lps-lbl">Bank Umum (IDR)</div>
      </div>

      <div class="lps-card highlight">
        <div class="lps-ic">📉</div>
        <div class="lps-num">6.25%</div>
        <div class="lps-lbl">BPR</div>
      </div>

      <div class="lps-card">
        <div class="lps-ic">◐</div>
        <div class="lps-num">2%</div>
        <div class="lps-lbl">Bank Umum (Valas)</div>
      </div>
    </div>

    <div class="lps-note">
      🛡️ Maksimum simpanan dijamin LPS: <strong>Rp 2 Miliar</strong> per nasabah per bank
    </div>

    <div class="lps-link-wrap">
      <a href="https://lps.go.id" target="_blank" rel="noopener">Lihat Detail Resmi di LPS →</a>
    </div>
  </div>
</section>

@endsection

@section('scripts')
<script>
  (function () {
    var infoIndex = 0;
    var infoSlides, infoDots, infoTimer;

    function infoTampilkan(i) {
      infoSlides = document.querySelectorAll('.info-slide');
      infoDots = document.querySelectorAll('.info-dots .dot');
      if (!infoSlides.length) return;
      infoIndex = (i + infoSlides.length) % infoSlides.length;
      infoSlides.forEach(function (s, idx) { s.classList.toggle('active', idx === infoIndex); });
      infoDots.forEach(function (d, idx) { d.classList.toggle('active', idx === infoIndex); });
    }

    window.infoGeser = function (arah) { infoTampilkan(infoIndex + arah); resetInfoTimer(); };
    window.infoKe = function (i) { infoTampilkan(i); resetInfoTimer(); };

    function resetInfoTimer() {
      clearInterval(infoTimer);
      infoTimer = setInterval(function () { infoTampilkan(infoIndex + 1); }, 6000);
    }

    document.addEventListener('DOMContentLoaded', function () {
      infoTampilkan(0);
      resetInfoTimer();
    });
  })();
</script>
@endsection
