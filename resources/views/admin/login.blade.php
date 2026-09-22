<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Bank Waway - Admin CMS Login</title>
<link rel="stylesheet" href="{{ asset('admin/CSS/style.css') }}">
</head>
<body class="login-page">

  <div class="page">
    <div class="login-wrapper">

      <div class="brand">
        <img src="{{ asset('admin/images/logo-website.png') }}" alt="Bank Waway">
      </div>

      <!-- Login Card -->
      <div class="login-card">
        <h2>Selamat Datang</h2>
        <p class="subtitle">Silakan masuk ke akun administrator Anda.</p>

        <form id="loginForm">
          <div class="form-group">
            <label for="username">Username / Email</label>
            <div class="input-wrapper">
              <svg class="input-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                <circle cx="12" cy="7" r="4"></circle>
              </svg>
              <input type="text" id="username" name="username" placeholder="Masukkan username anda" autocomplete="username" value="admin">
            </div>
          </div>

          <div class="form-group">
            <div class="label-row">
              <label for="password">Password</label>
              <a href="#" class="forgot-link">Lupa Password?</a>
            </div>
            <div class="input-wrapper">
              <svg class="input-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
              </svg>
              <input type="password" id="password" name="password" placeholder="Masukkan password anda" autocomplete="current-password" value="admin">
              <button type="button" class="toggle-password" id="togglePassword" aria-label="Tampilkan password">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                  <circle cx="12" cy="12" r="3"></circle>
                </svg>
              </button>
            </div>
          </div>

          <button type="submit" class="btn-submit">
            Masuk
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M5 12h14"></path>
              <path d="M12 5l7 7-7 7"></path>
            </svg>
          </button>
        </form>

        <div class="divider">
        </div>
      </div>

      <!-- Two-Factor Authentication step -->
      <div class="login-card" id="twofaCard" hidden>
        <h2>Verifikasi Dua Faktor</h2>
        <p class="subtitle">Masukkan kode verifikasi 6 digit yang dikirim untuk melanjutkan login.</p>

        <form id="twofaForm">
          <div class="form-group">
            <label for="twofaCode">Kode Verifikasi</label>
            <div class="input-wrapper">
              <svg class="input-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
              </svg>
              <input type="text" id="twofaCode" name="twofaCode" placeholder="000000" inputmode="numeric" maxlength="6" autocomplete="one-time-code">
            </div>
          </div>

          <button type="submit" class="btn-submit">
            Verifikasi
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M5 12h14"></path>
              <path d="M12 5l7 7-7 7"></path>
            </svg>
          </button>
        </form>

        <p class="twofa-back">
          <a href="#" id="twofaBack">Kembali ke login</a>
        </p>
      </div>

      <p class="footer-text">© 2026 Bank Waway Lampung. Seluruh hak cipta dilindungi.</p>

    </div>
  </div>

<script src="{{ asset('admin/JS/script.js') }}"></script>
</body>
</html>
