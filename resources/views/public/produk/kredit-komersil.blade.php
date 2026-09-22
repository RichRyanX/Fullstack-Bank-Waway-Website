@extends('layouts.public')

@section('title', 'Bank Waway Lampung - Kredit Komersil')

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
</style>
@endsection

@section('content')

<div class="breadcrumb-row">
  <div class="container">
    <a href="{{ route('home') }}">Beranda</a> <span class="sep">›</span>
    <a href="{{ route('public.kredit.pinjaman') }}">Produk</a> <span class="sep">›</span>
    <a href="{{ route('public.kredit.pinjaman') }}">Pinjaman</a> <span class="sep">›</span>
    <strong>Kredit Komersil</strong>
  </div>
</div>

<section class="hero">
  <img class="hero-bg" src="{{ asset('frontend/images/kredit-komersil.jpg') }}" alt="Kredit Komersil">
  <div class="container">
    <h1>Kredit Komersil</h1>
    <p>Mendukung percepatan pertumbuhan bisnis Anda dengan solusi pembiayaan terintegrasi. Kami menyediakan modal
      kerja dan investasi untuk skala menengah hingga besar dengan proses yang akuntabel.</p>
    <div class="hero-actions">
      <a href="https://api.whatsapp.com/send/?phone=6285382659996&text&type=phone_number&app_absent=0" target="_blank"
        rel="noopener" class="btn btn-primary">Ajukan Sekarang</a>
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
          <button class="tab-product-item active" data-target="modal-kerja"><span class="ic">💳</span> Kredit Modal
            Kerja</button>
        </li>
        <li>
          <a class="tab-product-item" href="{{ route('public.kredit.kredit-multiguna') }}"><span class="ic">🏛</span> Kredit Multiguna</a>
        </li>
        <li>
          <a class="tab-product-item" href="{{ route('public.kredit.kredit-pdrs') }}"><span class="ic">📈</span> Kredit PDRS</a>
        </li>
        <li>
          <a class="tab-product-item" href="{{ route('public.kredit.kredit-subsidi') }}"><span class="ic">🪪</span> Kredit Subsidi 0%</a>
        </li>
        <li>
          <a class="tab-product-item" href="{{ route('public.kredit.kredit-umkm') }}"><span class="ic">🌐</span> Kredit UMKM</a>
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

      <div class="tab-panel active" id="panel-modal-kerja">

        <div class="tab-detail-card">
          <div class="tab-detail-top">
            <h2>Kredit Modal Kerja</h2>
          </div>
          <p>Kredit Modal Kerja – Linkage Program merupakan fasilitas pinjaman yang diberikan kepada lembaga keuangan
            baik Bank maupun Non Bank dengan menggunakan 3 (tiga) pola pembiayaan utama yang fleksibel dan terukur:
          </p>
        </div>

        <div class="tt-benefit-row">
          <div class="tt-benefit-card-lg">
            <div class="tt-benefit-lg-ic">☑️</div>
            <h4>Executing</h4>
            <p>Penyaluran dana melalui mitra strategis.</p>
          </div>
          <div class="tt-benefit-card-lg">
            <div class="tt-benefit-lg-ic">🔀</div>
            <h4>Channeling</h4>
            <p>Penyaluran langsung ke end-user mitra.</p>
          </div>
          <div class="tt-benefit-card-lg">
            <div class="tt-benefit-lg-ic">🤝</div>
            <h4>Joint Financing</h4>
            <p>Pembiayaan bersama secara kolaboratif.</p>
          </div>
        </div>

        <div>
          <div class="sifat-title-row"><span class="bar"></span>
            <h3>Sifat Kredit</h3>
          </div>
          <div class="sifat-grid">
            <div class="sifat-card">
              <h4><span class="dot"></span> Non-Revolving</h4>
              <p>Pinjaman ditarik sekaligus pada saat pencairan dan pengembalian pinjaman dengan cara mengangsur pokok
                dan bunga setiap bulan sampai dengan pinjaman lunas secara bertahap.</p>
            </div>
            <div class="sifat-card">
              <h4><span class="dot"></span> Revolving</h4>
              <p>Penarikan dan pengembalian pinjaman dapat dilakukan setiap saat selama fasilitas belum jatuh tempo.
                Angsuran bunga dibayar setiap bulan sesuai jumlah penarikan yang digunakan.</p>
            </div>
          </div>
        </div>

        <div class="ketentuan-card">
          <div class="ketentuan-head">⚖️ Ketentuan Umum</div>
          <div class="ketentuan-list">
            <div class="ketentuan-row"><span>Plafon Pinjaman</span><span>Rp 5.000.000 s/d Batas Maksimum Pemberian
                Kredit (BMPK)</span></div>
            <div class="ketentuan-row"><span>Jangka Waktu</span><span>Maksimal 12 bulan (Dapat diperpanjang)</span>
            </div>
            <div class="ketentuan-row"><span>Jenis Agunan</span><span>SHM (Sertifikat Hak Milik) atau SHGB (Sertifikat
                Hak Guna Bangunan)</span></div>
            <div class="ketentuan-row"><span>Suku Bunga</span><span>15% - 18% p.a (kompetitif)</span></div>
            <div class="ketentuan-row"><span>Metode Perhitungan Bunga</span><span>Efektif / Anuitas</span></div>
            <div class="ketentuan-row"><span>Biaya-Biaya Lain</span><span>Provisi, Administrasi, Biaya Notaris,
                Materai, dan Premi Asuransi</span></div>
          </div>
        </div>

        <div class="persyaratan-head">
          <h2>Persyaratan Pengajuan</h2>
        </div>
        <div class="tp-grid-bottom">
          <div class="tp-info-card">
            <div class="tp-info-head">
              <div class="tp-info-ic">👥</div>
              <h3>Kriteria Debitur</h3>
            </div>
            <ul class="tp-check-list">
              <li><span class="li-ic">✔️</span>
                <div><strong>Perorangan</strong><br><span>WNI, usia min. 21 tahun atau sudah menikah, cakap
                    hukum.</span></div>
              </li>
              <li><span class="li-ic">✔️</span>
                <div><strong>Badan Hukum / Usaha</strong><br><span>Berdomisili di wilayah operasional Bank Waway
                    Lampung.</span></div>
              </li>
              <li><span class="li-ic">✔️</span>
                <div><strong>Pengalaman Bisnis</strong><br><span>Memiliki usaha aktif minimal selama 2 tahun
                    terakhir.</span></div>
              </li>
            </ul>
          </div>
          <div class="tp-info-card">
            <div class="tp-info-head">
              <div class="tp-info-ic">📄</div>
              <h3>Persyaratan Dokumen</h3>
            </div>
            <ul class="tp-check-list">
              <li><span class="li-ic">🪪</span> Identitas Diri (KTP, KK, NPWP)</li>
              <li><span class="li-ic">🏢</span> NIB (Nomor Induk Berusaha) / IUMK</li>
              <li><span class="li-ic">📊</span> Laporan Keuangan (6-12 bulan terakhir)</li>
              <li><span class="li-ic">🏠</span> Fotokopi Dokumen Agunan (SHM/SHGB)</li>
              <li><span class="li-ic">📃</span> Rekening Koran 3 bulan terakhir</li>
            </ul>
          </div>
        </div>

        <div class="cta-banner">
          <div>
            <h2>Siap Mengembangkan Bisnis Anda?</h2>
            <p>Dapatkan konsultasi gratis dengan manajer akun kami untuk menemukan solusi pembiayaan yang paling tepat
              untuk skala bisnis Anda.</p>
          </div>
          <div class="cta-actions">
            <a href="https://api.whatsapp.com/send/?phone=6285382659996&text&type=phone_number&app_absent=0"
              target="_blank" rel="noopener" class="btn btn-primary">Hubungi Kami Sekarang</a>
          </div>
        </div>

      </div>

    </div>
  </div>
</section>

@endsection

@section('scripts')
<script>
  document.addEventListener('DOMContentLoaded', function () {
    var items = document.querySelectorAll('.tab-product-item[data-target]');
    var panels = document.querySelectorAll('.tab-panel');

    items.forEach(function (btn) {
      btn.addEventListener('click', function () {
        var target = btn.getAttribute('data-target');

        document.querySelectorAll('.tab-product-item').forEach(function (b) { b.classList.remove('active'); });
        btn.classList.add('active');

        panels.forEach(function (p) { p.classList.remove('active'); });
        var panel = document.getElementById('panel-' + target);
        if (panel) panel.classList.add('active');

        document.getElementById('detail').scrollIntoView({ behavior: 'smooth', block: 'start' });
      });
    });
  });
</script>
@endsection
