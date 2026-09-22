@extends('layouts.public')

@section('title', 'Bank Waway Lampung - Deposito')

@section('styles')
<style>
  .btn-outline:hover {
    background: var(--blue);
    color: #fff;
    border-color: var(--blue);
  }
</style>
@endsection

@section('content')

<section class="hero">
  <img class="hero-bg" src="{{ asset('admin/images/Bangunan.png') }}" alt="Deposito Waway">
  <div class="hero-overlay"></div>
  <div class="container hero-content">
    <span class="eyebrow" style="color:#93c5fd">Produk Unggulan</span>
    <h1 style="margin-top:14px">Deposito Waway</h1>
    <p>Wujudkan masa depan finansial yang lebih cerah dengan suku bunga kompetitif dan fleksibilitas jangka waktu yang
      sesuai dengan rencana investasi Anda.</p>
    <div class="hero-actions">
      <a href="#simulasi" class="btn btn-primary">Mulai Investasi 📈</a>
    </div>
  </div>
</section>

<section class="section">
  <div class="container">
    <h2 class="section-title">Peluang Deposito</h2>
    <p class="section-sub">Pilih jangka waktu yang paling sesuai dengan target finansial Anda. Dapatkan hasil maksimal
      dengan risiko yang terukur.</p>

    <div class="grid-4" style="margin-top:52px">
      <article class="tenor-card">
        <div class="tenor-icon">📅</div>
        <h3>1 Bulan</h3>
        <p>Likuiditas tinggi untuk kebutuhan finansial jangka sangat pendek dengan bunga kompetitif.</p>
        <a href="https://api.whatsapp.com/send/?phone=6285382659996&text&type=phone_number&app_absent=0"
          target="_blank" rel="noopener" class="btn btn-outline" style="width:100%;justify-content:center">Ajukan
          Deposito</a>
      </article>

      <article class="tenor-card">
        <div class="tenor-icon">🗓️</div>
        <h3>3 Bulan</h3>
        <p>Keseimbangan ideal antara fleksibilitas dana dan pertumbuhan nilai investasi Anda.</p>
        <a href="https://api.whatsapp.com/send/?phone=6285382659996&text&type=phone_number&app_absent=0"
          target="_blank" rel="noopener" class="btn btn-outline" style="width:100%;justify-content:center">Ajukan
          Deposito</a>
      </article>

      <article class="tenor-card">
        <div class="tenor-icon">⏰</div>
        <h3>6 Bulan</h3>
        <p>Optimalkan pertumbuhan aset Anda dengan periode tenor tengah yang lebih menguntungkan.</p>
        <a href="https://api.whatsapp.com/send/?phone=6285382659996&text&type=phone_number&app_absent=0"
          target="_blank" rel="noopener" class="btn btn-outline" style="width:100%;justify-content:center">Ajukan
          Deposito</a>
      </article>

      <article class="tenor-card featured">
        <div class="tenor-icon">💡</div>
        <h3>12 Bulan</h3>
        <p>Dapatkan imbal hasil maksimal untuk perencanaan masa depan yang lebih kokoh dan stabil.</p>
        <a href="https://api.whatsapp.com/send/?phone=6285382659996&text&type=phone_number&app_absent=0"
          target="_blank" rel="noopener" class="btn btn-primary" style="width:100%;justify-content:center">Ajukan
          Deposito</a>
      </article>
    </div>
  </div>
</section>

<section class="section" style="background:var(--bg-soft)">
  <div class="container grid-2" style="align-items:center">
    <div>
      <h2 style="font-size:34px;color:var(--navy);font-weight:800">Investasi Aman & Terpercaya</h2>
      <p style="color:var(--text-muted);margin:18px 0 30px">Bank Waway Lampung berkomitmen memberikan layanan
        investasi yang transparan. Deposito Anda dijamin oleh Lembaga Penjamin Simpanan (LPS) sesuai ketentuan yang
        berlaku, memberikan ketenangan pikiran dalam setiap langkah finansial Anda.</p>

      <ul class="feature-list">
        <li><span class="feat-icon">🛡️</span>
          <div><strong>Dijamin LPS</strong><br>Simpanan Anda aman terlindungi secara hukum.</div>
        </li>
        <li><span class="feat-icon">📊</span>
          <div><strong>Bunga Kompetitif</strong><br>Nikmati persentase bagi hasil di atas rata-rata pasar.</div>
        </li>
        <li><span class="feat-icon">⚡</span>
          <div><strong>Proses Cepat</strong><br>Pembukaan rekening tanpa hambatan birokrasi.</div>
        </li>
      </ul>
    </div>
    <div>
      <img src="{{ asset('frontend/images/deposito-gedung.jpg') }}" alt="Kantor Bank Waway"
        style="border-radius:16px;box-shadow:var(--shadow)">
    </div>
  </div>
</section>

<section class="section" id="simulasi">
  <div class="container">
    <div class="sim-wrap">
      <div class="sim-left">
        <h2>Simulasi Deposito</h2>
        <p>Hitung estimasi keuntungan investasi Anda sebelum memulai. Masukkan nominal dan pilih tenor untuk melihat
          proyeksi hasilnya.</p>

        <label class="sim-label" for="nominal">Nominal Investasi (IDR)</label>
        <div class="sim-input"><span>Rp</span><input type="text" inputmode="numeric" id="nominal" value="100.000.000">
        </div>
        <p class="sim-min-note" id="nominalWarning"
          style="display:none;color:#fca5a5;font-size:12.5px;margin-top:8px">
          Nominal minimum deposito adalah Rp 1.000.000.
        </p>

        <label class="sim-label" style="margin-top:22px;display:block">Pilih Tenor</label>
        <div class="sim-tenor">
          <button type="button" class="tenor-btn active" data-bulan="1">1 Bln</button>
          <button type="button" class="tenor-btn" data-bulan="3">3 Bln</button>
          <button type="button" class="tenor-btn" data-bulan="6">6 Bln</button>
          <button type="button" class="tenor-btn" data-bulan="12">12 Bln</button>
        </div>
      </div>

      <div class="sim-right">
        <div class="sim-row">
          <span>Suku Bunga (per tahun)</span>
          <span id="rate">5.5%</span>
        </div>
        <div class="sim-row">
          <span>Estimasi Bunga (Setahun)</span>
          <span id="bungaKotor">Rp 0</span>
        </div>
        <div class="sim-row">
          <span>Pajak Bunga (20%)</span>
          <span id="pajak">Rp 0</span>
        </div>
        <div class="sim-row">
          <span>Bunga Bersih / Bulan</span>
          <span id="bunga">Rp 0</span>
        </div>
        <hr>
        <div class="sim-total">
          <span>Total Pengembalian (Saat Jatuh Tempo)</span>
          <div class="sim-total-value" id="total">Rp 0</div>
        </div>
        <p class="sim-note">*Estimasi sudah memperhitungkan pajak bunga deposito 20% sesuai ketentuan yang berlaku.
        </p>
      </div>
    </div>
  </div>
</section>

@endsection

@section('scripts')
<script src="{{ asset('frontend/js/deposito.js') }}"></script>
@endsection
