@extends('layouts.public')

@section('title', 'Bank Waway Lampung - Pinjaman')

@section('content')

<section class="section hero" style="padding-bottom:0">
  <img class="hero-bg" src="{{ asset('admin/images/Bangunan.png') }}" alt="Bangunan Bank Waway Lampung">
  <div class="hero-overlay"></div>
  <div class="container">
    <span class="eyebrow">Solusi Finansial</span>
    <h1>Wujudkan Impian dan Kembangkan Bisnis Anda Bersama Kami</h1>
    <p>Bank Waway Lampung menghadirkan beragam produk pinjaman yang dirancang khusus untuk memenuhi kebutuhan finansial
      Anda. Mulai dari modal usaha untuk ekspansi bisnis hingga pembiayaan konsumer untuk kebutuhan pribadi yang lebih
      baik, kami hadir sebagai mitra terpercaya dengan proses transparan dan bunga kompetitif.</p>
  </div>
</section>

<section class="section">
  <div class="container grid-2">
    <article class="loan-card">
      <img src="{{ asset('admin/images/Bangunan.png') }}" alt="Kredit Komersil">
      <div class="loan-overlay"></div>
      <div class="loan-content">
        <div class="loan-icon">💼</div>
        <h3>Kredit Komersil</h3>
        <p>Dukungan pembiayaan untuk skala UMKM hingga korporasi besar. Optimalkan arus kas dan perluas jangkauan
          pasar bisnis Anda dengan solusi modal kerja dan investasi.</p>
        <div class="loan-foot">
          <a href="{{ route('public.kredit.kredit-komersil') }}" class="btn btn-white">Lihat Detail →</a>
          <span>Mulai dari bunga 7% p.a*</span>
        </div>
      </div>
    </article>

    <article class="loan-card">
      <img src="{{ asset('admin/images/Bangunan.png') }}" alt="Kredit Konsumer">
      <div class="loan-overlay"></div>
      <div class="loan-content">
        <div class="loan-icon">👨‍👩‍👧</div>
        <h3>Kredit Konsumer</h3>
        <p>Wujudkan kepemilikan hunian, kendaraan, atau kebutuhan lain melalui pembiayaan multiguna untuk pribadi.
          Proses cepat, syarat mudah, dan angsuran ringan.</p>
        <div class="loan-foot">
          <a href="{{ route('public.kredit.kredit-konsumer') }}" class="btn btn-white">Lihat Detail →</a>
        </div>
      </div>
    </article>
  </div>
</section>

<section class="section">
  <div class="container">
    <div class="cta-banner">
      <div>
        <h2>Masih Bingung Memilih Produk yang Tepat?</h2>
        <p>Tim ahli kami siap membantu Anda melakukan simulasi kredit dan memberikan rekomendasi produk terbaik sesuai
          dengan profil finansial Anda.</p>
      </div>
      <div class="cta-actions">
        <a href="https://api.whatsapp.com/send/?phone=6285382659996&text&type=phone_number&app_absent=0"
          target="_blank" rel="noopener" class="btn btn-primary">Konsultasi Gratis</a>
      </div>
    </div>
  </div>
</section>

@endsection
