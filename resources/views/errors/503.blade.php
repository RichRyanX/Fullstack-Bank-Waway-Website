<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Sedang Dalam Pemeliharaan - Bank Waway</title>
  <link rel="stylesheet" href="{{ asset('frontend/css/style.css') }}">
  <style>
    .maintenance-wrap {
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 40px 24px;
      background: var(--bg);
    }
    .maintenance-card {
      width: 100%;
      max-width: 640px;
      text-align: center;
      background: var(--white);
      border: 1px solid var(--border);
      border-radius: var(--radius);
      box-shadow: var(--shadow);
      padding: 48px 40px;
    }
    .maintenance-logo {
      height: 72px;
      width: auto;
      margin: 0 auto 28px;
      display: block;
    }
    .maintenance-title {
      font-size: 32px;
      font-weight: 800;
      color: var(--navy);
      letter-spacing: -.5px;
      line-height: 1.2;
      margin-bottom: 16px;
    }
    .maintenance-sub {
      color: var(--text-muted);
      font-size: 16px;
      line-height: 1.7;
      max-width: 480px;
      margin: 0 auto 36px;
    }
    .maintenance-contacts {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 16px;
      margin-bottom: 32px;
      text-align: left;
    }
    .maintenance-contact {
      background: var(--bg-soft);
      border-radius: 12px;
      padding: 18px 20px;
    }
    .maintenance-contact .mc-label {
      font-size: 12px;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: .5px;
      color: var(--blue);
      margin-bottom: 6px;
    }
    .maintenance-contact .mc-value {
      font-size: 15px;
      color: var(--navy);
      font-weight: 600;
      line-height: 1.5;
      word-break: break-word;
    }
    .maintenance-contact a.mc-value:hover {
      color: var(--blue);
    }
    .maintenance-action {
      display: flex;
      justify-content: center;
      gap: 14px;
      flex-wrap: wrap;
      margin-bottom: 28px;
    }
    .maintenance-refresh {
      background: var(--blue);
      color: #fff;
      border-color: var(--blue);
    }
    .maintenance-refresh:hover {
      background: #1d4ed8;
      border-color: #1d4ed8;
    }
    .maintenance-note {
      font-size: 13px;
      color: var(--text-muted);
      margin-top: 4px;
    }
    @media(max-width:600px) {
      .maintenance-card {
        padding: 36px 24px;
      }
      .maintenance-title {
        font-size: 26px;
      }
      .maintenance-contacts {
        grid-template-columns: 1fr;
      }
    }
  </style>
</head>
<body>
  <div class="maintenance-wrap">
    <div class="maintenance-card">
      <img src="{{ asset('frontend/images/logo-website.png') }}" alt="Bank Waway Lampung" class="maintenance-logo">
      <h1 class="maintenance-title">Sedang Dalam Pemeliharaan Terjadwal</h1>
      <p class="maintenance-sub">
        Terima kasih atas kesabaran Anda. Saat ini kami sedang melakukan perbaikan dan peningkatan layanan untuk
        memberikan pengalaman yang lebih baik. Silakan kembali lagi beberapa saat lagi.
      </p>
      <div class="maintenance-contacts">
        <div class="maintenance-contact">
          <div class="mc-label">Layanan Nasabah</div>
          <a class="mc-value" href="tel:+0721266869">+0721 266 869</a>
        </div>
        <div class="maintenance-contact">
          <div class="mc-label">WhatsApp</div>
          <a class="mc-value" href="https://wa.me/6285382659996">+62 853-8265-9996</a>
        </div>
        <div class="maintenance-contact">
          <div class="mc-label">Email</div>
          <a class="mc-value" href="mailto:Bankwawaylampung@yahoo.com">Bankwawaylampung@yahoo.com</a>
        </div>
        <div class="maintenance-contact">
          <div class="mc-label">Jam Operasional</div>
          <span class="mc-value">Senin - Jumat<br>08.00 - 15.00 WIB</span>
        </div>
      </div>
      <div class="maintenance-action">
        <button type="button" class="btn maintenance-refresh" onclick="location.reload()">Muat Ulang Halaman</button>
      </div>
      <p class="maintenance-note">Bank Waway Lampung · Terima kasih telah mempercayakan layanan kami.</p>
    </div>
  </div>
</body>
</html>
