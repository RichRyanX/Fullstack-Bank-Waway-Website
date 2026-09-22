@extends('layouts.public')

@section('title', 'Bank Waway Lampung - Visi & Misi')

@section('styles')
<style>
  .vm-section {
    padding: 60px 0 90px;
  }

  .vm-breadcrumb {
    font-size: 13px;
    color: var(--text-muted);
    margin-bottom: 14px;
  }

  .vm-breadcrumb a {
    color: var(--text-muted);
  }

  .vm-breadcrumb a:hover {
    color: var(--blue);
  }

  .vm-breadcrumb strong {
    color: var(--navy);
  }

  .vm-title-row {
    margin-bottom: 28px;
  }

  .vm-title-row h1 {
    font-size: 32px;
    font-weight: 800;
    color: var(--navy);
    letter-spacing: -.5px;
    position: relative;
    padding-bottom: 14px;
    display: inline-block;
  }

  .vm-title-row h1::after {
    content: "";
    position: absolute;
    left: 0;
    bottom: 0;
    width: 56px;
    height: 4px;
    background: var(--blue);
    border-radius: 2px;
  }

  .vm-visi-card {
    background: var(--bg-soft);
    border-radius: var(--radius);
    padding: 40px;
    position: relative;
    overflow: hidden;
    margin-bottom: 40px;
  }

  .vm-visi-deco {
    position: absolute;
    right: 20px;
    top: 10px;
    width: 220px;
    height: 220px;
    opacity: .5;
    pointer-events: none;
  }

  .vm-visi-label {
    display: flex;
    align-items: center;
    gap: 8px;
    color: var(--blue);
    font-weight: 800;
    font-size: 14px;
    letter-spacing: .5px;
    margin-bottom: 20px;
    position: relative;
    z-index: 2;
  }

  .vm-visi-card blockquote {
    font-size: 19px;
    font-weight: 700;
    font-style: italic;
    color: var(--navy);
    line-height: 1.6;
    max-width: 760px;
    position: relative;
    z-index: 2;
  }

  .vm-misi-label {
    display: flex;
    align-items: center;
    gap: 8px;
    color: var(--blue);
    font-weight: 800;
    font-size: 16px;
    letter-spacing: .5px;
    margin-bottom: 20px;
  }

  .vm-misi-grid-3 {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 20px;
    margin-bottom: 20px;
  }

  .vm-misi-grid-2 {
    display: grid;
    grid-template-columns: 1.3fr 1fr;
    gap: 20px;
    margin-bottom: 40px;
  }

  .vm-misi-item {
    background: #fff;
    border: 1px solid var(--border);
    border-radius: var(--radius);
    padding: 26px;
  }

  .vm-misi-item .ic {
    width: 42px;
    height: 42px;
    border-radius: 10px;
    background: var(--bg-soft);
    color: var(--navy);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
    margin-bottom: 16px;
  }

  .vm-misi-item h5 {
    font-size: 16px;
    color: var(--navy);
    font-weight: 800;
    margin-bottom: 10px;
  }

  .vm-misi-item p {
    font-size: 13.5px;
    color: var(--text-muted);
    line-height: 1.65;
  }

  .vm-misi-item.horizontal {
    display: flex;
    gap: 16px;
    align-items: flex-start;
  }

  .vm-misi-item.horizontal .ic {
    margin-bottom: 0;
    flex: none;
  }

  .vm-misi-item.highlight {
    background: var(--navy);
    border-color: var(--navy);
    color: #fff;
  }

  .vm-misi-item.highlight .ic {
    background: rgba(255, 255, 255, .15);
    color: #fff;
  }

  .vm-misi-item.highlight h5 {
    color: #fff;
  }

  .vm-misi-item.highlight p {
    color: #c7d3ef;
  }

  .vm-banner {
    background: var(--navy);
    border-radius: var(--radius);
    padding: 60px 40px;
    color: #fff;
    text-align: center;
  }

  .vm-banner h3 {
    font-size: 19px;
    font-weight: 800;
    margin-bottom: 14px;
  }

  .vm-banner p {
    font-size: 14px;
    color: #c7d3ef;
    max-width: 600px;
    margin: 0 auto;
    line-height: 1.7;
  }

  @media(max-width:900px) {

    .vm-misi-grid-3,
    .vm-misi-grid-2 {
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

<section class="vm-section">
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
        <li><a href="{{ route('public.profil.visi-misi') }}" class="active">👁️ Visi & Misi</a></li>
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

      <div class="vm-breadcrumb">
        <a href="{{ route('home') }}">Beranda</a> &nbsp;›&nbsp;
        <a href="{{ route('public.profil.index') }}">Profil</a> &nbsp;›&nbsp;
        <strong>Visi & Misi</strong>
      </div>

      <div class="vm-title-row">
        <h1>Visi & Misi</h1>
      </div>

      <div class="vm-visi-card">
        <svg class="vm-visi-deco" viewBox="0 0 220 220" xmlns="http://www.w3.org/2000/svg">
          <path d="M20 110 C 60 40, 160 40, 200 110 C 160 180, 60 180, 20 110 Z" fill="none" stroke="#CBD5E1"
            stroke-width="10" />
          <circle cx="110" cy="110" r="34" fill="none" stroke="#CBD5E1" stroke-width="10" />
        </svg>
        <div class="vm-visi-label">✨ VISI</div>
        <blockquote>"Menjadi Bank milik Pemerintah Daerah yang Sehat, Prima dalam Pelayanan serta berperan dalam
          meningkatkan Perekonomian masyarakat di wilayah Provinsi Lampung."</blockquote>
      </div>

      <div class="vm-misi-label">🚩 MISI</div>

      <div class="vm-misi-grid-3">
        <div class="vm-misi-item">
          <div class="ic">📈</div>
          <h5>Mendorong Pertumbuhan</h5>
          <p>Membantu pertumbuhan ekonomi masyarakat dan pelaku usaha mikro di seluruh wilayah Provinsi Lampung.</p>
        </div>
        <div class="vm-misi-item">
          <div class="ic">⚡</div>
          <h5>Layanan Inovatif</h5>
          <p>Menyediakan layanan perbankan yang inovatif, cepat, dan transparan melalui teknologi mutakhir.</p>
        </div>
        <div class="vm-misi-item">
          <div class="ic">🕸️</div>
          <h5>Kerjasama Strategis</h5>
          <p>Membangun jaringan kerjasama yang kuat dengan berbagai stakeholder untuk kemajuan daerah.</p>
        </div>
      </div>

      <div class="vm-misi-grid-2">
        <div class="vm-misi-item horizontal">
          <div class="ic">👥</div>
          <div>
            <h5>Lingkungan Profesional</h5>
            <p>Menciptakan lingkungan kerja yang profesional, kondusif, dan berorientasi pada pengembangan SDM
              unggul.</p>
          </div>
        </div>
        <div class="vm-misi-item horizontal highlight">
          <div class="ic">🛡️</div>
          <div>
            <h5>Kepercayaan Publik</h5>
            <p>Membangun dan menjaga kepercayaan masyarakat melalui tata kelola perusahaan yang baik dan
              integritas tinggi.</p>
          </div>
        </div>
      </div>

      <div class="vm-banner">
        <h3>Bersama Membangun Lampung</h3>
        <p>Berdedikasi untuk pertumbuhan ekonomi yang inklusif dan berkelanjutan di seluruh penjuru Provinsi
          Lampung.</p>
      </div>

    </div>
  </div>
</section>

@endsection
