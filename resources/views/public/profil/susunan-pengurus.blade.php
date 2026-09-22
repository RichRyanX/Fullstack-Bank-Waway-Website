@extends('layouts.public')

@section('title', 'Bank Waway Lampung - Susunan Pengurus')

@section('styles')
<style>
  .sp-section {
    padding: 60px 0 90px;
  }

  .sp-breadcrumb {
    font-size: 13px;
    color: var(--text-muted);
    margin-bottom: 14px;
  }

  .sp-breadcrumb a {
    color: var(--text-muted);
  }

  .sp-breadcrumb a:hover {
    color: var(--blue);
  }

  .sp-breadcrumb strong {
    color: var(--navy);
  }

  .sp-title-row {
    margin-bottom: 16px;
  }

  .sp-title-row h1 {
    font-size: 32px;
    font-weight: 800;
    color: var(--navy);
    letter-spacing: -.5px;
    position: relative;
    padding-bottom: 14px;
    display: inline-block;
  }

  .sp-title-row h1::after {
    content: "";
    position: absolute;
    left: 0;
    bottom: 0;
    width: 56px;
    height: 4px;
    background: var(--blue);
    border-radius: 2px;
  }

  .sp-intro {
    font-size: 15px;
    color: var(--text-muted);
    line-height: 1.8;
    margin-bottom: 36px;
    max-width: 720px;
  }

  .sp-doc-card {
    background: #fff;
    border: 1px solid var(--border);
    border-radius: var(--radius);
    padding: 34px 40px;
    margin-bottom: 40px;
  }

  .sp-doc-title {
    text-align: center;
    font-size: 20px;
    font-weight: 800;
    letter-spacing: .4px;
    color: var(--navy);
    margin-bottom: 22px;
  }

  .sp-doc-card p {
    font-size: 14.5px;
    color: var(--text);
    line-height: 1.85;
    margin-bottom: 18px;
  }

  .sp-doc-sub {
    font-size: 15.5px;
    font-weight: 800;
    color: var(--blue);
    margin-bottom: 10px;
  }

  .sp-doc-list {
    list-style: disc;
    padding-left: 22px;
    margin-bottom: 20px;
  }

  .sp-doc-list li {
    font-size: 14.5px;
    color: var(--text);
    line-height: 1.85;
    margin-bottom: 6px;
  }

  .sp-org-banner {
    background: var(--navy);
    border-radius: var(--radius);
    padding: 44px;
    color: #fff;
    position: relative;
    overflow: hidden;
  }

  .sp-org-deco {
    position: absolute;
    right: -30px;
    top: -30px;
    width: 260px;
    height: 260px;
    opacity: .15;
    pointer-events: none;
  }

  .sp-org-banner .inner {
    position: relative;
    z-index: 2;
  }

  .sp-org-banner h3 {
    font-size: 22px;
    font-weight: 800;
    margin-bottom: 12px;
  }

  .sp-org-banner p {
    font-size: 14.5px;
    color: #c7d3ef;
    line-height: 1.7;
    max-width: 600px;
    margin-bottom: 24px;
  }

  .sp-org-banner .btn-white {
    background: #fff;
    color: var(--navy);
  }

  @media(max-width:900px) {
    .sp-doc-card {
      padding: 26px 22px;
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

<section class="sp-section">
  <div class="container profil-wrap">

    <aside class="profil-sidebar">
      <h4>Profil</h4>
      <ul class="profil-side-menu">
        <li><a href="{{ route('public.profil.index') }}#pendirian">🕘 Pendirian Perusahaan</a></li>
        <li><a href="{{ route('public.profil.tempat-kedudukan') }}">📍 Tempat Kedudukan</a></li>
        <li><a href="{{ route('public.profil.maksud-tujuan') }}">📋 Maksud dan Tujuan Serta Kegiatan Usaha</a></li>
        <li><a href="{{ route('public.profil.perijinan-legalitas') }}">✅ Perijinan dan Legalitas Usaha</a></li>
        <li><a href="{{ route('public.layanan.modal') }}">💳 Modal</a></li>
        <li><a href="{{ route('public.profil.susunan-pengurus') }}" class="active">👥 Susunan Pengurus</a></li>
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

      <div class="sp-breadcrumb">
        <a href="{{ route('home') }}">Beranda</a> &nbsp;›&nbsp;
        <a href="{{ route('public.profil.index') }}">Profil</a> &nbsp;›&nbsp;
        <strong>Susunan Pengurus</strong>
      </div>

      <div class="sp-title-row">
        <h1>Susunan Pengurus</h1>
      </div>

      <p class="sp-intro">Dipimpin oleh para profesional berpengalaman yang berkomitmen untuk memajukan
        stabilitas keuangan dan pertumbuhan ekonomi Lampung.</p>

      <div class="sp-doc-card">
        <h2 class="sp-doc-title">SUSUNAN PENGURUS</h2>

        <p>PT BPR WAWAY LAMPUNG (Perseroda) saat ini dipimpin oleh Direksi yang terdiri dari 1 (satu) orang
          Direktur Utama dan 1 (satu) orang Direktur yaitu Direktur Operasional. Direksi bertanggung jawab
          kepada Rapat Umum Pemegang Saham (RUPS).</p>

        <p>Susunan Dewan Komisaris PT BPR WAWAY LAMPUNG (Perseroda) sesuai dengan Surat Keputusan Walikota
          Bandar Lampung No. 129/BPR/HK/2019 tanggal 30 Januari 2019 tentang Pengangkatan Dewan Komisaris dan
          Direksi PT BPR WAWAY LAMPUNG (Perseroda) adalah sebagai berikut :</p>

        <h3 class="sp-doc-sub">Dewan Komisaris</h3>
        <ul class="sp-doc-list">
          <li>Komisaris Utama: Robi Suliska Sobri, S.IP., M.IP., QCRO (Masa Jabatan 16-07-2024 s.d 15-07-2028)
          </li>
          <li>Komisaris: Yusdiyanto, S.H., M.H. (Masa Jabatan 31-03-2026 s.d 30-03-2030)</li>
        </ul>

        <p>Susunan Direksi PT BPR WAWAY LAMPUNG (Perseroda) sesuai dengan Surat Keputusan Walikota Bandar
          Lampung No. 287/PT BPR WAWAY/HK/2024 tanggal 18 Januari 2024 tentang Pengangkatan Direktur Utama PT
          BPR WAWAY LAMPUNG (Perseroda) dan Surat Keputusan Walikota Bandar Lampung No. 288/PT BPR WAWAY/HK/2024
          tanggal 18 Januari 2024 tentang Pengangkatan Direktur Operasional PT BPR Waway Lampung (Perseroda).
        </p>

        <h3 class="sp-doc-sub">Direksi</h3>
        <ul class="sp-doc-list">
          <li>Direktur Utama: Harris Surahya (Masa Jabatan 26-01-2026 s.d 26-01-2031)</li>
          <li>Direktur Operasional: Anang Sofi (Masa Jabatan 18-01-2024 s.d 18-01-2029)</li>
        </ul>
      </div>

      <div class="sp-org-banner">
        <svg class="sp-org-deco" viewBox="0 0 260 260" xmlns="http://www.w3.org/2000/svg">
          <circle cx="190" cy="70" r="46" fill="none" stroke="#fff" stroke-width="6" />
          <circle cx="190" cy="70" r="10" fill="#fff" />
          <circle cx="110" cy="130" r="26" fill="none" stroke="#fff" stroke-width="5" />
          <circle cx="110" cy="130" r="6" fill="#fff" />
          <circle cx="230" cy="160" r="16" fill="none" stroke="#fff" stroke-width="4" />
          <line x1="190" y1="70" x2="110" y2="130" stroke="#fff" stroke-width="4" />
          <line x1="110" y1="130" x2="230" y2="160" stroke="#fff" stroke-width="4" />
        </svg>
        <div class="inner">
          <h3>Struktur Organisasi</h3>
          <p>Lihat bagaimana Bank Waway Lampung terorganisir untuk memberikan pelayanan perbankan terbaik bagi
            masyarakat Lampung secara menyeluruh dan transparan.</p>
          <a href="{{ route('public.profil.index') }}" class="btn btn-white">⬇ Unduh Bagan Organisasi (.PDF)</a>
        </div>
      </div>

    </div>
  </div>
</section>

@endsection
