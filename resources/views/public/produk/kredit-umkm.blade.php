@extends('layouts.public')

@section('title', 'Bank Waway Lampung - Kredit UMKM')

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

  .ku-section-title {
    font-size: 20px;
    font-weight: 800;
    color: var(--navy);
    margin: 4px 0 18px;
  }

  .ku-fasilitas-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 20px;
    margin-bottom: 8px;
  }

  .ku-fasilitas-card {
    background: #fff;
    border: 1px solid var(--border);
    border-radius: var(--radius);
    padding: 26px 24px;
  }

  .ku-fasilitas-ic {
    width: 42px;
    height: 42px;
    border-radius: 10px;
    background: #eef2ff;
    color: var(--blue);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 19px;
    font-weight: 800;
    margin-bottom: 16px;
  }

  .ku-fasilitas-card h3 {
    font-size: 15.5px;
    font-weight: 800;
    color: var(--navy);
    margin-bottom: 10px;
  }

  .ku-fasilitas-card>p {
    font-size: 13px;
    color: var(--text-muted);
    line-height: 1.6;
    margin-bottom: 18px;
  }

  .ku-fasilitas-val {
    font-size: 18px;
    font-weight: 800;
    color: var(--navy);
    line-height: 1.3;
  }

  .ku-fasilitas-note {
    font-size: 11px;
    color: var(--text-muted);
    margin-top: 4px;
  }

  .ku-bunga-table {
    display: flex;
    flex-direction: column;
    gap: 2px;
  }

  .ku-bunga-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px 0;
    border-top: 1px solid var(--border);
    font-size: 13.5px;
  }

  .ku-bunga-row:first-child {
    border-top: none;
  }

  .ku-bunga-row span:first-child {
    color: var(--text-muted);
    font-weight: 600;
  }

  .ku-bunga-row span:last-child {
    color: var(--navy);
    font-weight: 800;
  }

  .ku-req-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
    align-items: start;
    margin-bottom: 8px;
  }

  .ku-req-card {
    background: #fff;
    border: 1px solid var(--border);
    border-radius: var(--radius);
    padding: 26px 26px 30px;
    display: flex;
    flex-direction: column;
    height: 100%;
  }

  .ku-req-head {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 20px;
  }

  .ku-req-head .ic {
    font-size: 18px;
    color: var(--blue);
  }

  .ku-req-head h3 {
    font-size: 16.5px;
    font-weight: 800;
    color: var(--navy);
  }

  .ku-check-list {
    list-style: none;
    display: flex;
    flex-direction: column;
    gap: 16px;
    margin-bottom: 20px;
  }

  .ku-check-list li {
    display: flex;
    align-items: flex-start;
    gap: 10px;
    font-size: 13.5px;
    color: var(--text);
    line-height: 1.55;
  }

  .ku-check-list .li-ic {
    color: #16a34a;
    font-size: 15px;
    flex: none;
    margin-top: 1px;
  }

  .ku-req-fill {
    flex: 1;
    min-height: 130px;
    border: 1.5px dashed var(--border);
    border-radius: 10px;
    display: flex;
    align-items: flex-end;
    justify-content: center;
    padding: 14px;
  }

  .ku-req-fill p {
    font-size: 12px;
    color: var(--text-muted);
    text-align: center;
    font-style: italic;
  }

  .ku-doc-list {
    list-style: none;
    display: flex;
    flex-direction: column;
    gap: 6px;
    margin-bottom: 22px;
  }

  .ku-doc-list li {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
    padding: 13px 4px;
    border-top: 1px solid var(--border);
    font-size: 13.5px;
    color: var(--text);
    font-weight: 600;
  }

  .ku-doc-list li:first-child {
    border-top: none;
  }

  .ku-doc-list .ku-doc-left {
    display: flex;
    align-items: center;
    gap: 10px;
  }

  .ku-doc-list .li-ic {
    font-size: 15px;
  }

  .ku-doc-plus {
    width: 22px;
    height: 22px;
    border-radius: 50%;
    background: #eef2ff;
    color: var(--blue);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 13px;
    font-weight: 800;
    flex: none;
  }

  .ku-quote {
    margin-top: auto;
    font-size: 13px;
    font-style: italic;
    color: var(--text-muted);
    line-height: 1.65;
    border-top: 1px solid var(--border);
    padding-top: 18px;
  }

  @media(max-width: 900px) {
    .ku-fasilitas-grid {
      grid-template-columns: 1fr;
    }

    .ku-req-grid {
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
    <strong>Kredit UMKM</strong>
  </div>
</div>

<section class="hero">
  <img class="hero-bg" src="{{ asset('frontend/images/kredit-umkm.jpg') }}" alt="Kredit UMKM">
  <div class="container">
    <h1>Kredit Komersil</h1>
    <p>Mendukung percepatan pertumbuhan bisnis Anda dengan solusi pembiayaan terintegrasi. Kami menyediakan modal
      kerja dan investasi untuk skala menengah hingga besar dengan proses yang akuntabel.</p>
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
        <li><a class="tab-product-item" href="{{ route('public.kredit.kredit-komersil') }}"><span class="ic">💳</span> Kredit Modal
            Kerja</a></li>
        <li><a class="tab-product-item" href="{{ route('public.kredit.kredit-multiguna') }}"><span class="ic">🏛</span> Kredit
            Multiguna</a></li>
        <li><a class="tab-product-item" href="{{ route('public.kredit.kredit-pdrs') }}"><span class="ic">📈</span> Kredit PDRS</a>
        </li>
        <li><a class="tab-product-item" href="{{ route('public.kredit.kredit-subsidi') }}"><span class="ic">🪪</span> Kredit Subsidi
            0%</a></li>
        <li>
          <button class="tab-product-item active" data-target="umkm"><span class="ic">🌐</span> Kredit
            UMKM</button>
        </li>
      </ul>
      <div class="tab-help-card">
        <h5>🎧 Butuh Bantuan?</h5>
        <p>Tim kami siap membantu Anda memilih produk kredit yang tepat.</p>
        <a href="https://api.whatsapp.com/send/?phone=6285382659996&text&type=phone_number&app_absent=0"
          target="_blank" rel="noopener" class="btn-tel">Hubungi CS</a>
      </div>
    </aside>

    <div class="tab-content">

      <div class="tab-panel active" id="panel-umkm">

        <div class="tab-detail-card">
          <div class="tab-detail-top">
            <h2>Kredit UMKM Siger</h2>
          </div>
          <p>Fasilitas kredit modal kerja dan investasi bagi pelaku usaha kecil atau perorangan dengan usaha
            produktif yang sudah berjalan minimal 1 tahun. Kami hadir sebagai mitra strategis pertumbuhan bisnis
            Anda.</p>
        </div>

        <h3 class="ku-section-title">Detail Fasilitas Kredit</h3>
        <div class="ku-fasilitas-grid">
          <div class="ku-fasilitas-card">
            <div class="ku-fasilitas-ic">Rp</div>
            <h3>Plafon Pinjaman</h3>
            <p>Fleksibilitas pendanaan sesuai kebutuhan ekspansi usaha Anda.</p>
            <div class="ku-fasilitas-val">5jt s/d BMPK*</div>
            <div class="ku-fasilitas-note">*Batas Maksimum Pemberian Kredit</div>
          </div>

          <div class="ku-fasilitas-card">
            <div class="ku-fasilitas-ic">📅</div>
            <h3>Jangka Waktu</h3>
            <p>Tenor cicilan yang ringan untuk menjaga arus kas tetap sehat.</p>
            <div class="ku-fasilitas-val">6 Bulan s/d 5 Tahun</div>
          </div>

          <div class="ku-fasilitas-card">
            <div class="ku-fasilitas-ic">%</div>
            <h3>Suku Bunga Flat</h3>
            <div class="ku-bunga-table">
              <div class="ku-bunga-row"><span>JW s/d 2 Thn</span><span>10.0%</span></div>
              <div class="ku-bunga-row"><span>JW 2 - 4 Thn</span><span>11.0%</span></div>
              <div class="ku-bunga-row"><span>JW 4 - 5 Thn</span><span>12.0%</span></div>
            </div>
          </div>
        </div>

        <div class="ku-req-grid">
          <div class="ku-req-card">
            <div class="ku-req-head"><span class="ic">🧑‍💼</span>
              <h3>Persyaratan Umum</h3>
            </div>
            <ul class="ku-check-list">
              <li><span class="li-ic">✔️</span> Perorangan (WNI) atau Badan Usaha yang telah memiliki izin usaha.</li>
              <li><span class="li-ic">✔️</span> Usaha produktif yang telah berjalan minimal 1 (satu) tahun secara kontinyu.</li>
              <li><span class="li-ic">✔️</span> Memiliki rekam jejak kredit yang baik (SLIK OJK).</li>
              <li><span class="li-ic">✔️</span> Melampirkan agunan berupa SHM atau SHGB.</li>
            </ul>
            <div class="ku-req-fill">
              <p>Pastikan semua dokumen asli tersedia saat verifikasi.</p>
            </div>
          </div>

          <div class="ku-req-card">
            <div class="ku-req-head"><span class="ic">📄</span>
              <h3>Dokumen Pelengkap</h3>
            </div>
            <ul class="ku-doc-list">
              <li><span class="ku-doc-left"><span class="li-ic">📝</span> Formulir Aplikasi Kredit</span><span class="ku-doc-plus">+</span></li>
              <li><span class="ku-doc-left"><span class="li-ic">🪪</span> KTP & Kartu Keluarga (KK)</span><span class="ku-doc-plus">+</span></li>
              <li><span class="ku-doc-left"><span class="li-ic">🏢</span> NIB & NPWP</span><span class="ku-doc-plus">+</span></li>
              <li><span class="ku-doc-left"><span class="li-ic">📃</span> Rekening Koran (6 Bulan Terakhir)</span><span class="ku-doc-plus">+</span></li>
              <li><span class="ku-doc-left"><span class="li-ic">📊</span> Laporan Keuangan Usaha</span><span class="ku-doc-plus">+</span></li>
              <li><span class="ku-doc-left"><span class="li-ic">🏠</span> Sertifikat Jaminan (SHM/SHGB)</span><span class="ku-doc-plus">+</span></li>
            </ul>
            <div class="ku-quote">"Bank Waway Lampung berkomitmen memberikan kemudahan proses administrasi demi
              percepatan pertumbuhan UMKM di Lampung."</div>
          </div>
        </div>

        <div class="cta-banner">
          <div>
            <h2>Siap Mengembangkan Usaha Anda?</h2>
            <p>Dapatkan konsultasi gratis mengenai plafon kredit dan skema angsuran terbaik untuk profil bisnis
              Anda.</p>
          </div>
          <div class="cta-actions">
            <a href="https://api.whatsapp.com/send/?phone=6285382659996&text&type=phone_number&app_absent=0"
              target="_blank" rel="noopener" class="btn btn-primary">Hubungi Account Officer</a>
          </div>
        </div>

      </div>

    </div>
  </div>
</section>

@endsection
