@extends('layouts.public')

@section('title', 'Bank Waway Lampung - Kredit Tukin')

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

  /* ====== Tampilan Sidebar Produk (disamakan dengan kredit-konsumer) ====== */
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
    grid-template-columns: 32px 1fr auto;
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

  .kp-detail-top h2 {
    font-size: 20px;
    font-weight: 800;
    color: var(--navy);
    line-height: 1.3;
    margin-bottom: 10px;
  }

  .kp-detail-top p {
    color: var(--text-muted);
    font-size: 14px;
    line-height: 1.6;
  }

  /* ====== Detail Produk + Proses Cepat ====== */
  .tukin-top-grid {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 20px;
    align-items: stretch;
  }

  .detail-produk-card {
    background: #fff;
    border: 1px solid var(--border);
    border-radius: var(--radius);
    padding: 24px 26px;
  }

  .detail-produk-head {
    display: flex;
    align-items: center;
    gap: 9px;
    font-size: 15.5px;
    font-weight: 800;
    color: var(--navy);
    margin-bottom: 22px;
  }

  .detail-produk-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    row-gap: 20px;
    column-gap: 20px;
  }

  .dp-item .dp-lbl {
    font-size: 10.5px;
    font-weight: 800;
    letter-spacing: .5px;
    text-transform: uppercase;
    color: var(--text-muted);
    margin-bottom: 6px;
  }

  .dp-item .dp-val {
    font-size: 15.5px;
    font-weight: 800;
    color: var(--navy);
  }

  .dp-item .dp-val.accent {
    color: var(--blue);
  }

  .proses-cepat-card {
    background: var(--navy);
    border-radius: var(--radius);
    padding: 26px 24px;
    color: #fff;
  }

  .proses-cepat-ic {
    width: 42px;
    height: 42px;
    border-radius: 10px;
    background: rgba(255, 255, 255, .15);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
    margin-bottom: 16px;
  }

  .proses-cepat-card h4 {
    font-size: 16px;
    font-weight: 800;
    margin-bottom: 10px;
  }

  .proses-cepat-card p {
    font-size: 12.5px;
    line-height: 1.6;
    color: #cbd5f5;
  }

  /* ====== Persyaratan Utama + Dokumen Pendukung ====== */
  .kp-bottom-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
  }

  .kp-info-panel {
    background: #fff;
    border: 1px solid var(--border);
    border-radius: var(--radius);
    padding: 24px 26px;
  }

  .kp-info-panel.blue-bg {
    background: #eef4ff;
    border-color: #d7e6fd;
  }

  .kp-info-panel .kp-panel-head {
    display: flex;
    align-items: center;
    gap: 9px;
    font-size: 15.5px;
    font-weight: 800;
    color: var(--navy);
    margin-bottom: 18px;
  }

  .syarat-list li {
    list-style: none;
    display: flex;
    align-items: flex-start;
    gap: 10px;
    font-size: 13px;
    color: var(--text);
    line-height: 1.55;
    margin-bottom: 16px;
  }

  .syarat-list li:last-child {
    margin-bottom: 0;
  }

  .syarat-list .li-ic {
    color: #16a34a;
    font-size: 14px;
    flex: none;
    margin-top: 1px;
  }

  .dokumen-grid2 {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 12px;
  }

  .dokumen-item2 {
    display: flex;
    align-items: center;
    gap: 10px;
    background: #fff;
    border: 1px solid var(--border);
    border-radius: 8px;
    padding: 12px 14px;
  }

  .dokumen-item2 .ic {
    font-size: 15px;
    flex: none;
  }

  .dokumen-item2 span.txt {
    font-size: 12.5px;
    font-weight: 600;
    color: var(--text);
    line-height: 1.4;
  }

  /* ====== CTA banner ====== */
  .tab-cta-banner.tukin-cta {
    flex-direction: column;
    text-align: center;
    align-items: center;
    gap: 12px;
    padding: 34px 30px;
  }

  .tukin-cta h3 {
    font-size: 21px;
  }

  .tukin-cta p {
    max-width: 560px;
    font-size: 13.5px;
    opacity: .85;
  }

  .tukin-cta-actions {
    display: flex;
    gap: 12px;
    margin-top: 8px;
  }

  .btn-white-solid {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: #fff;
    color: var(--navy);
    font-size: 13.5px;
    font-weight: 700;
    padding: 12px 20px;
    border-radius: 8px;
    text-decoration: none;
  }

  .btn-white-solid:hover {
    background: #e2e8f0;
  }

  @media(max-width: 900px) {
    .tukin-top-grid {
      grid-template-columns: 1fr;
    }

    .detail-produk-grid {
      grid-template-columns: 1fr;
    }

    .kp-bottom-grid {
      grid-template-columns: 1fr;
    }

    .dokumen-grid2 {
      grid-template-columns: 1fr;
    }

    .tukin-cta-actions {
      flex-direction: column;
      width: 100%;
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
    <strong>Kredit Tukin</strong>
  </div>
</div>

<section class="hero">
  <img class="hero-bg" src="{{ asset('frontend/images/kredit-konsumer.jpg') }}" alt="Kredit Tukin">
  <div class="container">
    <h1>Kredit Tukin</h1>
    <p>Fasilitas pembiayaan konsumtif khusus untuk PNS dengan kemudahan persyaratan dan proses yang cepat
      menggunakan agunan SK Jabatan.</p>
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
          <a href="{{ route('public.kredit.kredit-pppk') }}" class="tab-product-item">
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
          <a href="{{ route('public.kredit.kredit-tukin') }}" class="tab-product-item active">
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

      <div class="tab-panel active" id="panel-tukin">

        <div class="tab-detail-card kp-detail-top">
          <div>
            <h2>Kredit Tunjangan Kinerja Pegawai Negeri Sipil</h2>
            <p>Fasilitas pembiayaan konsumtif khusus untuk PNS dengan kemudahan persyaratan dan
              proses yang cepat menggunakan agunan SK Jabatan.</p>
          </div>
        </div>

        <div class="tukin-top-grid">
          <div class="detail-produk-card">
            <div class="detail-produk-head">ⓘ Detail Produk</div>
            <div class="detail-produk-grid">
              <div class="dp-item">
                <div class="dp-lbl">Tujuan Kredit</div>
                <div class="dp-val">Konsumtif</div>
              </div>
              <div class="dp-item">
                <div class="dp-lbl">Suku Bunga</div>
                <div class="dp-val accent">12.00% Flat per Tahun</div>
              </div>
              <div class="dp-item">
                <div class="dp-lbl">Plafond</div>
                <div class="dp-val">Rp 5.000.000 — Rp 200.000.000</div>
              </div>
              <div class="dp-item">
                <div class="dp-lbl">Provisi</div>
                <div class="dp-val">0.25%</div>
              </div>
              <div class="dp-item">
                <div class="dp-lbl">Jangka Waktu</div>
                <div class="dp-val">Maksimal 24 Bulan</div>
              </div>
              <div class="dp-item">
                <div class="dp-lbl">Agunan</div>
                <div class="dp-val">SK Jabatan / Golongan Terakhir</div>
              </div>
            </div>
          </div>

          <div class="proses-cepat-card">
            <div class="proses-cepat-ic">✎</div>
            <h4>Proses Cepat</h4>
            <p>Persetujuan kredit dalam waktu singkat setelah dokumen lengkap diterima oleh sistem
              kami.</p>
          </div>
        </div>

        <div class="kp-bottom-grid">
          <div class="kp-info-panel">
            <div class="kp-panel-head">✅ Persyaratan Utama</div>
            <ul class="syarat-list">
              <li><span class="li-ic">✔</span> PNS penerima Tukin (Instansi yang telah bekerjasama
                dengan Bank Waway).</li>
              <li><span class="li-ic">✔</span> Tidak sedang memiliki fasilitas kredit sejenis di
                bank lain.</li>
              <li><span class="li-ic">✔</span> Memiliki track record kolektibilitas lancar.</li>
            </ul>
          </div>

          <div class="kp-info-panel blue-bg">
            <div class="kp-panel-head">📄 Dokumen Pendukung</div>
            <div class="dokumen-grid2">
              <div class="dokumen-item2"><span class="ic">👤</span><span class="txt">KTP &
                NPWP</span></div>
              <div class="dokumen-item2"><span class="ic">👨‍👩‍👧</span><span class="txt">Kartu
                Keluarga</span></div>
              <div class="dokumen-item2"><span class="ic">📄</span><span class="txt">Rek. Koran
                Tukin (3 Bln)</span></div>
              <div class="dokumen-item2"><span class="ic">📃</span><span class="txt">NCR / Daftar
                Tukin</span></div>
              <div class="dokumen-item2"><span class="ic">🪪</span><span class="txt">SK Jabatan /
                Golongan</span></div>
              <div class="dokumen-item2"><span class="ic">💳</span><span class="txt">Tabungan Bank
                Waway</span></div>
            </div>
          </div>
        </div>

        <div class="tab-cta-banner tukin-cta">
          <h3>Siap untuk Memulai Langkah Anda?</h3>
          <p>Ajukan kredit tunjangan kinerja sekarang dan nikmati proses tanpa hambatan untuk
            kebutuhan masa depan Anda.</p>
          <div class="tukin-cta-actions">
            <a href="https://api.whatsapp.com/send/?phone=6285382659996&text&type=phone_number&app_absent=0"
              target="_blank" rel="noopener" class="btn-find">Hubungi Marketing Kami</a>
          </div>
        </div>
      </div>

    </div>
  </div>
</section>
@endsection
