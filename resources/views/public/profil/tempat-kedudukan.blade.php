@extends('layouts.public')

@section('title', 'Bank Waway Lampung - Tempat Kedudukan')

@section('styles')
<style>
  .kdd-section {
    padding: 60px 0 90px;
  }

  .kdd-breadcrumb {
    font-size: 13px;
    color: var(--text-muted);
    margin-bottom: 14px;
  }

  .kdd-breadcrumb a {
    color: var(--text-muted);
  }

  .kdd-breadcrumb a:hover {
    color: var(--blue);
  }

  .kdd-breadcrumb strong {
    color: var(--navy);
  }

  .kdd-title-row {
    margin-bottom: 28px;
  }

  .kdd-title-row h1 {
    font-size: 32px;
    font-weight: 800;
    color: var(--navy);
    letter-spacing: -.5px;
    position: relative;
    padding-bottom: 14px;
    display: inline-block;
  }

  .kdd-title-row h1::after {
    content: "";
    position: absolute;
    left: 0;
    bottom: 0;
    width: 56px;
    height: 4px;
    background: var(--blue);
    border-radius: 2px;
  }

  .kdd-hq-card {
    background: #fff;
    border: 1px solid var(--border);
    border-radius: var(--radius);
    padding: 32px;
    margin-bottom: 24px;
  }

  .kdd-hq-top {
    display: flex;
    gap: 16px;
    margin-bottom: 22px;
  }

  .kdd-hq-ic {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    background: var(--bg-soft);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    color: var(--navy);
    flex: none;
  }

  .kdd-hq-top h3 {
    font-size: 19px;
    color: var(--navy);
    margin-bottom: 4px;
  }

  .kdd-hq-top span {
    font-size: 14px;
    color: var(--text-muted);
  }

  .kdd-hq-body {
    display: grid;
    grid-template-columns: 1.4fr 1fr;
    gap: 28px;
    align-items: stretch;
  }

  .kdd-hq-label {
    font-size: 11.5px;
    font-weight: 700;
    letter-spacing: .6px;
    text-transform: uppercase;
    color: var(--text-muted);
    margin-bottom: 8px;
  }

  .kdd-hq-address {
    font-size: 15px;
    color: var(--text);
    line-height: 1.7;
    margin-bottom: 18px;
  }

  .kdd-hq-contact {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 14.5px;
    color: var(--text);
    margin-bottom: 8px;
  }

  .kdd-hq-contact .ic {
    color: var(--blue);
    width: 18px;
    text-align: center;
  }

  .kdd-hq-photo {
    border-radius: 12px;
    background: linear-gradient(160deg, #c7cedb, #8f97a8);
    position: relative;
    overflow: hidden;
    min-height: 160px;
  }

  .kdd-hq-photo .cap {
    position: absolute;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(15, 23, 42, .55);
    color: #fff;
    font-size: 12.5px;
    padding: 10px 14px;
    display: flex;
    align-items: center;
    gap: 6px;
  }

  .kdd-row-2 {
    display: grid;
    grid-template-columns: 1fr 1.2fr;
    gap: 24px;
    margin-bottom: 24px;
  }

  .kdd-jangka {
    background: var(--navy);
    border-radius: var(--radius);
    padding: 30px;
    color: #fff;
  }

  .kdd-jangka .ic {
    width: 38px;
    height: 38px;
    border-radius: 10px;
    background: rgba(255, 255, 255, .15);
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 16px;
    font-size: 17px;
  }

  .kdd-jangka h4 {
    font-size: 18px;
    font-weight: 800;
    margin-bottom: 10px;
  }

  .kdd-jangka p {
    font-size: 14px;
    color: #c7d3ef;
    line-height: 1.7;
  }

  .kdd-kas-card {
    background: #fff;
    border: 1px solid var(--border);
    border-radius: var(--radius);
    padding: 28px;
  }

  .kdd-kas-card h3 {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 17px;
    color: var(--navy);
    margin-bottom: 16px;
  }

  .kdd-kas-item {
    display: flex;
    gap: 14px;
    padding: 12px 0;
    border-bottom: 1px solid var(--border);
  }

  .kdd-kas-item:last-of-type {
    border-bottom: none;
  }

  .kdd-kas-num {
    width: 30px;
    height: 30px;
    flex: none;
    border-radius: 8px;
    background: var(--bg-soft);
    color: var(--navy);
    font-weight: 800;
    font-size: 12.5px;
    display: flex;
    align-items: center;
    justify-content: center;
  }

  .kdd-kas-item h5 {
    font-size: 14.5px;
    color: var(--navy);
    margin-bottom: 3px;
  }

  .kdd-kas-item p {
    font-size: 13px;
    color: var(--text-muted);
    line-height: 1.5;
  }

  .kdd-kas-more {
    margin-top: 16px;
    width: 100%;
    justify-content: center;
  }

  .kdd-map {
    background: var(--bg-soft);
    border-radius: var(--radius);
    position: relative;
    min-height: 320px;
    overflow: hidden;
  }

  .kdd-map-card {
    position: absolute;
    top: 20px;
    left: 20px;
    background: #fff;
    border-radius: 10px;
    padding: 14px 18px;
    box-shadow: var(--shadow);
    z-index: 2;
  }

  .kdd-map-card strong {
    display: block;
    font-size: 14px;
    color: var(--navy);
    margin-bottom: 2px;
  }

  .kdd-map-card span {
    font-size: 12.5px;
    color: var(--text-muted);
  }

  .kdd-map-pin {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 44px;
    height: 44px;
    border-radius: 10px;
    background: #fff;
    box-shadow: var(--shadow);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    color: #dc2626;
    z-index: 2;
  }

  .kdd-map-zoom {
    position: absolute;
    right: 20px;
    bottom: 20px;
    display: flex;
    gap: 8px;
    z-index: 2;
  }

  .kdd-map-zoom button {
    width: 36px;
    height: 36px;
    border-radius: 8px;
    border: 1px solid var(--border);
    background: #fff;
    cursor: pointer;
    font-size: 14px;
    color: var(--navy);
  }

  .kdd-map a.kdd-map-link {
    position: absolute;
    inset: 0;
    z-index: 1;
  }

  @media(max-width:900px) {

    .kdd-hq-body,
    .kdd-row-2 {
      grid-template-columns: 1fr;
    }

    .kdd-hq-photo {
      min-height: 200px;
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

<section class="kdd-section">
  <div class="container profil-wrap">

    <aside class="profil-sidebar">
      <h4>Profil</h4>
      <ul class="profil-side-menu">
        <li><a href="{{ route('public.profil.index') }}#pendirian">🕘 Pendirian Perusahaan</a></li>
        <li><a href="{{ route('public.profil.tempat-kedudukan') }}" class="active">📍 Tempat Kedudukan</a></li>
        <li><a href="{{ route('public.profil.maksud-tujuan') }}">📋 Maksud dan Tujuan Serta Kegiatan Usaha</a></li>
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

      <div class="kdd-breadcrumb">
        <a href="{{ route('home') }}">Beranda</a> &nbsp;›&nbsp;
        <a href="{{ route('public.profil.index') }}">Profil</a> &nbsp;›&nbsp;
        <strong>Tempat Kedudukan</strong>
      </div>

      <div class="kdd-title-row">
        <h1>Tempat Kedudukan</h1>
      </div>

      <div class="kdd-hq-card">
        <div class="kdd-hq-top">
          <div class="kdd-hq-ic">🏢</div>
          <div>
            <h3>Kantor Pusat</h3>
            <span>PT BPR Waway Lampung (Perseroda)</span>
          </div>
        </div>
        <div class="kdd-hq-body">
          <div>
            <div class="kdd-hq-label">Alamat Utama</div>
            <div class="kdd-hq-address">
              Jl. Diponegoro No. 28 Kelurahan Gulak Galik, Kecamatan Teluk Betung Utara, Kota Bandar Lampung.
            </div>
            <div class="kdd-hq-contact"><span class="ic">📞</span> (0721) 266869</div>
            <div class="kdd-hq-contact"><span class="ic">🖨️</span> (0721) 266389</div>
          </div>
          <div class="kdd-hq-photo">
            <div class="cap">📷 Gedung Kantor Pusat</div>
          </div>
        </div>
      </div>

      <div class="kdd-row-2">
        <div class="kdd-jangka">
          <div class="ic">🕘</div>
          <h4>Jangka Waktu Pendirian</h4>
          <p>PT BPR Waway Lampung (Perseroda) didirikan untuk jangka waktu yang tidak terbatas, berkomitmen untuk
            melayani masyarakat Lampung selamanya.</p>
        </div>

        <div class="kdd-kas-card">
          <h3>🗂️ Kantor Kas</h3>
          <div class="kdd-kas-item">
            <div class="kdd-kas-num">01</div>
            <div>
              <h5><a href="https://maps.app.goo.gl/dQW3kQaD8J58neFM8">Kantor Kas Pasar Bawah</a></h5>
              <p>Jl. Raden Intan Blok A No. 6 Pasar Bawah - Bandar Lampung</p>
            </div>
          </div>
          <div class="kdd-kas-item">
            <div class="kdd-kas-num">02</div>
            <div>
              <h5><a href="https://maps.app.goo.gl/BCzeP6UnJQrwMYGd9">Kantor Kas Mall Pelayanan Publik</a></h5>
              <p>Jl. Dr. Susilo No. 2 Teluk Betung, Gedung Layanan Satu Atap</p>
            </div>
          </div>
          <div class="kdd-kas-item">
            <div class="kdd-kas-num">03</div>
            <div>
              <h5><a href="https://maps.app.goo.gl/FktzdtCuYN1gymz76">Kantor Kas Pesawaran</a></h5>
              <p>Jl. Ahmad Yani Gedong Tataan Pesawaran</p>
            </div>
          </div>
        </div>
      </div>

      <div class="kdd-map">
        <div class="kdd-map-card">
          <strong>Lokasi Kami</strong>
          <span>Klik untuk melihat navigasi di Google Maps</span>
        </div>
        <div class="kdd-map-pin">📍</div>
        <div class="kdd-map-zoom">
          <button type="button" aria-label="Perbesar">🔍+</button>
          <button type="button" aria-label="Perkecil">🔍-</button>
        </div>
        <a class="kdd-map-link" href="https://maps.app.goo.gl/XXQFDXPrbKguNWnZ9?g_st=aw" target="_blank"
          rel="noopener" aria-label="Buka lokasi di Google Maps"></a>
      </div>

    </div>
  </div>
</section>

@endsection
