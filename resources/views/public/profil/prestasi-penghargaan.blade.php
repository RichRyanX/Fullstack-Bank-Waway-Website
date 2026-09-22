@extends('layouts.public')

@section('title', 'Bank Waway Lampung - Prestasi & Penghargaan')

@section('styles')
<style>
  .pp-section {
    padding: 60px 0 90px;
  }

  .pp-breadcrumb {
    font-size: 13px;
    color: var(--text-muted);
    margin-bottom: 14px;
  }

  .pp-breadcrumb a {
    color: var(--text-muted);
  }

  .pp-breadcrumb a:hover {
    color: var(--blue);
  }

  .pp-breadcrumb strong {
    color: var(--navy);
  }

  .pp-title-row {
    margin-bottom: 20px;
  }

  .pp-title-row h1 {
    font-size: 32px;
    font-weight: 800;
    color: var(--navy);
    letter-spacing: -.5px;
    position: relative;
    padding-bottom: 14px;
    display: inline-block;
  }

  .pp-title-row h1::after {
    content: "";
    position: absolute;
    left: 0;
    bottom: 0;
    width: 56px;
    height: 4px;
    background: var(--blue);
    border-radius: 2px;
  }

  .pp-intro {
    font-size: 15px;
    color: var(--text-muted);
    line-height: 1.8;
    margin-bottom: 32px;
    max-width: 820px;
  }

  .pp-gallery-grid {
    display: grid;
    grid-template-columns: 1.6fr 1fr;
    gap: 24px;
    margin-bottom: 28px;
    align-items: start;
  }

  .pp-gallery-img {
    border-radius: var(--radius);
    background: linear-gradient(160deg, #eef1fb, #c7cedb);
    min-height: 360px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 40px;
    color: var(--text-muted);
    border: 1px solid var(--border);
  }

  .pp-side-stack {
    display: flex;
    flex-direction: column;
    gap: 20px;
  }

  .pp-award-card {
    background: var(--bg-soft);
    border-radius: var(--radius);
    padding: 24px;
  }

  .pp-award-card .ic {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    background: var(--blue);
    color: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 17px;
    margin-bottom: 16px;
  }

  .pp-award-card h4 {
    font-size: 17px;
    color: var(--navy);
    font-weight: 800;
    margin-bottom: 10px;
    line-height: 1.3;
  }

  .pp-award-card p {
    font-size: 13.5px;
    color: var(--text-muted);
    line-height: 1.6;
  }

  .pp-gallery-cap {
    margin-bottom: 44px;
  }

  .pp-pill {
    display: inline-block;
    background: var(--bg-soft);
    color: var(--blue);
    font-size: 12px;
    font-weight: 700;
    padding: 6px 14px;
    border-radius: 999px;
    margin-bottom: 14px;
  }

  .pp-gallery-cap h3 {
    font-size: 22px;
    color: var(--navy);
    font-weight: 800;
    margin-bottom: 10px;
  }

  .pp-gallery-cap p {
    font-size: 14px;
    color: var(--text-muted);
    font-style: italic;
    line-height: 1.7;
    max-width: 700px;
  }

  .pp-list-head {
    margin-bottom: 20px;
  }

  .pp-list-head h3 {
    font-size: 20px;
    color: var(--navy);
    font-weight: 800;
  }

  .pp-list-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 20px;
    margin-bottom: 44px;
  }

  .pp-award-item {
    background: #fff;
    border: 1px solid var(--border);
    border-radius: var(--radius);
    padding: 24px;
  }

  .pp-award-item .yr {
    font-size: 12px;
    font-weight: 700;
    color: var(--blue);
    margin-bottom: 10px;
  }

  .pp-award-item h5 {
    font-size: 16px;
    color: var(--navy);
    font-weight: 700;
    margin-bottom: 10px;
    line-height: 1.35;
  }

  .pp-award-item p {
    font-size: 13px;
    color: var(--text-muted);
    line-height: 1.6;
    margin-bottom: 14px;
  }

  .pp-award-item .src {
    font-size: 12.5px;
    color: var(--text-muted);
    display: flex;
    align-items: center;
    gap: 6px;
    border-top: 1px solid var(--border);
    padding-top: 12px;
  }

  .pp-cta {
    background: var(--navy);
    border-radius: var(--radius);
    padding: 56px 40px;
    color: #fff;
    text-align: center;
  }

  .pp-cta h3 {
    font-size: 26px;
    font-weight: 800;
    margin-bottom: 14px;
  }

  .pp-cta p {
    font-size: 14.5px;
    color: #c7d3ef;
    max-width: 640px;
    margin: 0 auto 28px;
    line-height: 1.7;
  }

  .pp-cta-actions {
    display: flex;
    gap: 14px;
    justify-content: center;
    flex-wrap: wrap;
  }

  @media(max-width:900px) {

    .pp-gallery-grid,
    .pp-list-grid {
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

<section class="pp-section">
  <div class="container profil-wrap">

    <aside class="profil-sidebar">
      <h4>Profil</h4>
      <ul class="profil-side-menu">
        <li><a href="{{ route('public.profil.index') }}#pendirian">🕘 Pendirian Perusahaan</a></li>
        <li><a href="{{ route('public.profil.tempat-kedudukan') }}">📍 Tempat Kedudukan</a></li>
        <li><a href="{{ route('public.profil.maksud-tujuan') }}">📋 Maksud dan Tujuan Serta Kegiatan Usaha</a></li>
        <li><a href="{{ route('public.profil.perijinan-legalitas') }}">✅ Perijinan dan Legalitas Usaha</a></li>
        <li><a href="{{ route('public.layanan.modal') }}">💳 Modal</a></li>
        <li><a href="{{ route('public.profil.susunan-pengurus') }}">👥 Susunan Pengurus</a></li>
        <li><a href="{{ route('public.profil.visi-misi') }}">👁️ Visi & Misi</a></li>
        <li><a href="{{ route('public.profil.prestasi-penghargaan') }}" class="active">🏆 Prestasi dan Penghargaan</a></li>
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

      <div class="pp-breadcrumb">
        <a href="{{ route('home') }}">Beranda</a> &nbsp;›&nbsp;
        <a href="{{ route('public.profil.index') }}">Profil</a> &nbsp;›&nbsp;
        <strong>Prestasi & Penghargaan</strong>
      </div>

      <div class="pp-title-row">
        <h1>Prestasi & Penghargaan</h1>
      </div>

      <p class="pp-intro">Pengakuan atas dedikasi dan kinerja luar biasa kami. Setiap penghargaan merupakan bukti
        komitmen Bank Waway Lampung dalam memberikan layanan perbankan terbaik dan kontribusi positif bagi
        perekonomian daerah.</p>

      <div class="pp-gallery-grid">
        <div class="pp-gallery-img">🏆 Galeri Penghargaan</div>
        <div class="pp-side-stack">
          <div class="pp-award-card">
            <div class="ic">🎖️</div>
            <h4>Infobank Golden Award</h4>
            <p>Predikat kinerja "Sangat Bagus" selama 10 tahun berturut-turut dalam ajang Infobank Awards.</p>
          </div>
          <div class="pp-award-card">
            <div class="ic">🏅</div>
            <h4>Top BUMD Awards 2021</h4>
            <p>Penghargaan sebagai salah satu Bank Pembangunan Daerah terbaik dengan tata kelola unggul.</p>
          </div>
        </div>
      </div>

      <div class="pp-gallery-cap">
        <span class="pp-pill">Pencapaian Utama</span>
        <h3>Galeri Keunggulan Operasional</h3>
        <p>Bank Waway Lampung secara konsisten meraih predikat "Sangat Bagus" dalam penilaian kinerja perbankan
          nasional.</p>
      </div>

      <div class="pp-list-head">
        <h3>Daftar Penghargaan Terbaru</h3>
      </div>
      <div class="pp-list-grid">
        <div class="pp-award-item">
          <div class="yr">2023</div>
          <h5>Excellent Financial Performance</h5>
          <p>Apresiasi atas pertumbuhan aset dan rasio keuangan yang stabil di tengah tantangan ekonomi global.</p>
          <div class="src">✅ Asosiasi Bank Daerah</div>
        </div>
        <div class="pp-award-item">
          <div class="yr">2022</div>
          <h5>Digital Innovation Award</h5>
          <p>Inovasi layanan mobile banking yang memudahkan nasabah di pelosok Lampung mendapatkan akses
            finansial.</p>
          <div class="src">✅ Fintech Indonesia Congress</div>
        </div>
        <div class="pp-award-item">
          <div class="yr">2022</div>
          <h5>Best SME Support Bank</h5>
          <p>Komitmen berkelanjutan dalam menyalurkan KUR dan pendampingan UMKM lokal Lampung.</p>
          <div class="src">✅ Kementerian Koperasi & UKM</div>
        </div>
      </div>

      <div class="pp-cta">
        <h3>Tumbuh Bersama Bank Waway</h3>
        <p>Mari menjadi bagian dari perjalanan kami menuju keunggulan. Hubungi kami untuk solusi perbankan yang
          terpercaya dan inovatif.</p>
        <div class="pp-cta-actions">
          <a href="https://api.whatsapp.com/send/?phone=6285382659996&text&type=phone_number&app_absent=0" class="btn btn-primary">Hubungi Kami</a>
          <a href="{{ route('public.governance.laporan-tahunan') }}" class="btn btn-outline-white">Lihat Laporan Tahunan</a>
        </div>
      </div>

    </div>
  </div>
</section>

@endsection
