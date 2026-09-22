@extends('layouts.public')

@section('title', 'Bank Waway Lampung - Kredit PPPK')

@section('styles')
<style>
  .tab-panel {
    display: none;
  }

  .tab-panel.active {
    display: flex;
    flex-direction: column;
    gap: 20px;
  }

  /* ====== Tampilan Sidebar Produk ====== */
  .tab-product-list {
    list-style: none;
    padding: 0;
    margin: 0;
    display: flex;
    flex-direction: column;
    gap: 10px;
  }

  /* Unified button styles for menu items and Form Dana Ceria */
  .tab-product-item,
  .tab-formdana-btn {
    display: grid;
    grid-template-columns: 32px 1fr;
    /* Fixed icon column width for perfect alignment */
    align-items: center;
    width: 100%;
    background: #ffffff;
    color: var(--navy, #1e3a8a);
    font-size: 14px;
    font-weight: 700;
    border: 1px solid var(--border, #e2e8f0);
    border-radius: 10px;
    padding: 14px 18px;
    text-decoration: none;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.02);
    transition: all 0.25s ease;
    cursor: pointer;
    box-sizing: border-box;
    text-align: left;
    line-height: 1.35;
  }

  .tab-product-item .ic,
  .tab-formdana-btn .ic {
    font-size: 18px;
    display: flex;
    align-items: center;
    justify-content: flex-start;
  }

  .tab-product-item:hover,
  .tab-formdana-btn:hover {
    border-color: #2563eb;
    box-shadow: 0 4px 12px rgba(37, 99, 235, 0.08);
    transform: translateY(-1px);
  }

  .tab-product-item.active {
    background: #2563eb;
    color: #ffffff;
    border-color: #2563eb;
    box-shadow: 0 4px 12px rgba(37, 99, 235, 0.25);
  }

  /* ====== Custom Form  Button ====== */
  .tab-formdana-btn {
    grid-template-columns: 32px 1fr auto;
    /* Includes right action arrow */
    margin: 10px 0 20px;
    background: #ffffff;
    color: var(--navy, #1e3a8a);
  }

  .tab-formdana-btn .arrow-ic {
    font-size: 14px;
    color: #2563eb;
    transition: transform 0.2s ease;
  }

  .tab-formdana-btn:hover .arrow-ic {
    transform: translateX(3px);
  }

  /* ====== Header detail panel ====== */
  .kp-detail-top {
    display: flex;
    align-items: flex-start;
    gap: 14px;
    margin-bottom: 16px;
  }

  .kp-detail-ic {
    width: 42px;
    height: 42px;
    border-radius: 10px;
    background: var(--navy, #1e3a8a);
    color: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
    flex: none;
  }

  .kp-detail-top h2 {
    font-size: 19px;
    font-weight: 800;
    color: var(--navy, #1e3a8a);
    line-height: 1.3;
    margin: 0;
  }

  .kp-detail-label {
    font-size: 11px;
    font-weight: 800;
    letter-spacing: .5px;
    color: var(--blue, #2563eb);
    margin-top: 4px;
  }

  /* ====== Informasi Kredit ====== */
  .kp-info-card {
    background: #fff;
    border: 1px solid var(--border, #e2e8f0);
    border-radius: 12px;
    overflow: hidden;
  }

  .kp-info-head {
    display: flex;
    align-items: center;
    justify-content: space-between;
    background: var(--navy, #1e3a8a);
    color: #fff;
    font-size: 15px;
    font-weight: 800;
    padding: 16px 24px;
  }

  .kp-info-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 0;
  }

  .kp-info-cell {
    padding: 20px 24px;
    border-top: 1px solid var(--border, #e2e8f0);
  }

  .kp-info-grid .kp-info-cell:nth-child(-n+3) {
    border-top: none;
  }

  .kp-info-cell:not(:nth-child(3n)) {
    border-right: 1px solid var(--border, #e2e8f0);
  }

  .kp-info-lbl {
    font-size: 10.5px;
    font-weight: 800;
    letter-spacing: .5px;
    text-transform: uppercase;
    color: #64748b;
    margin-bottom: 6px;
  }

  .kp-info-val {
    font-size: 15px;
    font-weight: 800;
    color: var(--navy, #1e3a8a);
  }

  .kp-info-val .unit {
    font-size: 11px;
    font-weight: 600;
    color: #64748b;
    text-transform: none;
  }

  /* ====== Kriteria & Dokumen ====== */
  .kp-bottom-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
  }

  .kp-info-panel {
    background: #fff;
    border: 1px solid var(--border, #e2e8f0);
    border-radius: 12px;
    padding: 24px;
  }

  .kp-info-panel .kp-panel-head {
    display: flex;
    align-items: center;
    gap: 9px;
    font-size: 15.5px;
    font-weight: 800;
    color: var(--navy, #1e3a8a);
    margin-bottom: 18px;
  }

  .kp-terms-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 12px 16px;
  }

  .kp-terms-item {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 13px;
    color: #334155;
  }

  .kp-terms-item .li-ic {
    font-size: 14px;
    flex: none;
  }

  @media(max-width: 900px) {
    .kp-info-grid {
      grid-template-columns: 1fr 1fr;
    }

    .kp-info-cell:not(:nth-child(3n)) {
      border-right: none;
    }

    .kp-info-cell:nth-child(odd) {
      border-right: 1px solid var(--border, #e2e8f0);
    }

    .kp-bottom-grid,
    .kp-terms-grid {
      grid-template-columns: 1fr;
    }
  }
</style>
@endsection

@section('content')
<div class="breadcrumb-row">
  <div class="container">
    <a href="{{ route('home') }}">Beranda</a> <span class="sep">›</span>
    <a href="{{ route('public.kredit.pinjaman') }}">Produk</a> <span class="sep">›</span>
    <a href="{{ route('public.kredit.pinjaman') }}">Pinjaman</a> <span class="sep">›</span>
    <strong>Kredit PPPK</strong>
  </div>
</div>

<section class="hero">
  <img class="hero-bg" src="{{ asset('frontend/images/kredit-pppk.jpg') }}" alt="Kredit PPPK">
  <div class="container">
    <h1>Kredit PPPK</h1>
    <p>Solusi pembiayaan fleksibel yang dirancang khusus bagi Pegawai Pemerintah dengan Perjanjian Kerja (PPPK)
      untuk memenuhi berbagai kebutuhan finansial keluarga Anda secara aman dan terpercaya.</p>
    <div class="hero-actions">
      <a href="https://api.whatsapp.com/send/?phone=6285382659996&text&type=phone_number&app_absent=0"
        target="_blank" rel="noopener" class="btn btn-primary">Ajukan Sekarang →</a>
    </div>
  </div>
</section>

<section class="tab-section" id="detail">
  <div class="container tab-wrap">

    <aside class="tab-sidebar">
      <h4>Produk Kami</h4>
      <p class="tab-sidebar-sub">Solusi Perbankan Terpercaya</p>

      <ul class="tab-product-list">
        <li>
          <a href="{{ route('public.kredit.kredit-konsumer') }}" class="tab-product-item">
            <span class="ic">💳</span>
            <span>Kredit Pegawai <br>(PNS/BUMD)</span>
          </a>
        </li>
        <li>
          <a href="{{ route('public.kredit.kredit-pppk') }}" class="tab-product-item active">
            <span class="ic">📇</span>
            <span>Kredit PPPK</span>
          </a>
        </li>
        <li>
          <a href="{{ route('public.kredit.kredit-pppk-paruh-waktu') }}" class="tab-product-item">
            <span class="ic">⏱</span>
            <span>Kredit PPPK Paruh Waktu</span>
          </a>
        </li>
        <li>
          <a href="{{ route('public.kredit.kredit-tukin') }}" class="tab-product-item">
            <span class="ic">💎</span>
            <span>Kredit Tukin</span>
          </a>
        </li>
        <li>
          <a href="{{ route('public.kredit.kredit-b2b') }}" class="tab-product-item">
            <span class="ic">🔗</span>
            <span>Kredit B2B</span>
          </a>
        </li>
        <li>
          <a href="{{ route('public.kredit.kredit-prapensiun') }}" class="tab-product-item">
            <span class="ic">⏳</span>
            <span>Kredit Prapensiun</span>
          </a>
        </li>
        <li>
          <a href="{{ route('public.kredit.kredit-pensiun') }}" class="tab-product-item">
            <span class="ic">🧓</span>
            <span>Kredit Pensiun</span>
          </a>
        </li>
      </ul>

      <a href="https://script.google.com/macros/s/AKfycbzCoxyMx3HMzXGYa3f9OGP2os-UNWfQoYgg3G1Ef1U8hhgvFbMvyybEvZAUQfZ2xBYW/exec"
        class="tab-formdana-btn">
        <span class="ic">📝</span>
        <span>Form Dana Ceria</span>
      </a>

      <div class="tab-help-card">
        <h5>🎧 Butuh Bantuan?</h5>
        <p>Tim spesialis kami siap membantu menjelaskan produk yang tepat untuk Anda.</p>
        <a href="https://api.whatsapp.com/send/?phone=6285382659996&text&type=phone_number&app_absent=0"
          target="_blank" rel="noopener" class="btn-tel">Hubungi Kami</a>
      </div>
    </aside>

    <div class="tab-content">

      <div class="tab-panel active" id="panel-pppk">

        <div class="tab-detail-card">
          <div class="kp-detail-top">
            <div class="kp-detail-ic">📇</div>
            <div>
              <h2>KREDIT PPPK (Pegawai Pemerintah dengan Perjanjian Kerja)</h2>
              <div class="kp-detail-label">DESKRIPSI PRODUK</div>
            </div>
          </div>
          <p>Fasilitas pembiayaan konsumtif yang dikhususkan bagi ASN PPPK dengan persyaratan yang
            disesuaikan dengan masa kontrak kerja. Memberikan kemudahan akses dana cepat dengan suku
            bunga yang bersaing dan cicilan yang terjangkau.</p>
        </div>

        <div class="kp-info-card">
          <div class="kp-info-head">Informasi Kredit <span>ⓘ</span></div>
          <div class="kp-info-grid">
            <div class="kp-info-cell">
              <div class="kp-info-lbl">Tujuan Kredit</div>
              <div class="kp-info-val">Konsumtif</div>
            </div>
            <div class="kp-info-cell">
              <div class="kp-info-lbl">Plafond Pinjaman</div>
              <div class="kp-info-val">5jt - 200jt</div>
            </div>
            <div class="kp-info-cell">
              <div class="kp-info-lbl">Jangka Waktu</div>
              <div class="kp-info-val">12 - 60 Bulan</div>
            </div>
            <div class="kp-info-cell">
              <div class="kp-info-lbl">Jenis Agunan</div>
              <div class="kp-info-val">SK PPPK</div>
            </div>
            <div class="kp-info-cell">
              <div class="kp-info-lbl">Suku Bunga</div>
              <div class="kp-info-val">8.00% - 9.50% <span class="unit">Flat</span></div>
            </div>
            <div class="kp-info-cell">
              <div class="kp-info-lbl">Asuransi</div>
              <div class="kp-info-val">Jiwa & Kredit</div>
            </div>
          </div>
        </div>

        <div class="kp-bottom-grid">
          <div class="kp-info-panel">
            <div class="kp-panel-head">🧑‍💼 Kriteria Debitur</div>
            <ul class="tp-check-list">
              <li><span class="li-ic">✔️</span> Telah diangkat dan memiliki SK PPPK yang sah.</li>
              <li><span class="li-ic">✔️</span> Masa perjanjian kerja masih berlaku selama jangka
                waktu kredit.</li>
              <li><span class="li-ic">✔️</span> Pembayaran gaji (Payroll) dilakukan melalui Bank Waway
                Lampung.</li>
              <li><span class="li-ic">✔️</span> Rekomendasi dari atasan langsung / instansi terkait.
              </li>
            </ul>
          </div>

          <div class="kp-info-panel">
            <div class="kp-panel-head">📋 Dokumen Persyaratan</div>
            <div class="kp-terms-grid">
              <div class="kp-terms-item"><span class="li-ic">🪪</span><span>E-KTP & KK</span>
              </div>
              <div class="kp-terms-item"><span class="li-ic">📃</span><span>NPWP Pribadi</span></div>
              <div class="kp-terms-item"><span class="li-ic">📄</span><span>Rekening Koran</span>
              </div>
              <div class="kp-terms-item"><span class="li-ic">📃</span><span>SK PPPK Asli</span></div>
              <div class="kp-terms-item"><span class="li-ic">🖼</span><span>Pas Foto Terbaru</span>
              </div>
              <div class="kp-terms-item"><span class="li-ic">💳</span><span>Slip Gaji Terakhir</span>
              </div>
              <div class="kp-terms-item"><span class="li-ic">📝</span><span>Surat Kuasa Potong
                Gaji</span></div>
              <div class="kp-terms-item"><span class="li-ic">📑</span><span>Perjanjian Kerja
                PPPK</span></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection
