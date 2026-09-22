@extends('layouts.public')

@section('title', 'Bank Waway Lampung - Kredit PPPK Paruh Waktu')

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

  .tab-product-item,
  .tab-formdana-btn {
    display: grid;
    grid-template-columns: 32px 1fr;
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

  /* ====== Custom Form Dana Ceria Button ====== */
  .tab-formdana-btn {
    margin: 10px 0 20px;
    background: #ffffff;
    color: var(--navy, #1e3a8a);
  }

  /* ====== Stat Grid ====== */
  .km-stat-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 18px;
    margin: 22px 0 8px;
  }

  .km-stat-card {
    background: #fff;
    border: 1px solid var(--border);
    border-radius: 12px;
    padding: 20px 20px 18px;
  }

  .km-stat-ic {
    width: 34px;
    height: 34px;
    border-radius: 9px;
    background: var(--blue);
    color: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 15px;
    margin-bottom: 18px;
  }

  .km-stat-lbl {
    font-size: 11px;
    font-weight: 700;
    letter-spacing: .4px;
    text-transform: uppercase;
    color: var(--text-muted);
    margin-bottom: 6px;
  }

  .km-stat-val {
    font-size: 17px;
    font-weight: 800;
    color: var(--navy);
    line-height: 1.3;
  }

  .km-grid-bottom {
    display: grid;
    grid-template-columns: 1.6fr 1fr;
    gap: 20px;
    align-items: start;
  }

  .km-left-col {
    display: flex;
    flex-direction: column;
    gap: 20px;
  }

  .km-cta-card {
    background: var(--navy);
    border-radius: var(--radius);
    padding: 30px 26px;
    color: #fff;
    position: sticky;
    top: 96px;
  }

  .km-cta-card h3 {
    font-size: 18px;
    font-weight: 800;
    margin-bottom: 14px;
    line-height: 1.35;
  }

  .km-cta-card p {
    font-size: 13.5px;
    color: #c7d3ef;
    line-height: 1.65;
    margin-bottom: 22px;
  }

  .km-cta-card .btn {
    width: 100%;
    justify-content: center;
    margin-bottom: 12px;
  }

  .km-cta-card .btn-primary {
    background: var(--blue);
    color: #fff;
    border-color: var(--blue);
  }

  .km-cta-card .btn-primary:hover {
    background: #1d4ed8;
  }

  .km-cta-note {
    font-size: 10.5px;
    font-weight: 700;
    letter-spacing: .4px;
    text-transform: uppercase;
    color: #93a4c9;
    margin-bottom: 12px;
  }

  .km-cta-contact {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 13.5px;
    color: #dbe3f5;
    margin-bottom: 10px;
  }

  .km-cta-contact a {
    color: #dbe3f5;
  }

  .km-cta-contact a:hover {
    color: #fff;
    text-decoration: underline;
  }

  @media(max-width: 900px) {
    .km-stat-grid {
      grid-template-columns: 1fr 1fr;
    }

    .km-grid-bottom {
      grid-template-columns: 1fr;
    }

    .km-cta-card {
      position: static;
    }
  }

  @media(max-width: 560px) {
    .km-stat-grid {
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
    <strong>Kredit PPPK Paruh Waktu</strong>
  </div>
</div>

<section class="hero">
  <img class="hero-bg" src="{{ asset('frontend/images/kredit-konsumer.jpg') }}" alt="Kredit PPPK Paruh Waktu">
  <div class="container">
    <h1>Kredit PPPK Paruh Waktu</h1>
    <p>Solusi finansial yang dirancang khusus untuk membiayai kebutuhan konsumsi pegawai PPPK Paruh Waktu
      dengan proses transparan dan bunga kompetitif.</p>
    <div class="hero-actions">
      <a href="https://api.whatsapp.com/send/?phone=6285382659996&text&type=phone_number&app_absent=0"
        target="_blank" rel="noopener" class="btn btn-primary">Ajukan Sekarang</a>
      <a href="#detail" class="btn btn-outline-white">Pelajari Selengkapnya</a>
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
          <a href="{{ route('public.kredit.kredit-pppk') }}" class="tab-product-item">
            <span class="ic">📇</span>
            <span>Kredit PPPK</span>
          </a>
        </li>
        <li>
          <a href="{{ route('public.kredit.kredit-pppk-paruh-waktu') }}" class="tab-product-item active">
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
          target="_blank" rel="noopener" class="btn-tel">Hubungi CS</a>
      </div>
    </aside>

    <div class="tab-content">
      <div class="tab-panel active" id="panel-pppk-paruh">

        <div class="tab-detail-card">
          <div class="tab-detail-top">
            <h2>KREDIT PEGAWAI PEMERINTAH DENGAN PERJANJIAN KERJA (PPPK) PARUH WAKTU</h2>
          </div>
          <p>Solusi finansial yang dirancang khusus untuk membiayai kebutuhan konsumsi pegawai PPPK Paruh
            Waktu dengan proses transparan, persyaratan mudah, dan suku bunga yang sangat kompetitif.
          </p>

          <div class="km-stat-grid">
            <div class="km-stat-card">
              <div class="km-stat-ic">💳</div>
              <div class="km-stat-lbl">Plafond Maksimal</div>
              <div class="km-stat-val">Maks. Rp21.000.000</div>
            </div>
            <div class="km-stat-card">
              <div class="km-stat-ic">🕐</div>
              <div class="km-stat-lbl">Tenor Pinjaman</div>
              <div class="km-stat-val">12 Bulan</div>
            </div>
            <div class="km-stat-card">
              <div class="km-stat-ic">📈</div>
              <div class="km-stat-lbl">Suku Bunga</div>
              <div class="km-stat-val">20.90% Anuitas/Thn</div>
            </div>
            <div class="km-stat-card">
              <div class="km-stat-ic">🛡️</div>
              <div class="km-stat-lbl">Agunan Utama</div>
              <div class="km-stat-val">SK PPPK & Ijazah</div>
            </div>
          </div>
        </div>

        <div class="km-grid-bottom">
          <div class="km-left-col">

            <div class="tp-info-card">
              <div class="tp-info-head">
                <div class="tp-info-ic">👤</div>
                <h3>Kriteria & Persyaratan Utama</h3>
              </div>
              <ul class="tp-check-list">
                <li><span class="li-ic">✔️</span> Berstatus aktif sebagai Pegawai PPPK Paruh Waktu.
                </li>
                <li><span class="li-ic">✔️</span> Menyertakan SK Asli dan Ijazah Asli sebagai
                  jaminan utama.</li>
                <li><span class="li-ic">✔️</span> Pembayaran gaji (Payroll) melalui Bank Waway atau
                  kerjasama bendahara.</li>
                <li><span class="li-ic">✔️</span> Biaya administrasi flat sebesar Rp150.000.</li>
              </ul>
            </div>

            <div class="tp-info-card">
              <div class="tp-info-head">
                <div class="tp-info-ic">📄</div>
                <h3>Dokumen Persyaratan</h3>
              </div>
              <div class="tp-terms-grid">
                <div class="tp-terms-item"><span class="li-ic">🪪</span><span>e-KTP & KK</span>
                </div>
                <div class="tp-terms-item"><span class="li-ic">📄</span><span>Rekening Koran 3
                  Bln</span></div>
                <div class="tp-terms-item"><span class="li-ic">📝</span><span>Status Usulan MOLA
                  & DRH</span></div>
                <div class="tp-terms-item"><span class="li-ic">✍️</span><span>SK PPPK & Ijazah
                  Asli</span></div>
                <div class="tp-terms-item"><span class="li-ic">✅</span><span>Absensi 1 Bulan</span>
                </div>
                <div class="tp-terms-item"><span class="li-ic">💳</span><span>Daftar Gaji
                  Terakhir</span></div>
                <div class="tp-terms-item"><span class="li-ic">💰</span><span>Tabungan Bank
                  Waway</span></div>
                <div class="tp-terms-item"><span class="li-ic">📋</span><span>Rekomendasi
                  Pimpinan</span></div>
              </div>
            </div>

          </div>

          <div class="km-cta-card">
            <h3>Mulai Pengajuan Sekarang</h3>
            <p>Tim ahli perbankan kami siap membantu Anda menghitung simulasi cicilan dan melengkapi
              dokumen yang diperlukan.</p>
            <a href="https://api.whatsapp.com/send/?phone=6285382659996&text&type=phone_number&app_absent=0"
              target="_blank" rel="noopener" class="btn btn-primary">📝 Pengajuan PPPK Paruh Waktu</a>
            <div class="km-cta-note">Butuh Info Lebih Lanjut?</div>
            <div class="km-cta-contact">📞 <a href="tel:0721266869">0721-266869</a></div>
            <div class="km-cta-contact">✉️ <a
                href="mailto:Bankwawaylampung@yahoo.com">Bankwawaylampung@yahoo.com</a></div>
          </div>
        </div>

      </div>

    </div>
  </div>
</section>
@endsection
