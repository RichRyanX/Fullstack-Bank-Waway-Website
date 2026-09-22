@extends('layouts.public')

@section('title', 'Bank Waway Lampung - Kredit Prapensiun')

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

  /* ====== 3 kartu ringkasan ====== */
  .pra-stat-grid {
    display: grid;
    grid-template-columns: 2fr 1fr 1fr;
    gap: 18px;
    align-items: stretch;
  }

  .pra-stat-card {
    border-radius: var(--radius);
    padding: 20px 22px;
    display: flex;
    flex-direction: column;
    justify-content: center;
  }

  .pra-stat-card.white {
    background: #fff;
    border: 1px solid var(--border);
  }

  .pra-stat-card.light {
    background: #eef4ff;
    border: 1px solid #d7e6fd;
    align-items: center;
    text-align: center;
  }

  .pra-stat-card.navy {
    background: var(--navy);
    color: #fff;
    align-items: center;
    text-align: center;
  }

  .pra-stat-lbl {
    font-size: 10.5px;
    font-weight: 800;
    letter-spacing: .5px;
    text-transform: uppercase;
    color: var(--text-muted);
    margin-bottom: 8px;
  }

  .pra-stat-card.light .pra-stat-lbl,
  .pra-stat-card.navy .pra-stat-lbl {
    color: inherit;
    opacity: .8;
    text-transform: none;
    font-size: 13px;
    font-weight: 700;
    letter-spacing: 0;
  }

  .pra-stat-val {
    font-size: 21px;
    font-weight: 800;
    color: var(--navy);
  }

  .pra-stat-card.light .pra-stat-val,
  .pra-stat-card.navy .pra-stat-val {
    color: inherit;
    font-size: 17px;
  }

  .pra-stat-sub {
    font-size: 12px;
    color: var(--text-muted);
    margin-top: 8px;
  }

  .pra-stat-ic {
    font-size: 20px;
    margin-bottom: 8px;
  }

  /* ====== Tabs ====== */
  .pra-tabs-card {
    background: #fff;
    border: 1px solid var(--border);
    border-radius: var(--radius);
    overflow: hidden;
  }

  .pra-tabs-nav {
    display: flex;
    border-bottom: 1px solid var(--border);
    padding: 0 24px;
  }

  .pra-tab-btn {
    background: none;
    border: none;
    font-family: inherit;
    font-size: 13.5px;
    font-weight: 700;
    color: var(--text-muted);
    padding: 18px 4px;
    margin-right: 30px;
    cursor: pointer;
    border-bottom: 2px solid transparent;
  }

  .pra-tab-btn.active {
    color: var(--blue);
    border-bottom-color: var(--blue);
  }

  .pra-tabs-body {
    padding: 26px 28px;
  }

  .pra-tab-panel {
    display: none;
    grid-template-columns: 1.4fr 1fr;
    gap: 30px;
  }

  .pra-tab-panel.active {
    display: grid;
  }

  .pra-tab-left h4 {
    font-size: 14.5px;
    font-weight: 800;
    color: var(--navy);
    margin: 0 0 10px;
  }

  .pra-tab-left p {
    font-size: 13px;
    color: var(--text-muted);
    line-height: 1.65;
    margin-bottom: 22px;
  }

  .kriteria-list li {
    list-style: none;
    display: flex;
    align-items: flex-start;
    gap: 9px;
    font-size: 13px;
    color: var(--text);
    line-height: 1.55;
    margin-bottom: 12px;
  }

  .kriteria-list li:last-child {
    margin-bottom: 0;
  }

  .kriteria-list .li-ic {
    color: var(--blue);
    font-size: 14px;
    flex: none;
    margin-top: 1px;
  }

  .pra-tab-right {
    background: #f8fafc;
    border: 1px solid var(--border);
    border-radius: 10px;
    padding: 20px 20px;
  }

  .pra-tab-right h4 {
    font-size: 14px;
    font-weight: 800;
    color: var(--navy);
    margin: 0 0 16px;
  }

  .doc-item {
    display: flex;
    align-items: flex-start;
    gap: 10px;
    background: #fff;
    border: 1px solid var(--border);
    border-radius: 8px;
    padding: 12px 14px;
    margin-bottom: 12px;
  }

  .doc-item:last-child {
    margin-bottom: 0;
  }

  .doc-item .ic {
    font-size: 14px;
    flex: none;
    margin-top: 1px;
  }

  .doc-item span.txt {
    font-size: 12.5px;
    font-weight: 600;
    color: var(--text);
    line-height: 1.5;
  }

  /* ====== Simulasi Angsuran ====== */
  .simulasi-card {
    background: #fff;
    border: 1px solid var(--border);
    border-radius: var(--radius);
    padding: 28px 30px;
  }

  .simulasi-head {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 16px;
    margin-bottom: 24px;
  }

  .simulasi-head h3 {
    font-size: 17px;
    font-weight: 800;
    color: var(--navy);
    margin-bottom: 6px;
  }

  .simulasi-head p {
    font-size: 13px;
    color: var(--text-muted);
  }

  .anuitas-badge {
    display: flex;
    align-items: center;
    gap: 6px;
    background: #eef4ff;
    color: var(--blue);
    font-size: 12px;
    font-weight: 700;
    padding: 8px 12px;
    border-radius: 8px;
    white-space: nowrap;
  }

  .simulasi-grid {
    display: grid;
    grid-template-columns: 1.4fr 1fr;
    gap: 28px;
    align-items: start;
  }

  .sim-field {
    margin-bottom: 22px;
  }

  .sim-field:last-child {
    margin-bottom: 0;
  }

  .sim-field label {
    display: block;
    font-size: 12.5px;
    font-weight: 700;
    color: var(--text);
    margin-bottom: 10px;
  }

  .sim-field input[type="range"] {
    width: 100%;
    accent-color: var(--blue);
  }

  .sim-range-labels {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-top: 8px;
    font-size: 12px;
    color: var(--text-muted);
  }

  .sim-range-labels .mid {
    font-size: 14px;
    font-weight: 800;
    color: var(--navy);
  }

  .sim-field select {
    width: 100%;
    padding: 11px 14px;
    border: 1px solid var(--border);
    border-radius: 8px;
    font-family: inherit;
    font-size: 13.5px;
    color: var(--text);
    background: #fff;
  }

  .estimasi-box {
    background: var(--navy);
    border-radius: 12px;
    padding: 22px 22px;
    color: #fff;
  }

  .estimasi-lbl {
    font-size: 10.5px;
    font-weight: 700;
    letter-spacing: .5px;
    text-align: center;
    color: #93c5fd;
    margin-bottom: 8px;
  }

  .estimasi-val {
    font-size: 25px;
    font-weight: 800;
    text-align: center;
    margin-bottom: 18px;
  }

  .estimasi-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    font-size: 12.5px;
    padding: 10px 0;
    border-top: 1px solid rgba(255, 255, 255, .15);
  }

  .estimasi-row span:first-child {
    color: #cbd5f5;
  }

  .estimasi-row span:last-child {
    font-weight: 700;
  }

  @media(max-width: 900px) {
    .pra-stat-grid {
      grid-template-columns: 1fr;
    }

    .pra-tab-panel.active {
      grid-template-columns: 1fr;
    }

    .simulasi-grid {
      grid-template-columns: 1fr;
    }

    .pra-tabs-nav {
      overflow-x: auto;
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
    <strong>Kredit Prapensiun</strong>
  </div>
</div>

<section class="hero">
  <img class="hero-bg" src="{{ asset('frontend/images/kredit-konsumer.jpg') }}" alt="Kredit Prapensiun">
  <div class="container">
    <h1>Kredit Prapensiun</h1>
    <p>Fasilitas pembiayaan konsumsi eksklusif untuk PNS guna menyambut masa purna tugas dengan tenang.</p>
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
          <a href="{{ route('public.kredit.kredit-prapensiun') }}" class="tab-product-item active">
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

      <div class="tab-panel active" id="panel-prapensiun">

        <div class="tab-detail-card kp-detail-top">
          <div>
            <h2>Kredit Prapensiun Pegawai Negeri Sipil</h2>
            <p>Fasilitas pembiayaan konsumsi eksklusif untuk PNS guna menyambut masa purna tugas
              dengan tenang.</p>
          </div>
        </div>

        <div class="pra-stat-grid">
          <div class="pra-stat-card white">
            <div class="pra-stat-lbl">Plafond Hingga</div>
            <div class="pra-stat-val">Rp 500.000.000</div>
            <div class="pra-stat-sub">ⓘ Mulai dari Rp 5jt</div>
          </div>
          <div class="pra-stat-card light">
            <div class="pra-stat-ic">🕐</div>
            <div class="pra-stat-lbl">Tenor</div>
            <div class="pra-stat-val">s/d 240 Bulan</div>
          </div>
          <div class="pra-stat-card navy">
            <div class="pra-stat-ic">%</div>
            <div class="pra-stat-lbl">Suku Bunga</div>
            <div class="pra-stat-val">17.10% / Tahun</div>
          </div>
        </div>

        <div class="pra-tabs-card">
          <div class="pra-tabs-nav">
            <button class="pra-tab-btn active" data-tab="deskripsi">Deskripsi & Syarat</button>
            <button class="pra-tab-btn" data-tab="dokumen">Dokumen Terkait</button>
            <button class="pra-tab-btn" data-tab="biaya">Biaya & Admin</button>
          </div>
          <div class="pra-tabs-body">

            <div class="pra-tab-panel active" id="tab-deskripsi">
              <div class="pra-tab-left">
                <h4>Tentang Produk</h4>
                <p>Kredit Prapensiun adalah solusi finansial terpadu bagi Pegawai Negeri Sipil
                  (PNS) yang memasuki masa transisi menuju pensiun. Kami memahami kebutuhan
                  Anda untuk konsumsi, investasi, atau renovasi rumah di masa depan.</p>
                <h4>Kriteria Calon Debitur</h4>
                <ul class="kriteria-list">
                  <li><span class="li-ic">✔</span> Pegawai Negeri Sipil (PNS) Aktif.</li>
                  <li><span class="li-ic">✔</span> Maksimal 10 tahun sebelum masa pensiun.</li>
                  <li><span class="li-ic">✔</span> Usia maksimal 75 tahun saat kredit jatuh
                    tempo.</li>
                  <li><span class="li-ic">✔</span> Pembayaran gaji melalui payroll Bank
                    Waway.</li>
                </ul>
              </div>
              <div class="pra-tab-right">
                <h4>Kelengkapan Dokumen</h4>
                <div class="doc-item"><span class="ic">📄</span><span class="txt">Identitas Diri
                  (KTP, KK, NPWP, Pas Foto)</span></div>
                <div class="doc-item"><span class="ic">📘</span><span class="txt">Buku Nikah /
                  Cerai & Rekening Koran 3 Bln</span></div>
                <div class="doc-item"><span class="ic">🖇</span><span class="txt">SK CPNS 80%
                  & SK PNS 100%</span></div>
                <div class="doc-item"><span class="ic">🪪</span><span class="txt">KARPEG, TASPEN,
                  & SK Pangkat Terakhir</span></div>
                <div class="doc-item"><span class="ic">📃</span><span class="txt">NCR / Daftar
                  Gaji Terlegalisir</span></div>
                <div class="doc-item"><span class="ic">💳</span><span class="txt">Buku Tabungan
                  Bank Waway Lampung</span></div>
              </div>
            </div>

            <div class="pra-tab-panel" id="tab-dokumen">
              <div class="pra-tab-left">
                <h4>Dokumen Terkait</h4>
                <p>Silakan unduh dan pelajari dokumen resmi terkait produk Kredit Prapensiun
                  untuk informasi lebih lengkap mengenai syarat dan ketentuan yang berlaku.</p>
                <ul class="kriteria-list">
                  <li><span class="li-ic">📎</span> Brosur Kredit Prapensiun.</li>
                  <li><span class="li-ic">📎</span> Formulir Pengajuan Kredit.</li>
                  <li><span class="li-ic">📎</span> Syarat & Ketentuan Umum Kredit.</li>
                </ul>
              </div>
              <div class="pra-tab-right">
                <h4>Butuh Bantuan?</h4>
                <p style="font-size:12.5px;color:var(--text-muted);line-height:1.6">
                  Hubungi tim marketing kami untuk mendapatkan salinan dokumen lengkap atau
                  konsultasi lebih lanjut.</p>
              </div>
            </div>

            <div class="pra-tab-panel" id="tab-biaya">
              <div class="pra-tab-left">
                <h4>Biaya & Administrasi</h4>
                <ul class="kriteria-list">
                  <li><span class="li-ic">✔</span> Suku Bunga 17.10% per tahun (anuitas).</li>
                  <li><span class="li-ic">✔</span> Biaya Provisi 1% dari plafond disetujui.
                  </li>
                  <li><span class="li-ic">✔</span> Biaya Administrasi mengikuti simulasi
                    angsuran di bawah.</li>
                  <li><span class="li-ic">✔</span> Asuransi jiwa & kredit disesuaikan
                    dengan plafond dan tenor.</li>
                </ul>
              </div>
              <div class="pra-tab-right">
                <h4>Catatan</h4>
                <p style="font-size:12.5px;color:var(--text-muted);line-height:1.6">Nominal
                  akhir dapat berubah mengikuti hasil analisa kredit dan kebijakan yang
                  berlaku saat pengajuan.</p>
              </div>
            </div>

          </div>
        </div>

        <div class="tab-cta-banner">
          <div>
            <h3>Wujudkan Masa Pensiun yang Tenang</h3>
            <p>Ajukan Kredit Prapensiun sekarang bersama Bank Waway Lampung.</p>
          </div>
          <a href="https://api.whatsapp.com/send/?phone=6285382659996&text&type=phone_number&app_absent=0"
            target="_blank" rel="noopener" class="btn-find">Ajukan Sekarang</a>
        </div>
      </div>

    </div>
  </div>
</section>
@endsection

@section('scripts')
<script>
  // ---- Tab switcher: Deskripsi & Syarat / Dokumen Terkait / Biaya & Admin ----
  document.addEventListener('DOMContentLoaded', function () {
    var tabBtns = document.querySelectorAll('.pra-tab-btn');
    var tabPanels = document.querySelectorAll('.pra-tab-panel');

    tabBtns.forEach(function (btn) {
      btn.addEventListener('click', function () {
        var target = btn.getAttribute('data-tab');
        tabBtns.forEach(function (b) { b.classList.remove('active'); });
        btn.classList.add('active');
        tabPanels.forEach(function (p) { p.classList.remove('active'); });
        document.getElementById('tab-' + target).classList.add('active');
      });
    });

    // ---- Simulasi Angsuran ----
    var plafondInput = document.getElementById('simPlafond');
    var tenorSelect = document.getElementById('simTenor');
    var plafondVal = document.getElementById('simPlafondVal');
    var angsuranVal = document.getElementById('simAngsuran');
    var adminVal = document.getElementById('simAdmin');
    var annualRate = 0.1710;

    function formatRupiah(num) {
      return 'Rp ' + Math.round(num).toLocaleString('id-ID');
    }

    function hitungSimulasi() {
      var plafond = parseInt(plafondInput.value, 10);
      var tenor = parseInt(tenorSelect.value, 10);
      var r = annualRate / 12;
      var angsuran = (plafond * r) / (1 - Math.pow(1 + r, -tenor));
      var admin = plafond * 0.005;

      plafondVal.textContent = formatRupiah(plafond);
      angsuranVal.textContent = formatRupiah(angsuran);
      adminVal.textContent = formatRupiah(admin);
    }

    plafondInput.addEventListener('input', hitungSimulasi);
    tenorSelect.addEventListener('change', hitungSimulasi);
    hitungSimulasi();
  });
</script>
@endsection
