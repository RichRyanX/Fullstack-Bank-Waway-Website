@extends('layouts.public')

@section('title', 'Bank Waway Lampung - Pusat Bantuan')

@section('styles')
<style>
    .faq-item {
      border-bottom: 1px solid #e2e8f0;
      padding: 10px 25px;
    }

    .faq-question {
      width: 100%;
      text-align: left;
      background: none;
      border: none;
      padding: 15px 0;
      font-size: 16px;
      font-weight: 600;
      cursor: pointer;
      display: flex;
      justify-content: space-between;
      align-items: center;
      color: #333;
    }

    .faq-question .chev {
      transition: transform 0.3s ease;
    }

    .faq-answer {
      max-height: 0;
      overflow: hidden;
      transition: max-height 0.3s ease-out;
    }

    .faq-answer p {
      padding-bottom: 15px;
      color: #666;
      line-height: 1.6;
      margin: 0;
    }

    .faq-item.open .chev {
      transform: rotate(180deg);
    }
</style>
@endsection

@section('content')

<section class="help-hero">
    <div class="container">
      <h1>Pusat Bantuan</h1>
      <p>Kami hadir untuk memberikan solusi perbankan terbaik bagi Anda. Temukan jawaban dari pertanyaan Anda atau
        hubungi layanan pelanggan kami 24/7.</p>

      <div class="help-contact-grid">
        <div class="help-contact-card">
          <div class="ic">🎧</div>
          <h4>Call Center</h4>
          <p>+0721 266 869</p>
        </div>
        <div class="help-contact-card">
          <div class="ic">✉️</div>
          <h4>Email</h4>
          <p>bankwawaylampung@yahoo.com</p>
        </div>
        <div class="help-contact-card">
          <div class="ic">💬</div>
          <h4>WhatsApp</h4>
          <p>+62 853-8265-9996</p>
        </div>
      </div>
    </div>
  </section>

  <div class="help-search-wrap">
    <div class="container">
      <form class="help-search" id="helpSearchForm">
        <span class="ic">🔍</span>
        <input type="text" id="helpSearchInput" placeholder="Cari pertanyaan atau bantuan...">
        <button type="submit">Cari</button>
      </form>
    </div>
  </div>

  <section class="faq-section">
    <div class="container">
      <h2 class="section-title">Pertanyaan yang Sering Diajukan</h2>
      <p class="section-sub">Informasi cepat mengenai layanan Bank Waway Lampung.</p>

      <div class="faq-list">
        <div class="faq-item">
          <button class="faq-question">
            Bagaimana cara mengaktifkan e-wallet?
            <span class="chev">▾</span>
          </button>
          <div class="faq-answer">
            <p>Pengaktifan e-wallet wajib mendatangi kantor pusat Bank Waway Lampung yang berlokasi di
              Jl. Diponegoro No.28, Gulak Galik, Kec. Tlk. Betung Utara, Kota Bandar Lampung, Lampung 35212.</p>
          </div>
        </div>

        <div class="faq-item">
          <button class="faq-question">
            Apa yang harus dilakukan jika buku tabungan hilang?
            <span class="chev">▾</span>
          </button>
          <div class="faq-answer">
            <p>Membawa KTP dan surat kehilangan dari kantor kepolisian kemudian mendatangi kantor Bank Waway Lampung.
            </p>
          </div>
        </div>

        <div class="faq-item">
          <button class="faq-question">
            Berapa biaya administrasi bulanan Tabungan Tapis Bank Waway Lampung?
            <span class="chev">▾</span>
          </button>
          <div class="faq-answer">
            <p>Biaya administrasi berbeda-beda tergantung jenis produk tabungan:</p>
            <p>- Tabungan Simpel: Rp. 0 / Nol</p>
            <p>- Tabungan Tapis: Rp. 5000 / Lima Ribu Rupiah</p>
            <p>- Tabungan Pegawai: Rp. 5000 / Lima Ribu Rupiah</p>
            <p>- Tabungan Cerdik: Rp. 5000 / Lima Ribu Rupiah</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="prosedur-section">
    <div class="container">
      <div class="prosedur-head">
        <div>
          <h2>Prosedur Bertransaksi</h2>
          <p>Ikuti langkah-langkah mudah untuk melakukan transaksi perbankan dengan aman dan nyaman di Bank Waway
            Lampung.</p>
        </div>
        <a href="{{ route('public.laporan.index') }}" class="btn btn-outline">Unduh Panduan Lengkap</a>
      </div>

      <div class="prosedur-grid">
        <div class="step-card">
          <div class="step-num">01</div>
          <div class="step-icon">🏛️</div>
          <h5>Pilih Layanan</h5>
          <p>Pilih jenis transaksi yang ingin Anda lakukan melalui ATM, Mobile Banking, atau Kantor Cabang.</p>
        </div>
        <div class="step-card">
          <div class="step-num">02</div>
          <div class="step-icon">🔏</div>
          <h5>Verifikasi Identitas</h5>
          <p>Lakukan autentikasi menggunakan PIN, sidik jari, atau verifikasi wajah untuk menjamin keamanan akun Anda.
          </p>
        </div>
        <div class="step-card">
          <div class="step-num">03</div>
          <div class="step-icon">💵</div>
          <h5>Input Data</h5>
          <p>Masukkan detail transaksi seperti nomor rekening tujuan, nominal, dan keterangan transaksi dengan teliti.
          </p>
        </div>
        <div class="step-card">
          <div class="step-num">04</div>
          <div class="step-icon">🧾</div>
          <h5>Simpan Bukti</h5>
          <p>Konfirmasi transaksi dan simpan bukti transaksi digital atau cetak struk sebagai referensi di masa
            mendatang.</p>
        </div>
      </div>
    </div>
  </section>

  <section class="section" style="padding-top:0">
    <div class="help-cta">
      <h2>Belum menemukan yang Anda cari?</h2>
      <p>Tim spesialis kami siap membantu Anda menyelesaikan kendala perbankan Anda dengan cepat dan efisien.</p>
      <div class="help-cta-actions">
        <a href="https://api.whatsapp.com/send/?phone=6285382659996&text&type=phone_number&app_absent=0"
          class="btn btn-primary">Hubungi Kami</a>
        <a href="https://maps.app.goo.gl/XXQFDXPrbKguNWnZ9?g_st=aw" class="btn btn-white">Cari Lokasi Kantor</a>
      </div>
    </div>
  </section>

@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
      const faqQuestions = document.querySelectorAll('.faq-question');

      faqQuestions.forEach(btn => {
        btn.addEventListener('click', () => {
          const item = btn.closest('.faq-item');
          const answer = item.querySelector('.faq-answer');
          const isOpen = item.classList.contains('open');

          if (isOpen) {
            item.classList.remove('open');
            answer.style.maxHeight = null;
          } else {
            document.querySelectorAll('.faq-item').forEach(x => {
              x.classList.remove('open');
              const ans = x.querySelector('.faq-answer');
              if (ans) ans.style.maxHeight = null;
            });

            item.classList.add('open');
            answer.style.maxHeight = answer.scrollHeight + 'px';
          }
        });
      });
    });
</script>
@endsection
