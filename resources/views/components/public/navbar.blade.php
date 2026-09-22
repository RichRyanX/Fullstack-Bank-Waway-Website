<header class="navbar">
  <div class="container navbar-inner">
    <a href="{{ route('home') }}" class="brand">
      <img src="{{ asset('frontend/images/logo-website.png') }}" alt="Bank Waway Lampung" class="brand-logo-img">
    </a>
    <nav>
      <ul class="nav-menu">
        <li><a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Beranda</a></li>
        <li class="has-dropdown">
          <a href="{{ route('public.kredit.pinjaman') }}" class="{{ request()->routeIs('public.deposito.*') || request()->routeIs('public.kredit.*') || request()->routeIs('public.tabungan.*') ? 'active' : '' }}">Produk</a>
          <ul class="dropdown">
            <li><a href="{{ route('public.deposito.index') }}" class="{{ request()->routeIs('public.deposito.*') ? 'active' : '' }}">Deposito</a></li>
            <li><a href="{{ route('public.kredit.pinjaman') }}" class="{{ request()->routeIs('public.kredit.*') ? 'active' : '' }}">Pinjaman</a></li>
            <li><a href="{{ route('public.tabungan.index') }}" class="{{ request()->routeIs('public.tabungan.*') ? 'active' : '' }}">Tabungan</a></li>
          </ul>
        </li>
        <li><a href="{{ route('public.profil.index') }}" class="{{ request()->routeIs('public.profil.*') ? 'active' : '' }}">Profil</a></li>
        <li><a href="{{ route('public.berita.index') }}" class="{{ request()->routeIs('public.berita.index') || request()->routeIs('public.berita.show') ? 'active' : '' }}">Informasi</a></li>
        <li class="has-dropdown">
          <a href="{{ route('public.laporan.index') }}" class="{{ request()->routeIs('public.governance.*') || request()->routeIs('public.laporan.*') || request()->routeIs('public.layanan.*') ? 'active' : '' }}">Laporan</a>
          <ul class="dropdown">
            <li><a href="{{ route('public.governance.laporan-tahunan') }}" class="{{ request()->routeIs('public.governance.laporan-tahunan') ? 'active' : '' }}">Laporan Tahunan</a></li>
            <li><a href="{{ route('public.governance.laporan-keberlanjutan') }}" class="{{ request()->routeIs('public.governance.laporan-keberlanjutan') ? 'active' : '' }}">Laporan Keberlanjutan</a></li>
            <li><a href="{{ route('public.laporan.index') }}">Laporan Publikasi</a></li>
            <li><a href="{{ route('public.governance.tata-kelola') }}" class="{{ request()->routeIs('public.governance.tata-kelola') ? 'active' : '' }}">Tata Kelola / GCG</a></li>
            <li><a href="{{ route('public.layanan.index') }}" class="{{ request()->routeIs('public.layanan.*') ? 'active' : '' }}">Pelayanan</a></li>
          </ul>
        </li>
        <li><a href="{{ route('public.bantuan.index') }}" class="{{ request()->routeIs('public.bantuan.index') ? 'active' : '' }}">Bantuan</a></li>
        <li><a href="{{ route('public.karir.index') }}" class="{{ request()->routeIs('public.karir.*') ? 'active' : '' }}">Karier</a></li>
      </ul>
    </nav>
    <div class="navbar-actions">
      <a href="{{ route('public.whistleblowing.index') }}" class="btn-wbs {{ request()->routeIs('public.whistleblowing.index') ? 'active' : '' }}">WBS</a>
    </div>
  </div>
</header>
