@extends('layouts.public')

@section('title', 'Bank Waway Lampung - Form Kredit Pegawai')

@section('content')

<div class="breadcrumb-row">
    <div class="container">
      <a href="{{ route('public.kredit.pinjaman') }}">Produk</a> <span class="sep">›</span>
      <a href="{{ route('public.kredit.pinjaman') }}">Kredit</a> <span class="sep">›</span>
      <strong>Kredit Pegawai</strong>
    </div>
  </div>

  <section class="section">
    <div class="container" style="max-width:840px">

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

      <div class="tnc-card">
        <div class="tnc-header">
          <h1>Form Kredit Pegawai</h1>
          <p>Silakan tinjau syarat dan ketentuan di bawah ini sebelum melanjutkan permohonan kredit Anda.</p>
        </div>

        <div class="tnc-body">
          <div class="tnc-body-title">📜 Syarat dan Ketentuan</div>

          <div class="tnc-scroll-box">
            <h5>Pasal 1: Definisi dan Ketentuan Umum</h5>
            <p>Fasilitas Kredit Pegawai adalah layanan pinjaman yang diberikan oleh Bank Waway Lampung kepada pegawai
              tetap yang gajinya dibayarkan melalui sistem payroll Bank Waway Lampung atau instansi yang telah bekerja
              sama.</p>

            <h5>Pasal 2: Kriteria Penerima Kredit</h5>
            <ul>
              <li>Pegawai tetap dengan masa kerja minimal 2 (dua) tahun.</li>
              <li>Usia minimal 21 tahun dan maksimal 56 tahun pada saat kredit lunas.</li>
              <li>Wajib memiliki rekening payroll di Bank Waway Lampung.</li>
              <li>Memiliki riwayat kredit yang baik (tidak masuk dalam daftar hitam BI/OJK).</li>
            </ul>

            <h5>Pasal 3: Plafon dan Jangka Waktu</h5>
            <p>Plafon kredit ditentukan berdasarkan rasio cicilan terhadap gaji bersih (Debt Service Ratio) maksimal
              60%. Jangka waktu kredit minimal 12 bulan dan maksimal 120 bulan sesuai dengan ketentuan yang berlaku pada
              instansi masing-masing.</p>

            <h5>Pasal 4: Suku Bunga dan Biaya</h5>
            <p>Suku bunga kredit bersifat tetap (fixed) selama masa tenor dan ditentukan berdasarkan hasil analisa
              kelayakan kredit. Biaya provisi, biaya administrasi, dan biaya asuransi jiwa kredit dibebankan kepada
              pemohon sesuai ketentuan yang berlaku dan disampaikan secara transparan sebelum akad kredit
              ditandatangani.</p>

            <h5>Pasal 5: Pelunasan Dipercepat</h5>
            <p>Pemohon dapat melakukan pelunasan dipercepat baik sebagian maupun seluruhnya sebelum jangka waktu kredit
              berakhir, dengan dikenakan biaya penalti sesuai dengan ketentuan yang berlaku pada saat akad kredit.</p>

            <h5>Pasal 6: Wanprestasi</h5>
            <p>Apabila pemohon tidak memenuhi kewajiban pembayaran cicilan sesuai jadwal yang telah disepakati, Bank
              Waway Lampung berhak mengenakan denda keterlambatan dan melakukan tindakan penagihan sesuai dengan
              peraturan perundang-undangan yang berlaku.</p>

            <h5>Pasal 7: Perlindungan Data Pribadi</h5>
            <p>Bank Waway Lampung berkomitmen menjaga kerahasiaan data pribadi pemohon sesuai dengan Undang-Undang
              Perlindungan Data Pribadi dan ketentuan Otoritas Jasa Keuangan (OJK) yang berlaku.</p>
          </div>

          <div class="tnc-checkbox-box">
            <input type="checkbox" id="setujuTnc">
            <label for="setujuTnc">Saya telah membaca, memahami, dan menyetujui seluruh Syarat dan Ketentuan yang
              berlaku di atas serta memberikan izin kepada Bank Waway Lampung untuk memproses data saya.</label>
          </div>

          <div class="tnc-actions">
            <button type="button" class="btn btn-primary" id="btnLanjutKredit" disabled>Setuju dan Lanjut →</button>
          </div>
        </div>

        <div class="tnc-progress">
          <div class="tnc-progress-fill" id="tncProgressFill"></div>
        </div>
      </div>

      <div class="info-mini-grid">
        <div class="info-mini-card">
          <div class="ic blue">🎧</div>
          <div>
            <h5>Butuh bantuan?</h5>
            <p>Hubungi Call Center 1500-123</p>
          </div>
        </div>
        <div class="info-mini-card">
          <div class="ic navy">🛡️</div>
          <div>
            <h5>Transaksi Aman</h5>
            <p>Berizin & Diawasi OJK</p>
          </div>
        </div>
      </div>

      <div class="application-panel is-open" id="applicationPanel">
        <form action="{{ route('public.pengajuan.store') }}" method="POST" class="form-card" novalidate>
          @csrf

          <div class="form-group">
            <label for="product_type">Jenis Produk <span class="req" aria-hidden="true">*</span></label>
            <select id="product_type" name="product_type" class="{{ $errors->has('product_type') ? 'is-invalid' : '' }}" required>
              <option value="">-- Pilih Jenis Produk --</option>
              @foreach($productTypes as $type)
              <option value="{{ $type }}" {{ old('product_type', 'kredit') === $type ? 'selected' : '' }}>{{ ucfirst($type) }}</option>
              @endforeach
            </select>
            @error('product_type')
            <span class="form-error">{{ $message }}</span>
            @enderror
          </div>

          <div class="form-group">
            <label for="product_name">Nama Produk</label>
            <input type="text" id="product_name" name="product_name" class="{{ $errors->has('product_name') ? 'is-invalid' : '' }}" value="{{ old('product_name', 'Kredit Pegawai') }}" placeholder="Contoh: Kredit Pegawai">
            @error('product_name')
            <span class="form-error">{{ $message }}</span>
            @enderror
          </div>

          <div class="form-group">
            <label for="amount">Nominal Pengajuan (Rupiah) <span class="req" aria-hidden="true">*</span></label>
            <input type="number" id="amount" name="amount" class="{{ $errors->has('amount') ? 'is-invalid' : '' }}" min="100000" step="100000" value="{{ old('amount') }}" placeholder="Contoh: 50000000" required>
            @error('amount')
            <span class="form-error">{{ $message }}</span>
            @enderror
          </div>

          <div class="form-group">
            <label for="tenure">Jangka Waktu (Bulan) <span class="req" aria-hidden="true">*</span></label>
            <input type="number" id="tenure" name="tenure" class="{{ $errors->has('tenure') ? 'is-invalid' : '' }}" min="1" max="360" value="{{ old('tenure', 12) }}" required>
            @error('tenure')
            <span class="form-error">{{ $message }}</span>
            @enderror
          </div>

          <div class="form-group">
            <label for="applicant_name">Nama Lengkap <span class="req" aria-hidden="true">*</span></label>
            <input type="text" id="applicant_name" name="applicant_name" class="{{ $errors->has('applicant_name') ? 'is-invalid' : '' }}" value="{{ old('applicant_name') }}" placeholder="Contoh: Budi Santoso" required autocomplete="name">
            @error('applicant_name')
            <span class="form-error">{{ $message }}</span>
            @enderror
          </div>

          <div class="form-group">
            <label for="nik">NIK (16 Digit) <span class="req" aria-hidden="true">*</span></label>
            <input type="text" id="nik" name="nik" class="{{ $errors->has('nik') ? 'is-invalid' : '' }}" maxlength="16" value="{{ old('nik') }}" placeholder="Contoh: 1807022901000001" required inputmode="numeric" autocomplete="off">
            @error('nik')
            <span class="form-error">{{ $message }}</span>
            @enderror
          </div>

          <div class="form-group">
            <label for="phone">No. Telepon / WhatsApp <span class="req" aria-hidden="true">*</span></label>
            <input type="tel" id="phone" name="phone" class="{{ $errors->has('phone') ? 'is-invalid' : '' }}" maxlength="30" value="{{ old('phone') }}" placeholder="Contoh: 081234567890" required autocomplete="tel">
            @error('phone')
            <span class="form-error">{{ $message }}</span>
            @enderror
          </div>

          <div class="form-group">
            <label for="email">Alamat Email <span class="req" aria-hidden="true">*</span></label>
            <input type="email" id="email" name="email" class="{{ $errors->has('email') ? 'is-invalid' : '' }}" value="{{ old('email') }}" placeholder="Contoh: budi@email.com" required autocomplete="email">
            @error('email')
            <span class="form-error">{{ $message }}</span>
            @enderror
          </div>

          <div class="form-group">
            <label for="address">Alamat Domisili</label>
            <input type="text" id="address" name="address" class="{{ $errors->has('address') ? 'is-invalid' : '' }}" value="{{ old('address') }}" placeholder="Contoh: Jl. Merdeka No. 10, Bandar Lampung">
            @error('address')
            <span class="form-error">{{ $message }}</span>
            @enderror
          </div>

          <div class="form-group">
            <label for="notes">Catatan Tambahan</label>
            <textarea id="notes" name="notes" rows="4" class="{{ $errors->has('notes') ? 'is-invalid' : '' }}" placeholder="Tuliskan kebutuhan atau informasi tambahan...">{{ old('notes') }}</textarea>
            @error('notes')
            <span class="form-error">{{ $message }}</span>
            @enderror
          </div>

          <div class="form-actions">
            <button type="submit" class="btn btn-primary">Kirim Pengajuan</button>
            <a href="{{ route('public.kalkulator.index') }}" class="btn btn-secondary">Kalkulator Simulasi</a>
          </div>
        </form>
      </div>

    </div>
  </section>

@endsection

@section('scripts')
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const setujuTnc = document.getElementById('setujuTnc');
    const btnLanjut = document.getElementById('btnLanjutKredit');
    const panel = document.getElementById('applicationPanel');
    const progress = document.getElementById('tncProgressFill');

    if (setujuTnc && btnLanjut) {
      setujuTnc.addEventListener('change', () => {
        btnLanjut.disabled = !setujuTnc.checked;
        if (progress) progress.classList.toggle('full', setujuTnc.checked);
      });
    }

    if (btnLanjut && panel) {
      btnLanjut.addEventListener('click', () => {
        panel.classList.add('is-open');
        window.scrollTo({ top: panel.offsetTop - 60, behavior: 'smooth' });
      });
    }

    const amount = document.getElementById('amount');
    if (amount) amount.addEventListener('input', function () {
      this.value = this.value.replace(/[^0-9]/g, '');
    });
  });
</script>
@endsection
