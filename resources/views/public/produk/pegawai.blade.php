@extends('layouts.public')

@section('title', 'Tabungan Pegawai - Bank Waway Lampung')

@section('content')

<section class="tab-hero">
  <img class="hero-bg" src="{{ asset('frontend/images/hero-tabungan.jpg') }}" alt="Bank Waway Lampung">
  <div class="container">
    <h1>Masa Depan Terencana Bersama<br>Tabungan Waway</h1>
    <p>Wujudkan impian Anda dengan berbagai pilihan tabungan yang aman, kompetitif, dan sesuai dengan kebutuhan
      gaya
      hidup modern masyarakat Lampung. Kunjungi kantor cabang terdekat atau hubungi marketing kami.</p>
    <a href="https://script.google.com/macros/s/AKfycby46hGvHAm6Zctinn9T1fOJGGM4z7baSBdeRwgXnO5Xe734Ge4Padd_-KAM1Cd-PWl7vA/exec"
      class="btn btn-white">Pembukaan Rekening</a>
  </div>
</section>

<section class="tab-section">
  <div class="container">
    <div class="tab-wrap">

      <aside class="tab-sidebar">
        <h4>Pilihan Produk</h4>
        <p class="tab-sidebar-sub">Pilih sesuai kebutuhan Anda</p>

        <ul class="tab-product-list">
          <li>
            <a href="{{ route('public.tabungan.index') }}" class="tab-product-item">
              <span class="ic">💰</span> Tabungan Simpel
            </a>
          </li>
          <li>
            <a href="{{ route('public.tabungan.tapis') }}" class="tab-product-item">
              <span class="ic">📱</span> Tabungan Tapis
            </a>
          </li>
          <li>
            <a href="{{ route('public.tabungan.pegawai') }}" class="tab-product-item active">
              <span class="ic">🧑‍💼</span> Tabungan Pegawai
            </a>
          </li>
          <li>
            <a href="{{ route('public.tabungan.cerdik') }}" class="tab-product-item">
              <span class="ic">🎓</span> Tabungan Cerdik
            </a>
          </li>
        </ul>

        <div class="tab-help-card">
          <h5>Butuh Bantuan?</h5>
          <p>Hubungi call center kami untuk konsultasi produk.</p>
          <a href="https://api.whatsapp.com/send/?phone=6285382659996&text&type=phone_number&app_absent=0"
            class="btn-tel">+0721 266 869</a>
        </div>
      </aside>

      <div class="tab-content">

        <div class="tab-detail-card">
          <div class="tab-detail-top">
            <h2>Tabungan Pegawai</h2>
            <span class="tab-badge-populer">Populer</span>
          </div>
          <p>Tabungan Pegawai merupakan produk Tabungan TAPIS yang dikhususkan bagi pegawai PNS maupun
            tenaga
            honorer.</p>
        </div>

        <div class="tc-grid-top">
          <div class="tc-benefit-card">
            <div class="tc-benefit-head">
              <span class="tc-benefit-ic">📊</span>
              <h3>Keunggulan Produk</h3>
            </div>
            <div class="tc-benefit-items">
              <div class="tc-benefit-item">
                <span class="ic">📈</span>
                <div>
                  <h4>Suku Bunga</h4>
                  <p>Suku bunga 1% per tahun untuk pertumbuhan dana optimal.</p>
                </div>
              </div>
              <div class="tc-benefit-item">
                <span class="ic">🛡️</span>
                <div>
                  <h4>Keamanan LPS</h4>
                  <p>Simpanan dijamin oleh LPS sesuai ketentuan yang berlaku.</p>
                </div>
              </div>
              <div class="tc-benefit-item">
                <span class="ic">📄</span>
                <div>
                  <h4>Transparansi</h4>
                  <p>Pencatatan mutasi transparan dan dapat dipantau berkala.</p>
                </div>
              </div>
              <div class="tc-benefit-item">
                <span class="ic">🏧</span>
                <div>
                  <h4>Penarikan Mudah</h4>
                  <p>Fasilitas penarikan yang fleksibel kapanpun dibutuhkan.</p>
                </div>
              </div>
            </div>
          </div>

          <div class="tp-manfaat-card">
            <h3>Manfaat Untuk Anda</h3>
            <ul class="tp-manfaat-list">
              <li>
                <span class="ic">🛡️</span>
                <span>Menyimpan dana dengan aman di bank tepercaya.</span>
              </li>
              <li>
                <span class="ic">🏦</span>
                <span>Memudahkan pengelolaan keuangan bulanan.</span>
              </li>
              <li>
                <span class="ic">📋</span>
                <span>Mendukung perencanaan keuangan jangka pendek dan panjang.</span>
              </li>
            </ul>
            <a href="https://api.whatsapp.com/send/?phone=6285382659996&text&type=phone_number&app_absent=0"
              class="tp-btn-ajukan">Ajukan Sekarang</a>
          </div>
        </div>

        <div class="tp-grid-bottom">
          <div class="tp-info-card">
            <div class="tp-info-head">
              <span class="tp-info-ic">🪪</span>
              <h3>Persyaratan</h3>
            </div>
            <ul class="tp-check-list">
              <li><span class="li-ic">✅</span> Fotokopi KTP (WNI) yang masih berlaku</li>
              <li><span class="li-ic">✅</span> Fotokopi NPWP (jika ada)</li>
              <li><span class="li-ic">✅</span> Mengisi formulir aplikasi pembukaan rekening</li>
              <li><span class="li-ic">✅</span> Mengisi formulir slip penyetoran</li>
            </ul>
          </div>

          <div class="tp-info-card">
            <div class="tp-info-head">
              <span class="tp-info-ic">🏦</span>
              <h3>Ketentuan</h3>
            </div>
            <div class="tp-terms-grid">
              <div class="tp-terms-item">
                <span class="lbl">Setoran Awal</span>
                <strong>Rp100.000</strong>
              </div>
              <div class="tp-terms-item">
                <span class="lbl">Setoran Min</span>
                <strong>Rp100.000</strong>
              </div>
              <div class="tp-terms-item">
                <span class="lbl">Saldo Minimal</span>
                <strong>Rp50.000</strong>
              </div>
              <div class="tp-terms-item">
                <span class="lbl">Biaya Admin</span>
                <strong>Rp5.000/bln</strong>
              </div>
            </div>
          </div>
        </div>

      </div>

    </div>
  </div>
</section>

@endsection
