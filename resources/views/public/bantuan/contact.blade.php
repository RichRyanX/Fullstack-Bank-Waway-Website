@extends('layouts.public')

@section('title', 'Hubungi Kami - Bank Waway')

@section('meta_description', 'Sampaikan pertanyaan, masukan, atau keluhan Anda melalui formulir layanan nasabah Bank Waway.')

@section('meta_keywords', 'Bank Waway, kontak, hubungi kami, layanan nasabah, pertanyaan')

@section('meta_canonical', url()->current())

@section('og_title', 'Hubungi Kami - Bank Waway')

@section('og_description', 'Sampaikan pertanyaan, masukan, atau keluhan Anda melalui formulir layanan nasabah Bank Waway.')

@section('og_type', 'website')

@section('structured_data')
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@type": "ContactPage",
  "name": "Hubungi Kami",
  "url": "{{ url()->current() }}",
  "description": "Sampaikan pertanyaan, masukan, atau keluhan Anda melalui formulir layanan nasabah Bank Waway."
}
</script>
@endsection

@section('content')
<section class="page-section">
  <div class="container container-narrow">
    <div class="page-header">
      <h1 class="page-title">Hubungi Kami</h1>
      <p class="page-lead">Sampaikan pertanyaan, masukan, atau keluhan Anda melalui formulir di bawah ini. Tim Bank Waway akan merespons sesegera mungkin.</p>
    </div>

    @if(session('success'))
    <div class="alert alert-success" role="alert">
      {{ session('success') }}
    </div>
    @endif

    @if($errors->any())
    <div class="alert alert-danger" role="alert">
      <strong>Terjadi kesalahan pada pengisian formulir.</strong>
      <ul class="alert-list">
        @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
    @endif

    <form action="{{ route('public.kontak.store') }}" method="POST" class="form-card" novalidate>
      @csrf

      <div class="form-group">
        <label for="nama">Nama Lengkap <span class="req" aria-hidden="true">*</span></label>
        <input
          type="text"
          id="nama"
          name="nama"
          value="{{ old('nama') }}"
          class="{{ $errors->has('nama') ? 'is-invalid' : '' }}"
          placeholder="Contoh: Budi Santoso"
          required
          autocomplete="name">
        @error('nama')
        <span class="form-error">{{ $message }}</span>
        @enderror
      </div>

      <div class="form-group">
        <label for="email">Alamat Email <span class="req" aria-hidden="true">*</span></label>
        <input
          type="email"
          id="email"
          name="email"
          value="{{ old('email') }}"
          class="{{ $errors->has('email') ? 'is-invalid' : '' }}"
          placeholder="Contoh: budi@email.com"
          required
          autocomplete="email">
        @error('email')
        <span class="form-error">{{ $message }}</span>
        @enderror
      </div>

      <div class="form-group">
        <label for="subjek">Subjek <span class="req" aria-hidden="true">*</span></label>
        <input
          type="text"
          id="subjek"
          name="subjek"
          value="{{ old('subjek') }}"
          class="{{ $errors->has('subjek') ? 'is-invalid' : '' }}"
          placeholder="Contoh: Informasi produk kredit"
          required>
        @error('subjek')
        <span class="form-error">{{ $message }}</span>
        @enderror
      </div>

      <div class="form-group">
        <label for="modul">Modul / Bidang Layanan <span class="req" aria-hidden="true">*</span></label>
        <select
          id="modul"
          name="modul"
          class="{{ $errors->has('modul') ? 'is-invalid' : '' }}"
          required>
          <option value="">-- Pilih Modul Layanan --</option>
          @foreach(['Simpanan', 'Kredit', 'Layanan Digital', 'Laporan & Kepatuhan', 'Layanan Nasabah', 'Lainnya'] as $modulOption)
          <option value="{{ $modulOption }}" {{ old('modul') === $modulOption ? 'selected' : '' }}>{{ $modulOption }}</option>
          @endforeach
        </select>
        @error('modul')
        <span class="form-error">{{ $message }}</span>
        @enderror
      </div>

      <div class="form-group">
        <label for="pesan">Pesan / Pertanyaan <span class="req" aria-hidden="true">*</span></label>
        <textarea
          id="pesan"
          name="pesan"
          rows="5"
          class="{{ $errors->has('pesan') ? 'is-invalid' : '' }}"
          placeholder="Tuliskan pertanyaan atau pesan Anda secara lengkap..."
          required>{{ old('pesan') }}</textarea>
        @error('pesan')
        <span class="form-error">{{ $message }}</span>
        @enderror
      </div>

      <div class="form-actions">
        <button type="submit" class="btn btn-primary">Kirim Pesan</button>
        <a href="{{ route('home') }}" class="btn btn-secondary">Kembali</a>
      </div>
    </form>
  </div>
</section>
@endsection
