@extends('layouts.public')

@section('title', 'Bank Waway Lampung - Tentang Kami')

@section('content')

<section class="page-hero">
  <img class="page-hero-bg" src="{{ asset('admin/images/Bangunan.png') }}" alt="Kantor Pusat Bank Waway Lampung">
  <div class="container">
    <h1>Tentang Kami</h1>
    <div class="breadcrumb"><a href="{{ route('home') }}">Beranda</a> / Profil Perusahaan</div>
  </div>
</section>

<section class="section">
  <div class="container profil-wrap">

    <aside class="profil-sidebar">
      <h4>Profil</h4>
      <ul class="profil-side-menu">
        <li><a href="{{ route('public.profil.index') }}#pendirian" class="active">🕘 Pendirian Perusahaan</a></li>
        <li><a href="{{ route('public.profil.tempat-kedudukan') }}">📍 Tempat Kedudukan</a></li>
        <li><a href="{{ route('public.profil.maksud-tujuan') }}">📋 Maksud dan Tujuan Serta Kegiatan Usaha</a></li>
        <li><a href="{{ route('public.profil.perijinan-legalitas') }}">✅ Perijinan dan Legalitas Usaha</a></li>
        <li><a href="{{ route('public.layanan.modal') }}">💳 Modal</a></li>
        <li><a href="{{ route('public.profil.susunan-pengurus') }}">👥 Susunan Pengurus</a></li>
        <li><a href="{{ route('public.profil.visi-misi') }}">👁️ Visi & Misi</a></li>
        <li><a href="{{ route('public.profil.prestasi-penghargaan') }}">🏆 Prestasi dan Penghargaan</a></li>
        <li><a href="{{ route('public.profil.susunan-pengurus') }}">👤 Pengurus</a></li>
        <li><a href="{{ route('public.profil.index') }}">⬇ Download Company Profile</a></li>
      </ul>
      <div class="pdf-download">
        <div>
          <strong>Dokumen Perusahaan</strong>
          <span>Profil lengkap dalam PDF</span>
        </div>
        <a href="{{ route('public.profil.index') }}" class="btn btn-white">⬇ PDF</a>
      </div>
    </aside>

    <div class="profil-main">

      <div class="profil-card" id="pendirian">
        <div class="section-title-row"><span class="bar"></span>
          <h3>Pendirian Perusahaan</h3>
        </div>
        <div class="pendirian-grid">
          <div class="pendirian-text">
            <p>Bank Waway Lampung didirikan berdasarkan visi untuk memperkuat ekonomi daerah melalui layanan perbankan
              yang terpercaya dan inklusif. Sebagai lembaga keuangan yang berakar di bumi Lampung, kami berkomitmen
              untuk menjadi mitra strategis bagi pertumbuhan UMKM dan pembangunan daerah.</p>
            <p>Melalui perjalanan panjang yang penuh integritas, Bank Waway Lampung telah bertransformasi menjadi
              institusi finansial yang modern namun tetap mempertahankan nilai-nilai kearifan lokal yang menjadi
              landasan operasional kami sehari-hari.</p>
          </div>
          <div class="pendirian-images">
            <img src="{{ asset('frontend/images/pendirian-lama.jpg') }}" alt="Kantor Bank Waway - masa awal">
            <img src="{{ asset('frontend/images/pendirian-modern.jpg') }}" alt="Kantor Bank Waway - saat ini">
          </div>
        </div>
      </div>

      <div class="visi-misi-grid" id="visimisi">
        <div class="visi-card">
          <div class="icon">💡</div>
          <h4>Visi Kami</h4>
          <p>"Menjadi Bank pilihan utama masyarakat Lampung yang sehat, kuat, dan terpercaya melalui pelayanan prima
            yang berbasis teknologi digital."</p>
        </div>
        <div class="misi-card">
          <h4>Misi Kami</h4>
          <div class="misi-list">
            <div class="misi-item">
              <span class="misi-num">1</span>
              <p>Meningkatkan kesejahteraan masyarakat Lampung melalui pemberdayaan sektor UMKM.</p>
            </div>
            <div class="misi-item">
              <span class="misi-num">2</span>
              <p>Memberikan layanan perbankan yang cepat, mudah, dan aman bagi seluruh lapisan masyarakat.</p>
            </div>
            <div class="misi-item">
              <span class="misi-num">3</span>
              <p>Menciptakan nilai tambah bagi seluruh pemangku kepentingan melalui tata kelola yang baik.</p>
            </div>
            <div class="misi-item">
              <span class="misi-num">4</span>
              <p>Terus berinovasi dalam teknologi digital untuk mempermudah transaksi keuangan.</p>
            </div>
          </div>
        </div>
      </div>

      <div class="profil-card maksud-section" id="maksud">
        <h2 class="section-title" style="font-size:24px">Maksud & Tujuan</h2>
        <p class="section-sub">Nilai-nilai inti yang menggerakkan setiap keputusan dan langkah strategis kami.</p>
        <div class="maksud-grid">
          <div class="maksud-item">
            <div class="ic ic-navy">🤝</div>
            <h5>Integritas</h5>
            <p>Bertindak jujur dan konsisten sesuai prinsip etika bisnis yang tinggi.</p>
          </div>
          <div class="maksud-item">
            <div class="ic ic-blue">🎯</div>
            <h5>Profesional</h5>
            <p>Memberikan kompetensi terbaik dalam setiap layanan perbankan.</p>
          </div>
          <div class="maksud-item">
            <div class="ic ic-navy">👥</div>
            <h5>Sinergi</h5>
            <p>Bekerja sama secara harmonis untuk mencapai tujuan bersama daerah.</p>
          </div>
          <div class="maksud-item">
            <div class="ic ic-blue">💡</div>
            <h5>Inovasi</h5>
            <p>Terus berkembang menyesuaikan diri dengan kemajuan teknologi modern.</p>
          </div>
        </div>
      </div>

      <div class="legal-modal-grid">
        <div class="profil-card" id="perijinan">
          <div class="section-title-row"><span class="bar"></span>
            <h3>Aspek Legalitas</h3>
          </div>
          <div class="legal-row"><span>Izin Usaha OJK</span><span>KEP-45/D.03/2021</span></div>
          <div class="legal-row"><span>Status Perusahaan</span><span>PT. BPR Waway Lampung</span></div>
          <div class="legal-row"><span>Kepatuhan</span><span class="badge-ok">✓ Terdaftar & Diawasi</span></div>
        </div>
        <div class="profil-card" id="modal">
          <div class="section-title-row"><span class="bar"></span>
            <h3>Struktur Modal</h3>
          </div>
          <div class="modal-bar-track">
            <div class="modal-bar-fill"></div>
          </div>
          <div class="modal-labels">
            <div>Modal Dasar<strong>Rp 100.000.000.000</strong></div>
            <div style="text-align:right">Modal Disetor<strong>Rp 75.000.000.000</strong></div>
          </div>
        </div>
      </div>

      <div class="prestasi-banner" id="prestasi">
        <h3>Prestasi & Penghargaan</h3>
        <div class="prestasi-grid">
          <div class="prestasi-item">
            <div class="yr">2023</div>
            <p>Golden Trophy BPR Terbaik – Infobank Awards</p>
          </div>
          <div class="prestasi-item">
            <div class="yr">2022</div>
            <p>Peringkat I Kinerja Keuangan Sangat Bagus</p>
          </div>
          <div class="prestasi-item">
            <div class="yr">2021</div>
            <p>BPR Digital Innovation Award</p>
          </div>
        </div>
      </div>

    </div>
  </div>
</section>

@endsection
