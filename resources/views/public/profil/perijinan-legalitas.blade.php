@extends('layouts.public')

@section('title', 'Bank Waway Lampung - Perijinan dan Legalitas Usaha')

@section('styles')
<style>
  .prz-section {
    padding: 60px 0 90px;
  }

  .prz-breadcrumb {
    font-size: 13px;
    color: var(--text-muted);
    margin-bottom: 14px;
  }

  .prz-breadcrumb a {
    color: var(--text-muted);
  }

  .prz-breadcrumb a:hover {
    color: var(--blue);
  }

  .prz-breadcrumb strong {
    color: var(--navy);
  }

  .prz-title-row {
    margin-bottom: 28px;
  }

  .prz-title-row h1 {
    font-size: 32px;
    font-weight: 800;
    color: var(--navy);
    letter-spacing: -.5px;
    position: relative;
    padding-bottom: 14px;
    display: inline-block;
  }

  .prz-title-row h1::after {
    content: "";
    position: absolute;
    left: 0;
    bottom: 0;
    width: 56px;
    height: 4px;
    background: var(--blue);
    border-radius: 2px;
  }

  .prz-grid {
    display: grid;
    grid-template-columns: 1fr 1.6fr;
    gap: 24px;
    margin-bottom: 24px;
    align-items: start;
  }

  .prz-trust-card {
    background: var(--bg-soft);
    border-radius: var(--radius);
    overflow: hidden;
    display: flex;
    flex-direction: column;
  }

  .prz-trust-top {
    padding: 28px;
    flex: 1;
  }

  .prz-trust-ic {
    width: 44px;
    height: 44px;
    border-radius: 12px;
    background: #fff;
    color: var(--blue);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 19px;
    margin-bottom: 16px;
    box-shadow: var(--shadow);
  }

  .prz-trust-top h4 {
    font-size: 18px;
    color: var(--navy);
    font-weight: 800;
    margin-bottom: 12px;
  }

  .prz-trust-top p {
    font-size: 13.5px;
    color: var(--text-muted);
    line-height: 1.7;
  }

  .prz-trust-bottom {
    background: var(--navy);
    height: 140px;
  }

  .prz-list {
    display: flex;
    flex-direction: column;
    gap: 16px;
  }

  .prz-item {
    background: #fff;
    border: 1px solid var(--border);
    border-radius: 12px;
    padding: 20px 22px;
    display: flex;
    gap: 16px;
    align-items: flex-start;
  }

  .prz-item .ic {
    width: 36px;
    height: 36px;
    border-radius: 9px;
    background: var(--blue);
    color: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 15px;
    flex: none;
    margin: 0;
    align-self: flex-start;
  }

  .prz-item .lbl {
    font-size: 11px;
    font-weight: 700;
    letter-spacing: .6px;
    text-transform: uppercase;
    color: var(--text-muted);
    margin-bottom: 6px;
  }

  .prz-item h5 {
    font-size: 16px;
    color: var(--navy);
    font-weight: 700;
    line-height: 1.4;
  }

  .prz-item .note {
    font-size: 13px;
    color: var(--text-muted);
    font-style: italic;
    margin-top: 4px;
  }

  .prz-reg-card {
    background: #fff;
    border: 1px solid var(--border);
    border-radius: var(--radius);
    padding: 32px;
  }

  .prz-reg-card h3 {
    font-size: 19px;
    color: var(--navy);
    font-weight: 800;
    margin-bottom: 16px;
  }

  .prz-reg-card p {
    font-size: 14.5px;
    color: var(--text-muted);
    line-height: 1.75;
    margin-bottom: 14px;
  }

  .prz-badges {
    display: flex;
    gap: 28px;
    margin-top: 20px;
    flex-wrap: wrap;
  }

  .prz-badge {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 14px;
    font-weight: 700;
    color: var(--navy);
  }

  .prz-badge .ic {
    font-size: 18px;
  }

  @media(max-width:900px) {
    .prz-grid {
      grid-template-columns: 1fr;
    }

    .prz-trust-bottom {
      display: none;
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

<section class="prz-section">
  <div class="container profil-wrap">

    <aside class="profil-sidebar">
      <h4>Profil</h4>
      <ul class="profil-side-menu">
        <li><a href="{{ route('public.profil.index') }}#pendirian">🕘 Pendirian Perusahaan</a></li>
        <li><a href="{{ route('public.profil.tempat-kedudukan') }}">📍 Tempat Kedudukan</a></li>
        <li><a href="{{ route('public.profil.maksud-tujuan') }}">📋 Maksud dan Tujuan Serta Kegiatan Usaha</a></li>
        <li><a href="{{ route('public.profil.perijinan-legalitas') }}" class="active">✅ Perijinan dan Legalitas Usaha</a></li>
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

      <div class="prz-breadcrumb">
        <a href="{{ route('home') }}">Beranda</a> &nbsp;›&nbsp;
        <a href="{{ route('public.profil.index') }}">Profil</a> &nbsp;›&nbsp;
        <strong>Perijinan & Legalitas</strong>
      </div>

      <div class="prz-title-row">
        <h1>Perijinan serta Legalitas Usaha</h1>
      </div>

      <div class="prz-grid">
        <div class="prz-trust-card">
          <div class="prz-trust-top">
            <div class="prz-trust-ic">🛡️</div>
            <h4>Kepercayaan & Legalitas</h4>
            <p>Sebagai lembaga perbankan yang berintegritas, Bank Waway Lampung senantiasa patuh pada regulasi yang
              ditetapkan oleh otoritas moneter dan pemerintah Republik Indonesia.</p>
          </div>
          <div class="prz-trust-bottom"></div>
        </div>

        <div class="prz-list">
          <div class="prz-item">
            <div class="ic">✅</div>
            <div>
              <div class="lbl">Akta Pendirian</div>
              <h5>Akta Pendirian No. 5 tanggal 22 Februari 2019</h5>
              <div class="note">Notaris: Syarifuddin, SH.</div>
            </div>
          </div>
          <div class="prz-item">
            <div class="ic">✅</div>
            <div>
              <div class="lbl">Pengesahan Kemenkumham</div>
              <h5>Keputusan Menkumham RI No: AHU-011065.AH.01.01.Tahun 2019</h5>
            </div>
          </div>
          <div class="prz-item">
            <div class="ic">✅</div>
            <div>
              <div class="lbl">Izin Usaha OJK</div>
              <h5>Keputusan Kepala OJK Provinsi Lampung No KEP-34/KO.074/2019</h5>
            </div>
          </div>
          <div class="prz-item">
            <div class="ic">✅</div>
            <div>
              <div class="lbl">Nomor Pokok Wajib Pajak</div>
              <h5>NPWP: 90.698.082.6.324.000</h5>
            </div>
          </div>
        </div>
      </div>

      <div class="prz-reg-card">
        <h3>Regulasi & Kepatuhan</h3>
        <p>Bank Waway Lampung berkomitmen untuk menjalankan tata kelola perusahaan yang baik (Good Corporate
          Governance) sesuai dengan standar industri perbankan nasional.</p>
        <p>Seluruh aktivitas operasional kami diawasi secara ketat oleh Otoritas Jasa Keuangan (OJK) dan kami
          merupakan peserta penjaminan Lembaga Penjamin Simpanan (LPS).</p>
        <div class="prz-badges">
          <div class="prz-badge"><span class="ic">🛡️</span> Terdaftar & Diawasi OJK</div>
          <div class="prz-badge"><span class="ic">🏦</span> Peserta LPS</div>
        </div>
      </div>

    </div>
  </div>
</section>

@endsection
