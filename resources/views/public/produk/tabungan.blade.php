@extends('layouts.public')

@section('title', 'Tabungan Simpel - Bank Waway Lampung')

@section('content')

<section class="tab-hero">
  <img class="hero-bg" src="{{ asset('admin/images/Bangunan.png') }}" alt="Bank Waway Lampung">

  <button class="carousel-arrow prev" aria-label="Sebelumnya">‹</button>
  <button class="carousel-arrow next" aria-label="Berikutnya">›</button>

  <div class="container">
    <h1>Masa Depan Terencana Bersama<br>Tabungan Waway</h1>
    <p>Wujudkan impian Anda dengan berbagai pilihan tabungan yang aman, kompetitif, dan sesuai dengan kebutuhan
      gaya hidup modern masyarakat Lampung. Kunjungi kantor cabang terdekat atau hubungi marketing kami.</p>
    <a href="https://script.google.com/macros/s/AKfycby46hGvHAm6Zctinn9T1fOJGGM4z7baSBdeRwgXnO5Xe734Ge4Padd_-KAM1Cd-PWl7vA/exec"
      class="btn btn-white">Pembukaan Rekening</a>
  </div>

  <div class="carousel-dots">
    <span class="dot active"></span>
    <span class="dot"></span>
    <span class="dot"></span>
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
            <a href="{{ route('public.tabungan.index') }}" class="tab-product-item active">
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
            <h2>Tabungan Simpel</h2>
            <span class="tab-badge-populer">Populer</span>
          </div>
          <p>Simpanan Pelajar (SimPel) adalah tabungan untuk siswa yang diterbitkan secara nasional oleh
            bank-bank di Indonesia, dengan persyaratan mudah dan sederhana serta fitur yang menarik,
            dalam rangka edukasi dan inklusi keuangan untuk mendorong budaya menabung sejak dini.</p>

          <div class="tab-info-grid">
            <div class="tab-info-box">
              <h6>⚙️ Keunggulan</h6>
              <ul>
                <li><span class="li-ic">✓</span> Setoran awal sangat ringan mulai dari Rp
                  5.000,-</li>
                <li><span class="li-ic">✓</span> Bebas biaya administrasi bulanan</li>
                <li><span class="li-ic">✓</span> Nama anak tercetak pada buku tabungan</li>
              </ul>
            </div>
            <div class="tab-info-box">
              <h6>📋 Persyaratan</h6>
              <ul>
                <li><span class="li-ic">→</span> Kartu Identitas Anak (KIA) / Kartu Keluarga</li>
                <li><span class="li-ic">→</span> Kartu Identitas Orang Tua / Wali</li>
                <li><span class="li-ic">→</span> Surat Kuasa dari Orang Tua (jika melalui
                  sekolah)</li>
              </ul>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
</section>

@endsection
