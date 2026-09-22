@extends('layouts.public')

@section('title', 'Bank Waway Lampung - Kredit PDRS')

@section('styles')
<style>
  .tab-panel {
    display: none;
  }

  .tab-panel.active {
    display: flex;
    flex-direction: column;
    gap: 30px;
  }

  .pdrs-section-title {
    font-size: 22px;
    font-weight: 800;
    color: var(--navy);
    letter-spacing: -.3px;
  }

  .pdrs-fasilitas-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
    margin-top: 18px;
  }

  .pdrs-fasilitas-card {
    background: #fff;
    border: 1px solid var(--border);
    border-radius: var(--radius);
    padding: 28px 26px;
  }

  .pdrs-fasilitas-head {
    display: flex;
    align-items: center;
    gap: 14px;
    margin-bottom: 22px;
  }

  .pdrs-fasilitas-ic {
    width: 42px;
    height: 42px;
    border-radius: 10px;
    background: var(--blue);
    color: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
    flex: none;
  }

  .pdrs-fasilitas-head h4 {
    font-size: 17px;
    font-weight: 800;
    color: var(--navy);
    margin-bottom: 3px;
  }

  .pdrs-fasilitas-head span {
    font-size: 12.5px;
    color: var(--text-muted);
  }

  .pdrs-fasilitas-list {
    list-style: none;
    display: flex;
    flex-direction: column;
    gap: 16px;
  }

  .pdrs-fasilitas-list li {
    display: flex;
    align-items: flex-start;
    gap: 10px;
    font-size: 13.5px;
    color: var(--text);
    line-height: 1.6;
  }

  .pdrs-fasilitas-list li .ic {
    flex: none;
    color: var(--blue);
    font-size: 14px;
    margin-top: 1px;
  }

  .pdrs-ket-row-3 {
    display: grid;
    grid-template-columns: 1fr 1fr 1fr;
    gap: 18px;
    margin-top: 18px;
  }

  .pdrs-ket-row-2 {
    display: grid;
    grid-template-columns: 1fr 2fr;
    gap: 18px;
    margin-top: 18px;
  }

  .pdrs-ket-card {
    background: var(--bg-soft);
    border-radius: var(--radius);
    padding: 22px 24px;
  }

  .pdrs-ket-lbl {
    font-size: 11px;
    font-weight: 700;
    letter-spacing: .5px;
    text-transform: uppercase;
    color: var(--blue);
    margin-bottom: 10px;
  }

  .pdrs-ket-val {
    font-size: 19px;
    font-weight: 800;
    color: var(--navy);
    margin-bottom: 8px;
  }

  .pdrs-ket-desc {
    font-size: 12.5px;
    color: var(--text-muted);
    line-height: 1.55;
  }

  .pdrs-ket-agunan-val {
    display: flex;
    align-items: center;
    gap: 8px;
  }

  .pdrs-ket-competitive {
    background: var(--navy);
    border-radius: var(--radius);
    padding: 22px 26px;
    display: flex;
    align-items: center;
    gap: 20px;
    color: #fff;
  }

  .pdrs-ket-competitive .ic-box {
    width: 46px;
    height: 46px;
    border-radius: 10px;
    background: rgba(255, 255, 255, .15);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    flex: none;
  }

  .pdrs-ket-competitive h4 {
    font-size: 15.5px;
    font-weight: 700;
    margin-bottom: 5px;
  }

  .pdrs-ket-competitive p {
    font-size: 13px;
    color: #c7d3ef;
  }

  .pdrs-ket-competitive .side-ic {
    margin-left: auto;
    font-size: 22px;
    color: rgba(255, 255, 255, .5);
  }

  .pdrs-doc-wrap {
    background: var(--bg-soft);
    border-radius: var(--radius);
    padding: 30px 32px;
  }

  .pdrs-doc-wrap>h3 {
    font-size: 19px;
    font-weight: 800;
    color: var(--navy);
    margin-bottom: 22px;
  }

  .pdrs-doc-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 26px;
  }

  .pdrs-doc-col-lbl {
    font-size: 11px;
    font-weight: 700;
    letter-spacing: .5px;
    text-transform: uppercase;
    color: var(--blue);
    margin-bottom: 14px;
  }

  .pdrs-doc-item {
    display: flex;
    align-items: center;
    gap: 12px;
    background: #fff;
    border: 1px solid var(--border);
    border-radius: 10px;
    padding: 14px 16px;
    margin-bottom: 12px;
    font-size: 13.5px;
    color: var(--text);
  }

  .pdrs-doc-item .ic {
    color: var(--blue);
    font-size: 15px;
    flex: none;
  }

  .pdrs-cta-banner {
    background: linear-gradient(120deg, var(--navy) 0%, var(--blue-dark) 100%);
    border-radius: 20px;
    padding: 46px 40px;
    color: #fff;
    text-align: center;
  }

  .pdrs-cta-banner h2 {
    font-size: 24px;
    font-weight: 800;
    margin-bottom: 14px;
  }

  .pdrs-cta-banner p {
    color: #c7d3ef;
    font-size: 14.5px;
    max-width: 560px;
    margin: 0 auto 26px;
    line-height: 1.7;
  }

  .pdrs-cta-actions {
    display: flex;
    justify-content: center;
    gap: 16px;
    flex-wrap: wrap;
  }

  @media(max-width: 900px) {
    .pdrs-fasilitas-grid {
      grid-template-columns: 1fr;
    }

    .pdrs-ket-row-3 {
      grid-template-columns: 1fr 1fr;
    }

    .pdrs-ket-row-2 {
      grid-template-columns: 1fr;
    }

    .pdrs-doc-grid {
      grid-template-columns: 1fr;
    }
  }

  @media(max-width: 560px) {
    .pdrs-ket-row-3 {
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
        <li>
          <button class="tab-product-item active" data-target="pdrs"><span class="ic">📈</span> Kredit
            PDRS</button>
        </li>
        <li><a class="tab-product-item" href="{{ route('public.kredit.kredit-subsidi') }}"><span class="ic">🪪</span> Kredit Subsidi
            0%</a></li>
        <li><a class="tab-product-item" href="{{ route('public.kredit.kredit-umkm') }}"><span class="ic">🌐</span> Kredit UMKM</a>
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

      <div class="tab-panel active" id="panel-pdrs">

        <div class="tab-detail-card">
          <div class="tab-detail-top">
            <h2>Kredit PDRS (Revolving & Non-Revolving)</h2>
          </div>
          <p>Solusi modal kerja khusus untuk membiayai inventory, piutang, atau proyek dengan pemakaian dana
            fleksibel sesuai kebutuhan harian bisnis Anda.</p>
        </div>

        <div>
          <h3 class="pdrs-section-title">Pilihan Fasilitas PDRS</h3>
          <div class="pdrs-fasilitas-grid">
            <div class="pdrs-fasilitas-card">
              <div class="pdrs-fasilitas-head">
                <div class="pdrs-fasilitas-ic">🔄</div>
                <div>
                  <h4>Revolving (Kode 38)</h4>
                  <span>Fasilitas Berulang</span>
                </div>
              </div>
              <ul class="pdrs-fasilitas-list">
                <li><span class="ic">✅</span> Bunga hanya dihitung dari dana yang digunakan (outstanding).</li>
                <li><span class="ic">✅</span> Pelunasan fleksibel sesuai arus kas bisnis harian.</li>
                <li><span class="ic">✅</span> Plafon otomatis kembali bertambah (revolving) setelah pelunasan dilakukan.</li>
              </ul>
            </div>
            <div class="pdrs-fasilitas-card">
              <div class="pdrs-fasilitas-head">
                <div class="pdrs-fasilitas-ic">➡️</div>
                <div>
                  <h4>Non-Revolving (Kode 38A)</h4>
                  <span>Fasilitas Sekali Pakai</span>
                </div>
              </div>
              <ul class="pdrs-fasilitas-list">
                <li><span class="ic">✅</span> Bunga hanya dihitung dari dana yang ditarik.</li>
                <li><span class="ic">✅</span> Sangat tepat untuk pembiayaan proyek dengan jangka waktu tertentu.</li>
                <li><span class="ic">✅</span> Plafon yang sudah dibayar tidak dapat digunakan kembali secara otomatis.</li>
              </ul>
            </div>
          </div>
        </div>

        <div>
          <h3 class="pdrs-section-title">Ketentuan Utama</h3>

          <div class="pdrs-ket-row-3">
            <div class="pdrs-ket-card">
              <div class="pdrs-ket-lbl">Plafon Kredit</div>
              <div class="pdrs-ket-val">Rp 5 Juta s/d BMPK</div>
              <div class="pdrs-ket-desc">Batas Maksimum Pemberian Kredit disesuaikan dengan kapasitas bisnis.</div>
            </div>
            <div class="pdrs-ket-card">
              <div class="pdrs-ket-lbl">Jangka Waktu</div>
              <div class="pdrs-ket-val">12 Bulan</div>
              <div class="pdrs-ket-desc">Dapat diperpanjang sesuai evaluasi tahunan.</div>
            </div>
            <div class="pdrs-ket-card">
              <div class="pdrs-ket-lbl">Suku Bunga</div>
              <div class="pdrs-ket-val">15% - 18%</div>
              <div class="pdrs-ket-desc">Efektif per tahun.</div>
            </div>
          </div>

          <div class="pdrs-ket-row-2">
            <div class="pdrs-ket-card">
              <div class="pdrs-ket-lbl">Agunan</div>
              <div class="pdrs-ket-val pdrs-ket-agunan-val">🏠 SHM / SHGB</div>
              <div class="pdrs-ket-desc">Sertifikat Hak Milik atau Guna Bangunan yang sah.</div>
            </div>

            <div class="pdrs-ket-competitive">
              <div class="ic-box">⚙️</div>
              <div>
                <h4>Suku Bunga Kompetitif</h4>
                <p>Perhitungan bunga harian yang transparan dan bersaing.</p>
              </div>
              <div class="side-ic">💳</div>
            </div>
          </div>
        </div>

        <div class="pdrs-doc-wrap">
          <h3>Persyaratan Dokumen</h3>
          <div class="pdrs-doc-grid">
            <div>
              <div class="pdrs-doc-col-lbl">Identitas Legalitas Bisnis</div>
              <div class="pdrs-doc-item"><span class="ic">📄</span> Nomor Induk Berusaha (NIB) / SIUP & TDP</div>
              <div class="pdrs-doc-item"><span class="ic">🪪</span> NPWP Perusahaan & Pengurus
              </div>
              <div class="pdrs-doc-item"><span class="ic">📋</span> Akta Pendirian & Perubahan Terakhir</div>
            </div>
            <div>
              <div class="pdrs-doc-col-lbl">Dokumen Finansial</div>
              <div class="pdrs-doc-item"><span class="ic">📊</span> Laporan Keuangan (Minimal 2 Tahun Terakhir)</div>
              <div class="pdrs-doc-item"><span class="ic">📃</span> Rekening Koran (Minimal 6 Bulan Terakhir)</div>
              <div class="pdrs-doc-item"><span class="ic">📝</span> Legalitas Agunan (SHM/SHGB/IMB/PBB)</div>
            </div>
          </div>
        </div>

        <div class="pdrs-cta-banner">
          <h2>Siap Mengembangkan Bisnis Anda?</h2>
          <p>Hubungi Account Officer kami untuk mendapatkan penawaran struktur kredit yang paling sesuai dengan
            siklus bisnis Anda.</p>
          <div class="pdrs-cta-actions">
            <a href="https://api.whatsapp.com/send/?phone=6285382659996&text&type=phone_number&app_absent=0"
              target="_blank" rel="noopener" class="btn btn-primary">📞 Hubungi Account Officer</a>
            <a href="{{ route('public.profil.tempat-kedudukan') }}" class="btn btn-outline-white">🏢 Cari Kantor Cabang</a>
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
