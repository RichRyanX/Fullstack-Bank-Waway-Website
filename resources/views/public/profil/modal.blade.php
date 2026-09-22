@extends('layouts.public')

@section('title', 'Bank Waway Lampung - Modal')

@section('styles')
<style>
  .mdl-section {
    padding: 60px 0 90px;
  }

  .mdl-breadcrumb {
    font-size: 13px;
    color: var(--text-muted);
    margin-bottom: 14px;
  }

  .mdl-breadcrumb a {
    color: var(--text-muted);
  }

  .mdl-breadcrumb a:hover {
    color: var(--blue);
  }

  .mdl-breadcrumb strong {
    color: var(--navy);
  }

  .mdl-title-row {
    margin-bottom: 24px;
  }

  .mdl-title-row h1 {
    font-size: 32px;
    font-weight: 800;
    color: var(--navy);
    letter-spacing: -.5px;
    position: relative;
    padding-bottom: 14px;
    display: inline-block;
  }

  .mdl-title-row h1::after {
    content: "";
    position: absolute;
    left: 0;
    bottom: 0;
    width: 56px;
    height: 4px;
    background: var(--blue);
    border-radius: 2px;
  }

  .mdl-intro {
    font-size: 15px;
    color: var(--text);
    line-height: 1.8;
    margin-bottom: 32px;
  }

  .mdl-intro strong {
    color: var(--navy);
  }

  .mdl-grid {
    display: grid;
    grid-template-columns: 1.8fr 1fr;
    gap: 24px;
    margin-bottom: 24px;
    align-items: start;
  }

  .mdl-table-card {
    background: #fff;
    border: 1px solid var(--border);
    border-radius: var(--radius);
    overflow: hidden;
  }

  .mdl-table-head {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 22px 26px;
    border-bottom: 1px solid var(--border);
  }

  .mdl-table-head h3 {
    font-size: 17px;
    color: var(--navy);
    font-weight: 800;
  }

  .mdl-table-head .info {
    color: var(--text-muted);
    font-size: 16px;
  }

  table.mdl-table {
    width: 100%;
    border-collapse: collapse;
  }

  .mdl-table thead th {
    text-align: left;
    font-size: 11px;
    letter-spacing: .5px;
    text-transform: uppercase;
    color: var(--text-muted);
    padding: 14px 26px;
    background: var(--bg-soft);
    font-weight: 700;
  }

  .mdl-table thead th:last-child,
  .mdl-table tbody td:last-child {
    text-align: right;
  }

  .mdl-table tbody td {
    padding: 18px 26px;
    font-size: 14px;
    color: var(--text);
    border-top: 1px solid var(--border);
    vertical-align: top;
  }

  .mdl-table tbody tr.total td {
    background: var(--bg-soft);
    font-weight: 700;
    color: var(--navy);
  }

  .mdl-pct-badge {
    display: inline-block;
    background: var(--navy);
    color: #fff;
    font-size: 12px;
    font-weight: 700;
    padding: 4px 10px;
    border-radius: 999px;
  }

  .mdl-pct-badge.low {
    background: var(--bg-soft);
    color: var(--text-muted);
  }

  .mdl-viz-card {
    background: #fff;
    border: 1px solid var(--border);
    border-radius: var(--radius);
    padding: 26px;
    margin-bottom: 20px;
  }

  .mdl-viz-card h3 {
    font-size: 16px;
    color: var(--navy);
    font-weight: 800;
    margin-bottom: 20px;
  }

  .mdl-donut-wrap {
    display: flex;
    justify-content: center;
    margin-bottom: 20px;
  }

  .mdl-legend {
    display: flex;
    flex-direction: column;
    gap: 10px;
  }

  .mdl-legend-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    font-size: 13.5px;
    color: var(--text);
  }

  .mdl-legend-item .name {
    display: flex;
    align-items: center;
  }

  .mdl-legend-item .dot {
    width: 10px;
    height: 10px;
    border-radius: 50%;
    display: inline-block;
    margin-right: 8px;
  }

  .mdl-legend-item strong {
    color: var(--navy);
  }

  .mdl-status-card {
    background: var(--navy);
    border-radius: var(--radius);
    padding: 26px;
    color: #fff;
  }

  .mdl-status-card h3 {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 16px;
    font-weight: 800;
    margin-bottom: 12px;
  }

  .mdl-status-card p {
    font-size: 13.5px;
    color: #c7d3ef;
    line-height: 1.6;
    margin-bottom: 18px;
  }

  .mdl-car-label {
    font-size: 11px;
    letter-spacing: .5px;
    text-transform: uppercase;
    color: #9fb0d6;
    margin-bottom: 8px;
  }

  .mdl-car-track {
    height: 8px;
    background: rgba(255, 255, 255, .15);
    border-radius: 5px;
    overflow: hidden;
    margin-bottom: 8px;
  }

  .mdl-car-fill {
    height: 100%;
    width: 85%;
    background: #60a5fa;
    border-radius: 5px;
  }

  .mdl-car-pct {
    font-size: 12.5px;
    font-weight: 700;
    text-align: right;
  }

  .mdl-doc-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 20px;
  }

  .mdl-doc-card {
    background: #fff;
    border: 1px solid var(--border);
    border-radius: var(--radius);
    padding: 26px;
  }

  .mdl-doc-card .ic {
    width: 38px;
    height: 38px;
    border-radius: 10px;
    background: var(--bg-soft);
    color: var(--navy);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 17px;
    margin-bottom: 14px;
  }

  .mdl-doc-card h5 {
    font-size: 15.5px;
    color: var(--navy);
    font-weight: 700;
    margin-bottom: 8px;
  }

  .mdl-doc-card p {
    font-size: 13px;
    color: var(--text-muted);
    line-height: 1.6;
  }

  @media(max-width:900px) {
    .mdl-grid,
    .mdl-doc-grid {
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

<section class="mdl-section">
  <div class="container profil-wrap">

    <aside class="profil-sidebar">
      <h4>Profil</h4>
      <ul class="profil-side-menu">
        <li><a href="{{ route('public.profil.index') }}#pendirian">🕘 Pendirian Perusahaan</a></li>
        <li><a href="{{ route('public.profil.tempat-kedudukan') }}">📍 Tempat Kedudukan</a></li>
        <li><a href="{{ route('public.profil.maksud-tujuan') }}">📋 Maksud dan Tujuan Serta Kegiatan Usaha</a></li>
        <li><a href="{{ route('public.profil.perijinan-legalitas') }}">✅ Perijinan dan Legalitas Usaha</a></li>
        <li><a href="{{ route('public.layanan.modal') }}" class="active">💳 Modal</a></li>
        <li><a href="{{ route('public.profil.susunan-pengurus') }}">👥 Susunan Pengurus</a></li>
        <li><a href="{{ route('public.profil.visi-misi') }}">👁️ Visi & Misi</a></li>
        <li><a href="{{ route('public.profil.prestasi-penghargaan') }}">🏆 Prestasi dan Penghargaan</a></li>
        <li><a href="{{ route('public.profil.index') }}#pengurus">👤 Pengurus</a></li>
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

      <div class="mdl-breadcrumb">
        <a href="{{ route('home') }}">Beranda</a> &nbsp;›&nbsp;
        <a href="{{ route('public.profil.index') }}">Profil</a> &nbsp;›&nbsp;
        <strong>Modal</strong>
      </div>

      <div class="mdl-title-row">
        <h1>Modal</h1>
      </div>

      <p class="mdl-intro">
        Sejarah permodalan Bank Waway Lampung mencerminkan stabilitas dan komitmen kuat dari para pemegang saham
        dalam mendukung pertumbuhan ekonomi daerah. Saat ini, Perseroan memiliki <strong>Modal Dasar sebesar Rp
          75.000.000.000 (Tujuh Puluh Lima Miliar Rupiah)</strong>. Dari jumlah tersebut, <strong>Modal Disetor
          telah mencapai Rp 47.040.500.000 (Empat Puluh Tujuh Miliar Empat Puluh Juta Lima Ratus Ribu
          Rupiah)</strong>, yang menunjukkan fundamental keuangan yang kokoh untuk menjalankan operasional
        perbankan yang sehat dan berkelanjutan.
      </p>

      <div class="mdl-grid">
        <div class="mdl-table-card">
          <div class="mdl-table-head">
            <h3>Komposisi Kepemilikan Saham</h3>
            <span class="info">ⓘ</span>
          </div>
          <table class="mdl-table">
            <thead>
              <tr>
                <th>No</th>
                <th>Nama Pemegang Saham</th>
                <th>Jumlah Lembar</th>
                <th>Jumlah Nominal</th>
                <th>%</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>1</td>
                <td>Pemda Kota Bandar Lampung</td>
                <td>94.002</td>
                <td>Rp 47.001.000.000</td>
                <td><span class="mdl-pct-badge">99,92%</span></td>
              </tr>
              <tr>
                <td>2</td>
                <td>Koperasi Jasa Karyawan Artha Sejahtera Bapas</td>
                <td>79</td>
                <td>Rp 39.500.000</td>
                <td><span class="mdl-pct-badge low">0,08%</span></td>
              </tr>
              <tr class="total">
                <td colspan="2">Total Permodalan Disetor</td>
                <td>94.081</td>
                <td>Rp 47.040.500.000</td>
                <td>100%</td>
              </tr>
            </tbody>
          </table>
        </div>

        <div>
          <div class="mdl-viz-card">
            <h3>Visualisasi Kepemilikan</h3>
            <div class="mdl-donut-wrap">
              <svg viewBox="0 0 180 180" width="170" height="170">
                <circle cx="90" cy="90" r="70" fill="none" stroke="#93C5FD" stroke-width="22" />
                <circle cx="90" cy="90" r="70" fill="none" stroke="#1B2A4A" stroke-width="22"
                  stroke-dasharray="439 0.6" stroke-dashoffset="0" transform="rotate(-90 90 90)"
                  stroke-linecap="round" />
                <text x="90" y="86" text-anchor="middle" font-size="22" font-weight="800" fill="#1B2A4A"
                  font-family="Inter, sans-serif">99.92%</text>
                <text x="90" y="106" text-anchor="middle" font-size="11" fill="#64748B"
                  font-family="Inter, sans-serif">Pemda Kota</text>
              </svg>
            </div>
            <div class="mdl-legend">
              <div class="mdl-legend-item">
                <span class="name"><span class="dot" style="background:#1B2A4A"></span> Pemda Kota</span>
                <strong>99.92%</strong>
              </div>
              <div class="mdl-legend-item">
                <span class="name"><span class="dot" style="background:#93C5FD"></span> Koperasi Karyawan</span>
                <strong>0.08%</strong>
              </div>
            </div>
          </div>

          <div class="mdl-status-card">
            <h3>🛡️ Status Permodalan</h3>
            <p>Kesehatan modal inti Bank Waway berada pada level optimal sesuai regulasi OJK.</p>
            <div class="mdl-car-label">Rasio Kecukupan Modal (CAR)</div>
            <div class="mdl-car-track">
              <div class="mdl-car-fill"></div>
            </div>
            <div class="mdl-car-pct">85% Compliance</div>
          </div>
        </div>
      </div>

      <div class="mdl-doc-grid">
        <div class="mdl-doc-card">
          <div class="ic">📋</div>
          <h5>Laporan Tahunan</h5>
          <p>Unduh rincian laporan keuangan tahunan lengkap untuk periode 2023.</p>
        </div>
        <div class="mdl-doc-card">
          <div class="ic">📄</div>
          <h5>Prospektus</h5>
          <p>Informasi lengkap mengenai penambahan modal dan aksi korporasi bank.</p>
        </div>
        <div class="mdl-doc-card">
          <div class="ic">📜</div>
          <h5>Akta Notaris</h5>
          <p>Salinan digital akta pendirian dan perubahan modal yang telah disahkan.</p>
        </div>
      </div>

    </div>
  </div>
</section>

@endsection
