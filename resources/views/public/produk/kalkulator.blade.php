@extends('layouts.public')

@section('title', 'Kalkulator Simulasi - Bank Waway')

@section('meta_description', 'Hitung estimasi angsuran kredit, bunga simpanan, dan nilai jatuh tempo deposito secara langsung di Kalkulator Simulasi Bank Waway.')

@section('meta_keywords', 'Bank Waway, kalkulator, simulasi, kredit, deposito, tabungan, angsuran')

@section('meta_canonical', url()->current())

@section('og_title', 'Kalkulator Simulasi - Bank Waway')

@section('og_description', 'Hitung estimasi angsuran kredit, bunga simpanan, dan nilai jatuh tempo deposito secara langsung di Kalkulator Simulasi Bank Waway.')

@section('og_type', 'website')

@section('structured_data')
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@type": "WebApplication",
  "name": "Kalkulator Simulasi Bank Waway",
  "url": "{{ url()->current() }}",
  "applicationCategory": "FinanceApplication",
  "description": "Hitung estimasi angsuran kredit, bunga simpanan, dan nilai jatuh tempo deposito secara langsung."
}
</script>
@endsection

@section('content')
<section class="page-section">
  <div class="container calculator-container">
    <div class="page-header">
      <h1 class="page-title">Kalkulator Simulasi</h1>
      <p class="page-lead">Hitung estimasi angsuran kredit, bunga simpanan, dan nilai jatuh tempo deposito secara langsung tanpa perlu memuat ulang halaman.</p>
    </div>

    <div class="calculator-layout">
      <div class="calculator-form-card">
        <form id="simulationCalculatorForm" novalidate>
          <div class="form-group">
            <label for="calcProductType">Jenis Produk</label>
            <select id="calcProductType" name="product_type" required>
              <option value="">-- Pilih Jenis Produk --</option>
              @foreach($productTypes as $type)
              <option value="{{ $type }}" {{ old('product_type') === $type ? 'selected' : '' }}>{{ ucfirst($type) }}</option>
              @endforeach
            </select>
          </div>

          <div class="form-group">
            <label for="calcAmount">Nominal Produk (IDR)</label>
            <input type="number" id="calcAmount" name="amount" min="100000" step="100000" placeholder="Contoh: 50000000" value="{{ old('amount', 50000000) }}">
          </div>

          <div class="form-group">
            <label for="calcTenureRange">Jangka Waktu (Bulan)</label>
            <input type="range" id="calcTenureRange" name="tenureRange" class="slider-control" min="1" max="360" step="1" value="{{ old('tenureRange', 12) }}">
            <div class="slider-value-row">
              <input type="number" id="calcTenure" name="tenure" min="1" max="360" step="1" value="{{ old('tenure', 12) }}">
              <span class="slider-value" id="calcTenureValue">{{ old('tenureRange', 12) }} bulan</span>
            </div>
          </div>

          <div class="form-actions">
            <button type="button" class="btn btn-white" id="btnSimulate">Hitung Simulasi</button>
            <a href="{{ route('public.pengajuan.index') }}" class="btn btn-outline-white">Ajukan Sekarang</a>
          </div>
        </form>
      </div>

      <div class="calculator-result-card" id="calculatorResult" aria-live="polite">
        <div class="calc-result-empty">
          <span class="calc-result-icon">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="4" y="2" width="16" height="20" rx="2"></rect><line x1="8" y1="6" x2="16" y2="6"></line><line x1="16" y1="14" x2="16" y2="18"></line><path d="M16 10h.01"></path><path d="M12 10h.01"></path><path d="M8 10h.01"></path><path d="M12 14h.01"></path><path d="M8 14h.01"></path><path d="M12 18h.01"></path><path d="M8 18h.01"></path></svg>
          </span>
          <p>Pilih jenis produk dan masukkan nominal untuk melihat simulasi.</p>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection
