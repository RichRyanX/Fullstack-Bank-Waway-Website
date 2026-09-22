@extends('layouts.public')

@section('title', 'Tabungan Tapis - Bank Waway Lampung')

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
            <a href="{{ route('public.tabungan.tapis') }}" class="tab-product-item active">
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
            <h2>Tabungan Tapis</h2>
            <span class="tab-badge-populer">Populer</span>
          </div>
          <p>Tabungan TAPIS adalah produk tabungan yang diperuntukkan bagi masyarakat umum, baik
            perorangan maupun
            badan usaha.</p>
        </div>

        <div class="tc-grid-top">
          <div class="tc-benefit-card">
            <div class="tc-benefit-head">
              <span class="tc-benefit-ic">⚙️</span>
              <h3>Keunggulan Produk</h3>
            </div>
            <div class="tt-benefit-items">
              <div class="tt-benefit-tile">
                <span class="ic">📈</span>
                <div>
                  <h4>Suku Bunga 1%</h4>
                  <p>Bunga kompetitif per tahun.</p>
                </div>
              </div>
              <div class="tt-benefit-tile">
                <span class="ic">🛡️</span>
                <div>
                  <h4>Dijamin LPS</h4>
                  <p>Dana Anda aman dilindungi.</p>
                </div>
              </div>
              <div class="tt-benefit-tile">
                <span class="ic">👁️</span>
                <div>
                  <h4>Transparan</h4>
                  <p>Pencatatan mutasi jelas.</p>
                </div>
              </div>
              <div class="tt-benefit-tile">
                <span class="ic">💳</span>
                <div>
                  <h4>Penarikan Mudah</h4>
                  <p>Kapan saja saat dibutuhkan.</p>
                </div>
              </div>
            </div>
          </div>

          <div class="tt-fee-card">
            <h3>Ketentuan Biaya</h3>
            <div class="tt-fee-list">
              <div class="tt-fee-row">
                <span>Setoran Awal</span>
                <strong>Rp50.000</strong>
              </div>
              <div class="tt-fee-row">
                <span>Setoran Lanjutan</span>
                <strong>Min<br>Rp10.000</strong>
              </div>
              <div class="tt-fee-row">
                <span>Biaya Admin</span>
                <strong>Rp5.000/bln</strong>
              </div>
            </div>
            <a href="#" class="tt-btn-mulai">Mulai Menabung</a>
          </div>
        </div>

        <div class="tt-req-card">
          <div class="tt-req-tabs">
            <button class="tt-req-tab active" data-tab="perorangan">Persyaratan Perorangan</button>
            <button class="tt-req-tab" data-tab="badan">Badan Usaha</button>
          </div>
          <div class="tt-req-panel" data-panel="perorangan">
            <div class="tt-req-num-grid">
              <div class="tt-req-num-item">
                <span class="num">1</span> Fotokopi KTP (WNI) yang masih berlaku
              </div>
              <div class="tt-req-num-item">
                <span class="num">2</span> Fotokopi NPWP (jika ada)
              </div>
              <div class="tt-req-num-item">
                <span class="num">3</span> Mengisi formulir aplikasi pembukaan rekening
              </div>
              <div class="tt-req-num-item">
                <span class="num">4</span> Mengisi formulir slip penyetoran
              </div>
            </div>
          </div>
          <div class="tt-req-panel" data-panel="badan" hidden>
            <div class="tt-req-num-grid">
              <div class="tt-req-num-item">
                <span class="num">1</span> Fotokopi Akta Pendirian & Perubahan
              </div>
              <div class="tt-req-num-item">
                <span class="num">2</span> NPWP Badan Usaha
              </div>
              <div class="tt-req-num-item">
                <span class="num">3</span> Surat Izin Usaha (SIUP/NIB)
              </div>
              <div class="tt-req-num-item">
                <span class="num">4</span> KTP Pengurus/Penanggung Jawab
              </div>
            </div>
          </div>
        </div>

        <div class="tt-benefit-row">
          <div class="tt-benefit-card-lg">
            <span class="tt-benefit-lg-ic">🛡️</span>
            <h4>Simpan Dana Aman</h4>
            <p>Proteksi maksimal untuk aset finansial masa depan Anda.</p>
          </div>
          <div class="tt-benefit-card-lg">
            <span class="tt-benefit-lg-ic">🏛️</span>
            <h4>Kelola Keuangan</h4>
            <p>Mudahkan kontrol pengeluaran dan pemasukan harian.</p>
          </div>
          <div class="tt-benefit-card-lg">
            <span class="tt-benefit-lg-ic">🗓️</span>
            <h4>Rencana Masa Depan</h4>
            <p>Dukung pencapaian target finansial jangka panjang.</p>
          </div>
        </div>

      </div>

    </div>
  </div>
</section>

@endsection

@section('scripts')
<script>
  document.querySelectorAll('.tt-req-tab').forEach(tab => {
    tab.addEventListener('click', () => {
      document.querySelectorAll('.tt-req-tab').forEach(t => t.classList.remove('active'));
      tab.classList.add('active');
      const target = tab.dataset.tab;
      document.querySelectorAll('.tt-req-panel').forEach(p => {
        p.hidden = p.dataset.panel !== target;
      });
    });
  });
</script>
@endsection
