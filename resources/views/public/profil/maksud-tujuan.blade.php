@extends('layouts.public')

@section('title', 'Bank Waway Lampung - Maksud dan Tujuan')

@section('styles')
<style>
  .mkt-section {
    padding: 60px 0 90px;
  }

  .mkt-breadcrumb {
    font-size: 13px;
    color: var(--text-muted);
    margin-bottom: 14px;
  }

  .mkt-breadcrumb a {
    color: var(--text-muted);
  }

  .mkt-breadcrumb a:hover {
    color: var(--blue);
  }

  .mkt-breadcrumb strong {
    color: var(--navy);
  }

  .mkt-title-row {
    margin-bottom: 28px;
  }

  .mkt-title-row h1 {
    font-size: 32px;
    font-weight: 800;
    color: var(--navy);
    letter-spacing: -.5px;
    position: relative;
    padding-bottom: 14px;
    display: inline-block;
  }

  .mkt-title-row h1::after {
    content: "";
    position: absolute;
    left: 0;
    bottom: 0;
    width: 56px;
    height: 4px;
    background: var(--blue);
    border-radius: 2px;
  }

  .mkt-quote-card {
    background: #fff;
    border: 1px solid var(--border);
    border-radius: var(--radius);
    padding: 32px;
    display: flex;
    gap: 20px;
    align-items: center;
    margin-bottom: 44px;
  }

  .mkt-quote-ic {
    width: 56px;
    height: 56px;
    border-radius: 14px;
    background: var(--blue);
    color: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
    flex: none;
  }

  .mkt-quote-card p {
    font-size: 17px;
    font-weight: 600;
    color: var(--navy);
    line-height: 1.6;
  }

  .mkt-strategis-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 20px;
    margin-bottom: 48px;
  }

  .mkt-strategis-item {
    background: var(--bg-soft);
    border-radius: var(--radius);
    padding: 28px;
  }

  .mkt-strategis-item.highlight {
    background: var(--navy);
    color: #fff;
  }

  .mkt-strategis-item .ic {
    width: 42px;
    height: 42px;
    border-radius: 10px;
    background: var(--blue);
    color: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
    margin-bottom: 18px;
  }

  .mkt-strategis-item.highlight .ic {
    background: rgba(255, 255, 255, .18);
  }

  .mkt-strategis-item h4 {
    font-size: 17px;
    color: var(--navy);
    font-weight: 800;
    margin-bottom: 10px;
  }

  .mkt-strategis-item.highlight h4 {
    color: #fff;
  }

  .mkt-strategis-item p {
    font-size: 13.5px;
    color: var(--text-muted);
    line-height: 1.6;
  }

  .mkt-strategis-item.highlight p {
    color: #c7d3ef;
  }

  .mkt-kegiatan-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
  }

  .mkt-kegiatan-item {
    background: #fff;
    border: 1px solid var(--border);
    border-radius: var(--radius);
    padding: 26px;
    display: flex;
    gap: 16px;
  }

  .mkt-kegiatan-item .ic {
    width: 42px;
    height: 42px;
    border-radius: 10px;
    background: var(--blue);
    color: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
    flex: none;
  }

  .mkt-kegiatan-item h5 {
    font-size: 15.5px;
    color: var(--navy);
    font-weight: 700;
    margin-bottom: 6px;
  }

  .mkt-kegiatan-item p {
    font-size: 13.5px;
    color: var(--text-muted);
    line-height: 1.6;
  }

  @media(max-width:900px) {

    .mkt-strategis-grid,
    .mkt-kegiatan-grid {
      grid-template-columns: 1fr;
    }
  }
</style>
@endsection

@section('content')

<section class="page-hero">
  <img class="page-hero-bg" src="{{ asset('frontend/images/profil-hero.jpg') }}" alt="Kantor Pusat Bank Waway Lampung">
  <div class="container">
    <h1>Tentang Kami</h1>
    <div class="breadcrumb"><a href="{{ route('home') }}">Beranda</a> / Profil Perusahaan</div>
  </div>
</section>

