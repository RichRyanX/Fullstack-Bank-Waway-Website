@extends('layouts.public')

@section('title', 'Tabungan Cerdik - Bank Waway Lampung')

@section('content')

<section class="tab-hero">
  <img class="hero-bg" src="{{ asset('frontend/images/hero-tabungan.jpg') }}" alt="Bank Waway Lampung">
  <div class="container">
    <h1>Masa Depan Terencana Bersama<br>Tabungan Waway</h1>
    <p>Wujudkan impian Anda dengan berbagai pilihan tabungan yang aman, kompetitif, dan sesuai dengan kebutuhan gaya
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
            <a href="{{ route('public.tabungan.pegawai') }}" class="tab-product-item">
              <span class="ic">🧑‍💼</span> Tabungan Pegawai
            </a>
          </li>
          <li>
            <a href="{{ route('public.tabungan.cerdik') }}" class="tab-product-item active">
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
            <h2>Tabungan Cerdik</h2>
            <span class="tab-badge-populer">Populer</span>
          </div>
          <p>Tabungan CERDIK merupakan produk Tabungan TAPIS yang dikhususkan bagi guru PNS maupun tenaga honorer.
          </p>
        </div>

        <div class="tc-grid-top">
          <div class="tc-benefit-card">
            <div class="tc-benefit-head">
              <span class="tc-benefit-ic">⚙️</span>
              <h3>Keunggulan Utama</h3>
            </div>
            <div class="tc-benefit-items">
              <div class="tc-benefit-item">
                <span class="ic">%</span>
                <div>
                  <h4>Bunga Kompetitif</h4>
                  <p>Suku bunga 1% per tahun untuk simpanan Anda.</p>
                </div>
              </div>
              <div class="tc-benefit-item">
                <span class="ic">🛡️</span>
                <div>
                  <h4>Dijamin LPS</h4>
                  <p>Dana Anda aman dan terjamin oleh lembaga pemerintah.</p>
                </div>
              </div>
              <div class="tc-benefit-item">
                <span class="ic">👁️</span>
                <div>
                  <h4>Transparan</h4>
                  <p>Pencatatan mutasi transparan dan dapat dipantau.</p>
                </div>
              </div>
              <div class="tc-benefit-item">
                <span class="ic">📋</span>
                <div>
                  <h4>Penarikan Mudah</h4>
                  <p>Proses penarikan dana yang fleksibel dan cepat.</p>
                </div>
              </div>
            </div>
          </div>

          <div class="tc-terms-card">
            <h3>Ketentuan</h3>
            <div class="tc-terms-list">
              <div class="tc-terms-row">
                <span>Setoran Awal</span>
                <strong>Rp50.000</strong>
              </div>
              <div class="tc-terms-row">
                <span>Min. Setoran</span>
                <strong>Rp10.000</strong>
              </div>
              <div class="tc-terms-row">
                <span>Saldo Minimal</span>
                <strong>Rp50.000</strong>
              </div>
              <div class="tc-terms-row">
                <span>Admin/Bulan</span>
                <strong>Rp5.000</strong>
              </div>
            </div>
          </div>
        </div>

        <div class="tc-grid-bottom">
          <div class="tc-req-card">
            <h3>Persyaratan</h3>
            <ul>
              <li><span class="li-ic">✅</span> Fotokopi KTP (WNI) yang masih berlaku</li>
              <li><span class="li-ic">✅</span> Fotokopi NPWP (jika ada)</li>
              <li><span class="li-ic">✅</span> Mengisi formulir aplikasi pembukaan rekening</li>
              <li><span class="li-ic">✅</span> Mengisi formulir slip penyetoran</li>
            </ul>
          </div>

          <div class="tc-manfaat-card">
            <h3>Manfaat Masa Depan</h3>
            <div class="tc-manfaat-grid">
              <div class="tc-manfaat-item">
                <h4>Keamanan Dana</h4>
                <p>Menyimpan dana secara aman dalam sistem perbankan terpercaya.</p>
              </div>
              <div class="tc-manfaat-item">
                <h4>Pengelolaan Keuangan</h4>
                <p>Memudahkan Anda mengelola arus kas pribadi secara profesional.</p>
              </div>
              <div class="tc-manfaat-item">
                <h4>Perencanaan Jangka Pendek</h4>
                <p>Mendukung pencapaian target finansial jangka dekat Anda.</p>
              </div>
              <div class="tc-manfaat-item">
                <h4>Rencana Jangka Panjang</h4>
                <p>Menyiapkan bantalan finansial untuk masa pensiun atau hari tua.</p>
              </div>
            </div>
            <div class="tc-manfaat-float">📈</div>
          </div>
        </div>

      </div>

    </div>
  </div>
</section>

@endsection
