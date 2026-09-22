@extends('layouts.public')

@section('title', ($product['name'] ?? 'Produk') . ' - Bank Waway Lampung')

@section('styles')
<style>
  .btn-outline:hover {
    background: var(--blue);
    color: #fff;
    border-color: var(--blue);
  }
</style>
@endsection

@section('content')

<section class="hero">
  <img class="hero-bg" src="{{ asset('frontend/images/deposito-hero.jpg') }}" alt="{{ $product['name'] ?? 'Produk Waway' }}">
  <div class="container">
    <span class="eyebrow" style="color:#93c5fd">{{ $product['category'] ?? 'Produk Unggulan' }}</span>
    <h1 style="margin-top:14px">{{ $product['name'] ?? 'Produk Waway' }}</h1>
    <p>{{ $product['description'] ?? 'Wujudkan masa depan finansial yang lebih cerah dengan suku bunga kompetitif dan fleksibilitas jangka waktu yang sesuai dengan rencana investasi Anda.' }}</p>
    <div class="hero-actions">
      @foreach($product['actions'] ?? [] as $action)
      <a href="{{ $action['url'] ?? '#simulasi' }}" class="btn {{ $action['type'] === 'secondary' ? 'btn-outline' : 'btn-primary' }}" @if(!empty($action['url']) && str_starts_with($action['url'] ?? '', 'http')) target="_blank" rel="noopener" @endif>{{ $action['text'] ?? 'Mulai Investasi 📈' }}</a>
      @endforeach
    </div>
  </div>
</section>

<section class="section">
  <div class="container">
    <h2 class="section-title">Peluang {{ $product['name'] ?? 'Produk' }}</h2>
    <p class="section-sub">Pilih jangka waktu yang paling sesuai dengan target finansial Anda. Dapatkan hasil maksimal
      dengan risiko yang terukur.</p>

    <div class="grid-4" style="margin-top:52px">
      @foreach(($product['tenors'] ?? []) as $tenor)
      <article class="tenor-card {{ !empty($tenor['featured']) ? 'featured' : '' }}">
        <div class="tenor-icon">{{ $tenor['icon'] ?? '📅' }}</div>
        <h3>{{ $tenor['label'] ?? '1 Bulan' }}</h3>
        <p>{{ $tenor['text'] ?? '' }}</p>
        <a href="{{ $product['actions'][0]['url'] ?? '#' }}" target="_blank" rel="noopener" class="btn {{ !empty($tenor['featured']) ? 'btn-primary' : 'btn-outline' }}" style="width:100%;justify-content:center">Ajukan {{ $product['name'] ?? 'Produk' }}</a>
      </article>
      @endforeach
    </div>
  </div>
</section>

<section class="section" style="background:var(--bg-soft)">
  <div class="container grid-2" style="align-items:center">
    <div>
      <h2 style="font-size:34px;color:var(--navy);font-weight:800">Investasi Aman & Terpercaya</h2>
      <p style="color:var(--text-muted);margin:18px 0 30px">Bank Waway Lampung berkomitmen memberikan layanan
        investasi yang transparan. Deposito Anda dijamin oleh Lembaga Penjamin Simpanan (LPS) sesuai ketentuan yang
        berlaku, memberikan ketenangan pikiran dalam setiap langkah finansial Anda.</p>

      <ul class="feature-list">
        @forelse(($product['benefits'] ?? []) as $benefit)
        <li><span class="feat-icon">🛡️</span>
          <div><strong>Keunggulan</strong><br>{{ $benefit }}</div>
        </li>
        @empty
        <li><span class="feat-icon">🛡️</span>
          <div><strong>Dijamin LPS</strong><br>Simpanan Anda aman terlindungi secara hukum.</div>
        </li>
        <li><span class="feat-icon">📊</span>
          <div><strong>Bunga Kompetitif</strong><br>Nikmati persentase bagi hasil di atas rata-rata pasar.</div>
        </li>
        <li><span class="feat-icon">⚡</span>
          <div><strong>Proses Cepat</strong><br>Pembukaan rekening tanpa hambatan birokrasi.</div>
        </li>
        @endforelse
        @foreach(($product['requirements'] ?? []) as $requirement)
        <li><span class="feat-icon">📋</span>
          <div><strong>Persyaratan</strong><br>{{ $requirement }}</div>
        </li>
        @endforeach
      </ul>
    </div>
    <div>
      <img src="{{ asset('frontend/images/deposito-gedung.jpg') }}" alt="Kantor Bank Waway"
        style="border-radius:16px;box-shadow:var(--shadow)">
    </div>
  </div>
</section>

