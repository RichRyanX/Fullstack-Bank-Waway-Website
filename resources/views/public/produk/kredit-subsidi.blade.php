@extends('layouts.public')

@section('title', 'Bank Waway Lampung - Kredit Subsidi 0% (Kredit UMKM Siger)')

@section('styles')
<style>
  .tab-panel {
    display: none;
  }

  .tab-panel.active {
    display: flex;
    flex-direction: column;
    gap: 24px;
  }

  /* ---- Grid statistik atas (2x2 kiri + kartu OPD kanan) ---- */
  .sig-top-grid {
    display: grid;
    grid-template-columns: 1.6fr 1fr;
    gap: 20px;
    align-items: stretch;
  }

  .sig-stat-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
  }

  .sig-stat-card {
    background: #fff;
    border: 1px solid var(--border);
    border-radius: var(--radius);
    padding: 24px 26px;
  }

  .sig-stat-ic {
    width: 36px;
    height: 36px;
    border-radius: 10px;
    background: var(--bg-soft);
    color: var(--blue);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 17px;
    margin-bottom: 20px;
  }

  .sig-stat-lbl {
    font-size: 11.5px;
    font-weight: 700;
    letter-spacing: .4px;
    text-transform: uppercase;
    color: var(--text-muted);
    margin-bottom: 8px;
  }

  .sig-stat-val {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 21px;
    font-weight: 800;
    color: var(--navy);
  }

  .sig-badge {
    flex: none;
    font-size: 11px;
    font-weight: 700;
    color: #c2410c;
    background: #fde3cf;
    padding: 4px 10px;
    border-radius: 999px;
  }

  .sig-opd-card {
    background: var(--bg-soft);
    border: 1px solid var(--border);
    border-radius: var(--radius);
    padding: 26px;
    display: flex;
    flex-direction: column;
  }

  .sig-opd-head {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 15.5px;
    font-weight: 800;
    color: var(--navy);
    margin-bottom: 18px;
  }

  .sig-opd-list {
    list-style: none;
    display: flex;
    flex-direction: column;
    gap: 14px;
  }

  .sig-opd-list li {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 13.5px;
    color: var(--text);
  }

  .sig-opd-list li .ic {
    color: var(--blue);
    font-size: 13px;
    flex: none;
  }

  /* ---- Kriteria Pemohon & Dokumen Persyaratan ---- */
  .sig-mid-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
  }

  .sig-kriteria-card {
    background: #fff;
    border: 1px solid var(--border);
    border-radius: var(--radius);
    overflow: hidden;
  }

  .sig-kriteria-top {
    display: flex;
    align-items: flex-start;
    gap: 14px;
    padding: 24px 26px;
    background: var(--bg-soft);
    border-bottom: 1px solid var(--border);
  }

  .sig-kriteria-top .ic {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    background: var(--blue);
    color: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 17px;
    flex: none;
  }

  .sig-kriteria-top h4 {
    font-size: 15px;
    font-weight: 700;
    color: var(--navy);
    margin-bottom: 4px;
  }

  .sig-kriteria-top p {
    font-size: 12.5px;
    color: var(--text-muted);
  }

  .sig-kriteria-list {
    list-style: none;
    display: flex;
    flex-direction: column;
  }

  .sig-kriteria-list li {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 18px 26px;
    border-top: 1px solid var(--border);
    font-size: 13.5px;
    color: var(--text);
  }

  .sig-kriteria-list li:first-child {
    border-top: none;
  }

  .sig-kriteria-list li .ic {
    width: 26px;
    height: 26px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 12px;
    flex: none;
  }

  .sig-kriteria-list li.ok .ic {
    background: var(--bg-soft);
    color: var(--blue);
  }

  .sig-kriteria-list li.no .ic {
    background: #fde8e8;
    color: #c0392b;
  }

  .sig-kriteria-list li.info .ic {
    background: var(--bg-soft);
    color: var(--navy);
  }

  .sig-doc-card {
    background: #fff;
    border: 1px solid var(--border);
    border-radius: var(--radius);
    padding: 28px 30px;
  }

  .sig-doc-item {
    display: flex;
    gap: 16px;
    padding: 16px 0;
    border-top: 1px solid var(--border);
  }

  .sig-doc-item:first-child {
    border-top: none;
    padding-top: 0;
  }

  .sig-doc-num {
    flex: none;
    width: 30px;
    height: 30px;
    border-radius: 8px;
    background: var(--blue);
    color: #fff;
    font-weight: 800;
    font-size: 13.5px;
    display: flex;
    align-items: center;
    justify-content: center;
  }

  .sig-doc-item h5 {
    font-size: 14.5px;
    font-weight: 700;
    color: var(--navy);
    margin-bottom: 5px;
  }

  .sig-doc-item p {
    font-size: 13px;
    color: var(--text-muted);
    line-height: 1.6;
  }

  /* ---- CTA tengah (versi terang) ---- */
  .sig-cta-card {
    background: #fff;
    border: 1px solid var(--border);
    border-radius: 20px;
    padding: 48px 40px;
    text-align: center;
  }

  .sig-cta-card h2 {
    font-size: 27px;
    font-weight: 800;
    color: var(--navy);
    line-height: 1.3;
    margin-bottom: 16px;
  }

  .sig-cta-card p {
    color: var(--text-muted);
    font-size: 14.5px;
    max-width: 560px;
    margin: 0 auto 26px;
    line-height: 1.7;
  }

  .sig-cta-actions {
    display: flex;
    justify-content: center;
    gap: 16px;
    flex-wrap: wrap;
  }

  .sig-cta-actions .btn-outline {
    border-color: var(--border);
    color: var(--navy);
  }

  @media(max-width: 900px) {
    .sig-top-grid {
      grid-template-columns: 1fr;
    }

    .sig-stat-grid {
      grid-template-columns: 1fr 1fr;
    }

    .sig-mid-grid {
      grid-template-columns: 1fr;
    }
  }

  @media(max-width: 560px) {
    .sig-stat-grid {
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
    <p>Mendukung percepatan pertumbuhan bisnis Anda dengan solusi pembiayaan terintegrasi. Kami menyediakan
      modal
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
        <li><button class="tab-product-item active" data-target="subsidi"><span class="ic">🪪</span> Kredit
            Subsidi 0%</button></li>
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

      <div class="tab-panel active" id="panel-subsidi">

        <div class="tab-detail-card">
          <div class="tab-detail-top">
            <h2>Kredit UMKM Siger</h2>
          </div>
          <p>Program kerja sama Pemda Kota Bandar Lampung dan Bank Waway untuk pembiayaan tambahan modal
            usaha
            mikro dengan bunga yang ditanggung oleh APBD.</p>
        </div>

        <div class="sig-top-grid">
          <div class="sig-stat-grid">
            <div class="sig-stat-card">
              <div class="sig-stat-ic">💰</div>
              <div class="sig-stat-lbl">Plafon Maksimal</div>
              <div class="sig-stat-val">Rp 50.000.000</div>
            </div>
            <div class="sig-stat-card">
              <div class="sig-stat-ic">📅</div>
              <div class="sig-stat-lbl">Jangka Waktu</div>
              <div class="sig-stat-val">Hingga 36 Bulan</div>
            </div>
            <div class="sig-stat-card">
              <div class="sig-stat-ic">🛡️</div>
              <div class="sig-stat-lbl">Agunan</div>
              <div class="sig-stat-val">Tanpa Agunan</div>
            </div>
            <div class="sig-stat-card">
              <div class="sig-stat-ic">%</div>
              <div class="sig-stat-lbl">Suku Bunga</div>
              <div class="sig-stat-val">6% Flat <span class="sig-badge">Subsidi APBD</span></div>
            </div>
          </div>

          <div class="sig-opd-card">
            <div class="sig-opd-head">🏛 OPD Pendamping</div>
            <ul class="sig-opd-list">
              <li><span class="ic">✔️</span> Dinas Perdagangan</li>
              <li><span class="ic">✔️</span> Dinas Perindustrian</li>
              <li><span class="ic">✔️</span> Dinas Koperasi & UKM</li>
              <li><span class="ic">✔️</span> Dinas Pertanian</li>
              <li><span class="ic">✔️</span> Dinas Kelautan & Perikanan</li>
              <li><span class="ic">✔️</span> Dinas Pariwisata</li>
            </ul>
          </div>
        </div>

        <div class="sifat-title-row"><span class="bar"></span></div>
        <div class="sig-mid-grid">

          <div>
            <div class="sifat-title-row" style="margin-top:-14px"><span class="bar"></span>
              <h3>Kriteria Pemohon</h3>
            </div>
            <div class="sig-kriteria-card">
              <div class="sig-kriteria-top">
                <div class="ic">🪪</div>
                <div>
                  <h4>Siapa yang dapat mengajukan?</h4>
                  <p>Pelaku Usaha Mikro di wilayah Kota Bandar Lampung</p>
                </div>
              </div>
              <ul class="sig-kriteria-list">
                <li class="ok"><span class="ic">📍</span> Domisili asli Kota Bandar Lampung</li>
                <li class="no"><span class="ic">🚫</span> Bukan merupakan ASN / TNI / Polri</li>
                <li class="info"><span class="ic">🏬</span> Memiliki usaha produktif minimal 6 bulan
                </li>
              </ul>
            </div>
          </div>

          <div>
            <div class="sifat-title-row" style="margin-top:-14px"><span class="bar"></span>
              <h3>Dokumen Persyaratan</h3>
            </div>
            <div class="sig-doc-card">
              <div class="sig-doc-item">
                <div class="sig-doc-num">1</div>
                <div>
                  <h5>E-KTP & Kartu Keluarga</h5>
                  <p>Identitas diri dan bukti domisili pemohon yang masih berlaku.</p>
                </div>
              </div>
              <div class="sig-doc-item">
                <div class="sig-doc-num">2</div>
                <div>
                  <h5>SKU / NIB</h5>
                  <p>Surat Keterangan Usaha dari Kelurahan atau Nomor Induk Berusaha.</p>
                </div>
              </div>
              <div class="sig-doc-item">
                <div class="sig-doc-num">3</div>
                <div>
                  <h5>Dokumen Transaksi (Nota)</h5>
                  <p>Bukti transaksi usaha atau catatan keuangan sederhana.</p>
                </div>
              </div>
            </div>
          </div>

        </div>

        <div class="sig-cta-card">
          <h2>Kembangkan Usaha Anda<br>Sekarang</h2>
          <p>Dapatkan modal tambahan tanpa beban bunga tinggi. Kami siap mendampingi perjalanan sukses
            bisnis
            mikro Anda bersama Pemda Kota Bandar Lampung.</p>
          <div class="sig-cta-actions">
            <a href="https://api.whatsapp.com/send/?phone=6285382659996&text&type=phone_number&app_absent=0"
              target="_blank" rel="noopener" class="btn btn-primary">Hubungi Kantor Terdekat</a>
          </div>
        </div>

      </div>

    </div>
  </div>
</section>
@endsection

@section('scripts')
<script>
  // Tab switcher (hanya untuk panel yang ADA di halaman ini: Subsidi 0%, PDRS, UMKM)
  // Modal Kerja & Multiguna sudah jadi file terpisah -> pakai <a href="..."> di sidebar.
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
