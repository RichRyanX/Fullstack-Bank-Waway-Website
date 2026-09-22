<footer class="footer">
  <div class="container">
    <div class="footer-grid">
      <div class="footer-info">
        <h5>Bank Waway Lampung</h5>
        <p>📍 <a href="https://maps.app.goo.gl/XXQFDXPrbKguNWnZ9?g_st=aw" target="_blank" rel="noopener">Jl.
            Diponegoro No.28, Gulak Galik, Kec. Tlk. Betung Utara, Kota Bandar Lampung, Lampung 35212</a></p>
        <p>📞 <a href="https://api.whatsapp.com/send/?phone=6285382659996&text&type=phone_number&app_absent=0"
            target="_blank" rel="noopener">+0721 266 869</a></p>
        <p>✉️ <a href="mailto:Bankwawaylampung@yahoo.com">Bankwawaylampung@yahoo.com</a></p>
        <div class="footer-social">
          <a href="https://www.facebook.com/BankWawayLampung/" target="_blank" rel="noopener"
            aria-label="Facebook">f</a>
          <a href="https://www.instagram.com/bankwawaylampung/" target="_blank" rel="noopener"
            aria-label="Instagram">◎</a>
          <a href="https://wa.me/6285382659996" target="_blank" rel="noopener" aria-label="WhatsApp">✆</a>
        </div>
      </div>
      <div>
        <h6>Tautan Cepat</h6>
        <ul>
          <li><a href="https://api.whatsapp.com/send/?phone=6285382659996&text&type=phone_number&app_absent=0">Layanan
              Nasabah</a></li>
          <li><a href="{{ route('public.profil.tempat-kedudukan') }}">Lokasi Kantor Kas</a></li>
          <li><a href="{{ route('public.deposito.index') }}#simulasi">Suku Bunga</a></li>
          <li><a href="{{ route('public.karir.index') }}">Karir</a></li>
          <li><a href="{{ route('public.whistleblowing.index') }}">Whistleblowing System</a></li>
        </ul>
      </div>
      <div>
        <h6>Produk</h6>
        <ul>
          <li><a href="{{ route('public.tabungan.index') }}">Tabungan</a></li>
          <li><a href="{{ route('public.kredit.pinjaman') }}">Pinjaman</a></li>
          <li><a href="{{ route('public.deposito.index') }}">Deposito</a></li>
          <li><a href="https://api.whatsapp.com/send/?phone=6285382659996&text&type=phone_number&app_absent=0">Layanan
              Digital</a></li>
          <li><a href="{{ route('public.kontak.index') }}">iBanking</a></li>
        </ul>
      </div>
    </div>
    <div class="footer-bottom">© {{ date('Y') }} Bank Waway Lampung. All Rights Reserved.</div>
  </div>
</footer>
