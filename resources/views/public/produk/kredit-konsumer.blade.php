@extends('layouts.public')

@section('title', 'Bank Waway Lampung - Kredit Konsumer')

@section('styles')
<style>
  .sifat-title-row {
    display: flex;
    align-items: center;
    gap: 10px;
    margin: 8px 0 18px;
  }

  .sifat-title-row .bar {
    width: 4px;
    height: 20px;
    background: var(--blue);
    border-radius: 2px;
  }

  .sifat-title-row h3 {
    font-size: 18px;
    font-weight: 800;
    color: var(--navy);
  }

  .sifat-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
    margin-bottom: 8px;
  }

  .sifat-card {
    background: #fff;
    border: 1px solid var(--border);
    border-radius: var(--radius);
    padding: 24px 26px;
  }

  .sifat-card h4 {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 15.5px;
    font-weight: 700;
    color: var(--navy);
    margin-bottom: 10px;
  }

  .sifat-card h4 .dot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: var(--blue);
    flex: none;
  }

  .sifat-card p {
    font-size: 13.5px;
    color: var(--text-muted);
    line-height: 1.65;
  }

  .ketentuan-card {
    background: var(--navy);
    border-radius: var(--radius);
    overflow: hidden;
    color: #fff;
    margin-bottom: 8px;
  }

  .ketentuan-head {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 17px;
    font-weight: 800;
    padding: 22px 30px;
    background: rgba(255, 255, 255, .06);
  }

  .ketentuan-list {
    padding: 6px 30px 6px;
  }

  .ketentuan-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 20px;
    padding: 16px 0;
    border-top: 1px solid rgba(255, 255, 255, .12);
    font-size: 14px;
  }

  .ketentuan-row:first-child {
    border-top: none;
  }

  .ketentuan-row span:first-child {
    color: #c7d3ef;
    font-weight: 600;
  }

  .ketentuan-row span:last-child {
    color: #fff;
    text-align: right;
    max-width: 60%;
  }

  .persyaratan-head {
    text-align: center;
    margin: 12px 0 26px;
  }

  .persyaratan-head h2 {
    font-size: 24px;
    font-weight: 800;
    color: var(--navy);
  }

  .tab-panel {
    display: none;
  }

  .tab-panel.active {
    display: flex;
    flex-direction: column;
    gap: 20px;
  }

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

  .tab-formdana-btn {
    margin: 10px 0 20px;
    background: #ffffff;
    color: var(--navy, #1e3a8a);
  }

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

  .km-cta-card .btn-outline-white {
    margin-bottom: 22px;
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
    <strong>Kredit Konsumer</strong>
  </div>
</div>

<section class="hero">
  <img class="hero-bg" src="{{ asset('frontend/images/kredit-konsumer.jpg') }}" alt="Kredit Konsumer">
  <div class="container">
    <h1>Kredit Konsumer</h1>
    <p>Wujudkan impian pribadi dan keluarga Anda dengan solusi pembiayaan yang fleksibel dan terpercaya. Kami
      hadir untuk mendukung kebutuhan konsumsi Anda mulai dari renovasi rumah, pendidikan, hingga kebutuhan
      gaya hidup lainnya.</p>
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
          <a href="{{ route('public.kredit.kredit-konsumer') }}" class="tab-product-item active">
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
      <div class="tab-panel active" id="panel-konsumer">

        <div class="tab-detail-card">
          <div class="tab-detail-top">
            <h2>KREDIT PEGAWAI (PNS, BUMD, BUMN, DPRD)</h2>
          </div>
          <p>Fasilitas kredit yang diberikan khusus untuk membiayai kebutuhan konsumtif bagi Pegawai
            Negeri Sipil (PNS), Karyawan BUMD/BUMN, serta Anggota DPRD. Produk ini menawarkan proses
            yang cepat, persyaratan yang mudah, dan suku bunga yang sangat kompetitif untuk mendukung
            kesejahteraan finansial pegawai.</p>

          <div class="km-stat-grid">
            <div class="km-stat-card">
              <div class="km-stat-ic">📇</div>
              <div class="km-stat-lbl">Plafond Kredit</div>
              <div class="km-stat-val">5jt – 500jt</div>
            </div>
            <div class="km-stat-card">
              <div class="km-stat-ic">🕐</div>
              <div class="km-stat-lbl">Jangka Waktu</div>
              <div class="km-stat-val">12 – 240 Bln</div>
            </div>
            <div class="km-stat-card">
              <div class="km-stat-ic">📈</div>
              <div class="km-stat-lbl">Suku Bunga</div>
              <div class="km-stat-val">7.45% – 8.90%</div>
            </div>
            <div class="km-stat-card">
              <div class="km-stat-ic">🛡️</div>
              <div class="km-stat-lbl">Agunan Utama</div>
              <div class="km-stat-val">SK Pegawai</div>
            </div>
          </div>
        </div>

        <div class="km-grid-bottom">
          <div class="km-left-col">

            <div class="tp-info-card">
              <div class="tp-info-head">
                <div class="tp-info-ic">👤</div>
                <h3>Kriteria Debitur</h3>
              </div>
              <ul class="tp-check-list">
                <li><span class="li-ic">✔️</span> Telah memiliki SK pengangkatan sebagai CPNS / PNS 100%.</li>
                <li><span class="li-ic">✔️</span> Usia calon debitur tidak lebih dari 2 bulan sebelum masa pensiun.</li>
                <li><span class="li-ic">✔️</span> Telah memiliki SK pengangkatan sebagai Anggota Dewan (DPRD).</li>
                <li><span class="li-ic">✔️</span> Pembayaran gaji (Payroll) dilakukan melalui Bank Waway Lampung.</li>
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
                <div class="tp-terms-item"><span class="li-ic">📃</span><span>NPWP Pribadi</span>
                </div>
                <div class="tp-terms-item"><span class="li-ic">💳</span><span>Slip Gaji Terakhir</span></div>
                <div class="tp-terms-item"><span class="li-ic">🧾</span><span>SK CPNS/PNS Asli</span></div>
                <div class="tp-terms-item"><span class="li-ic">🏦</span><span>Rekening Koran</span>
                </div>
                <div class="tp-terms-item"><span class="li-ic">📸</span><span>Pas Foto Terbaru</span></div>
                <div class="tp-terms-item"><span class="li-ic">📑</span><span>KARPEG / TASPEN</span>
                </div>
                <div class="tp-terms-item"><span class="li-ic">✍️</span><span>Surat Kuasa Potong Gaji</span></div>
              </div>
            </div>

          </div>

          <div class="km-cta-card">
            <h3>Mulai Pengajuan Sekarang</h3>
            <p>Tim ahli perbankan kami siap membantu Anda menghitung simulasi cicilan dan melengkapi
              dokumen yang diperlukan.</p>
            <a href="https://script.google.com/macros/s/AKfycbxG6ZHxvvHxmV4BDbjp_tsY8nSll7IrO7OzDbIG062Z-dZ6gxDClCV8fB-z6bimDUB2/exec"
              target="_blank" class="btn btn-primary">📝 Form Kredit Pegawai</a>
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