<section class="mkt-section">
  <div class="container profil-wrap">

    <aside class="profil-sidebar">
      <h4>Profil</h4>
      <ul class="profil-side-menu">
        <li><a href="{{ route('public.profil.index') }}#pendirian">🕘 Pendirian Perusahaan</a></li>
        <li><a href="{{ route('public.profil.tempat-kedudukan') }}">📍 Tempat Kedudukan</a></li>
        <li><a href="{{ route('public.profil.maksud-tujuan') }}" class="active">📋 Maksud dan Tujuan Serta Kegiatan Usaha</a></li>
        <li><a href="{{ route('public.profil.perijinan-legalitas') }}">✅ Perijinan dan Legalitas Usaha</a></li>
        <li><a href="{{ route('public.layanan.modal') }}">💳 Modal</a></li>
        <li><a href="{{ route('public.profil.susunan-pengurus') }}">👥 Susunan Pengurus</a></li>
        <li><a href="{{ route('public.profil.visi-misi') }}">👁️ Visi & Misi</a></li>
        <li><a href="{{ route('public.profil.prestasi-penghargaan') }}">🏆 Prestasi dan Penghargaan</a></li>
        <li><a href="{{ route('public.profil.susunan-pengurus') }}">👤 Pengurus</a></li>
        <li><a href="{{ route('public.profil.index') }}">⬇ Download Company Profile</a></li>
      </ul>
      <div class="pdf-download">
        <div>
          <strong>Dokumen Perusahaan</strong>
          <span>Profil lengkap dalam PDF</span>
        </div>
        <a href="{{ route('public.profil.index') }}" class="btn btn-white">⬇ PDF</a>
      </div>
    </aside>

    <div class="profil-main">

      <div class="mkt-breadcrumb">
        <a href="{{ route('home') }}">Beranda</a> &nbsp;›&nbsp;
        <a href="{{ route('public.profil.index') }}">Profil</a> &nbsp;›&nbsp;
        <strong>Maksud dan Tujuan</strong>
      </div>

      <div class="mkt-title-row">
        <h1>Maksud dan Tujuan</h1>
      </div>

      <div class="mkt-quote-card">
        <div class="mkt-quote-ic">🏦</div>
        <p>"Berusaha dalam bidang Bank Perkreditan Rakyat (BPR) sesuai dengan ketentuan peraturan
          perundang-undangan yang berlaku."</p>
      </div>

      <div class="section-title-row"><span class="bar"></span>
        <h3>Tujuan Strategis</h3>
      </div>
      <div class="mkt-strategis-grid">
        <div class="mkt-strategis-item">
          <div class="ic">📈</div>
          <h4>Pertumbuhan Ekonomi</h4>
          <p>Mendorong pertumbuhan ekonomi daerah secara berkelanjutan melalui sirkulasi modal yang sehat.</p>
        </div>
        <div class="mkt-strategis-item highlight">
          <div class="ic">👥</div>
          <h4>Taraf Hidup Masyarakat</h4>
          <p>Meningkatkan kesejahteraan masyarakat, khususnya pelaku UMKM di wilayah Lampung.</p>
        </div>
        <div class="mkt-strategis-item">
          <div class="ic">🗂️</div>
          <h4>Sumber PAD</h4>
          <p>Memberikan kontribusi nyata sebagai salah satu sumber Pendapatan Asli Daerah (PAD).</p>
        </div>
      </div>

      <div class="section-title-row"><span class="bar"></span>
        <h3>Kegiatan Pokok Usaha</h3>
      </div>
      <div class="mkt-kegiatan-grid">
        <div class="mkt-kegiatan-item">
          <div class="ic">🐷</div>
          <div>
            <h5>Penghimpunan Dana</h5>
            <p>Menghimpun dana dari masyarakat dalam bentuk simpanan berupa deposito berjangka, tabungan, dan/atau
              bentuk lainnya.</p>
          </div>
        </div>
        <div class="mkt-kegiatan-item">
          <div class="ic">💳</div>
          <div>
            <h5>Penyaluran Kredit</h5>
            <p>Memberikan kredit bagi para pengusaha mikro, kecil, dan menengah untuk mendukung ekspansi bisnis
              mereka.</p>
          </div>
        </div>
        <div class="mkt-kegiatan-item">
          <div class="ic">🤝</div>
          <div>
            <h5>Kerjasama Antar Lembaga</h5>
            <p>Melakukan penempatan dana dan kerjasama antar BPR maupun dengan lembaga keuangan lainnya secara
              profesional.</p>
          </div>
        </div>
        <div class="mkt-kegiatan-item">
          <div class="ic">🏛️</div>
          <div>
            <h5>Usaha Perbankan Lainnya</h5>
            <p>Menjalankan kegiatan usaha perbankan lainnya yang tidak bertentangan dengan peraturan
              perundang-undangan.</p>
          </div>
        </div>
      </div>

    </div>
  </div>
</section>

@endsection