<section class="section" id="simulasi">
  <div class="container">
    <div class="sim-wrap">
      <div class="sim-left">
        <h2>Simulasi Deposito</h2>
        <p>Hitung estimasi keuntungan investasi Anda sebelum memulai. Masukkan nominal dan pilih tenor untuk melihat
          proyeksi hasilnya.</p>

        <label class="sim-label" for="nominal">Nominal Investasi (IDR)</label>
        <div class="sim-input"><span>Rp</span><input type="text" inputmode="numeric" id="nominal" value="100.000.000">
        </div>
        <p class="sim-min-note" id="nominalWarning"
          style="display:none;color:#fca5a5;font-size:12.5px;margin-top:8px">
          Nominal minimum deposito adalah Rp 1.000.000.
        </p>

        <label class="sim-label" style="margin-top:22px;display:block">Pilih Tenor</label>
        <div class="sim-tenor">
          <button type="button" class="tenor-btn active" data-bunga="5.5" data-bulan="1">1 Bln</button>
          <button type="button" class="tenor-btn" data-bunga="5.75" data-bulan="3">3 Bln</button>
          <button type="button" class="tenor-btn" data-bunga="5.75" data-bulan="6">6 Bln</button>
          <button type="button" class="tenor-btn" data-bunga="6" data-bulan="12">12 Bln</button>
        </div>
      </div>

      <div class="sim-right">
        <div class="sim-row">
          <span>Suku Bunga (per tahun)</span>
          <span id="rate">5.5%</span>
        </div>
        <div class="sim-row">
          <span>Estimasi Bunga (Setahun)</span>
          <span id="bungaKotor">Rp 0</span>
        </div>
        <div class="sim-row">
          <span>Pajak Bunga (20%)</span>
          <span id="pajak">Rp 0</span>
        </div>
        <div class="sim-row">
          <span>Bunga Bersih / Bulan</span>
          <span id="bunga">Rp 0</span>
        </div>
        <hr>
        <div class="sim-total">
          <span>Total Pengembalian (Saat Jatuh Tempo)</span>
          <div class="sim-total-value" id="total">Rp 0</div>
        </div>
        <p class="sim-note">*Estimasi sudah memperhitungkan pajak bunga deposito 20% sesuai ketentuan yang berlaku.
        </p>
      </div>
    </div>
  </div>
</section>

@endsection

@section('scripts')
<script>
  (function () {
    const nominalInput = document.getElementById('nominal');
    const tenorBtns = document.querySelectorAll('.tenor-btn');
    const rateEl = document.getElementById('rate');
    const bungaKotorEl = document.getElementById('bungaKotor');
    const pajakEl = document.getElementById('pajak');
    const bungaEl = document.getElementById('bunga');
    const totalEl = document.getElementById('total');
    const warningEl = document.getElementById('nominalWarning');

    if (!nominalInput || !tenorBtns.length || !rateEl || !bungaEl || !totalEl) return;

    const MIN_NOMINAL = 1000000;
    const PAJAK_PERSEN = 0.20;

    const formatRibuan = (angka) => angka.toLocaleString('id-ID');

    const formatRupiah = (angka) => 'Rp ' + Math.round(angka).toLocaleString('id-ID');

    const getAngkaBersih = () => {
      const bersih = nominalInput.value.replace(/[^0-9]/g, '');
      return bersih ? parseInt(bersih, 10) : 0;
    };

    function hitung() {
      const active = document.querySelector('.tenor-btn.active') || tenorBtns[0];
      const bunga = parseFloat(active.dataset.bunga);
      const bulan = parseInt(active.dataset.bulan, 10);
      const pokok = getAngkaBersih();

      const bungaKotorTahunan = pokok * (bunga / 100);
      const pajakBunga = bungaKotorTahunan * PAJAK_PERSEN;
      const bungaBersihTahunan = bungaKotorTahunan - pajakBunga;
      const bungaBersihBulanan = bungaBersihTahunan / 12;

      const totalBungaSelamaTenor = bungaBersihBulanan * bulan;
      const totalKembali = pokok + totalBungaSelamaTenor;

      rateEl.textContent = bunga + '%';
      bungaKotorEl.textContent = formatRupiah(bungaKotorTahunan);
      pajakEl.textContent = formatRupiah(pajakBunga);
      bungaEl.textContent = formatRupiah(bungaBersihBulanan);
      totalEl.textContent = formatRupiah(totalKembali);

      if (warningEl) {
        warningEl.style.display = (pokok > 0 && pokok < MIN_NOMINAL) ? 'block' : 'none';
      }
    }

    nominalInput.addEventListener('input', () => {
      const posisiKursorDariBelakang = nominalInput.value.length - nominalInput.selectionStart;
      const angka = getAngkaBersih();
      nominalInput.value = angka ? formatRibuan(angka) : '';
      const posisiBaru = nominalInput.value.length - posisiKursorDariBelakang;
      nominalInput.setSelectionRange(posisiBaru, posisiBaru);
      hitung();
    });

    tenorBtns.forEach(btn => {
      btn.addEventListener('click', () => {
        tenorBtns.forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        hitung();
      });
    });

    hitung();
  })();
</script>
@endsection
