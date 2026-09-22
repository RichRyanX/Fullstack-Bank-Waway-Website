@extends('layouts.public')

@section('title', 'Bank Waway Lampung - Informasi')

@section('content')

<section class="section informasi-head">
  <div class="container">
    <h1>Informasi Terbaru</h1>
    <p>Dapatkan pembaruan terkini mengenai kebijakan perbankan, rilis fitur baru, dan pengumuman resmi dari Bank Waway
      Lampung untuk mendukung aktivitas finansial Anda.</p>

    <div class="search-filter-row">
      <div class="search-box">🔍 <input type="text" placeholder="Cari informasi..."></div>
      <div class="filter-chips">
        <a href="{{ route('public.berita.index') }}" class="chip {{ is_null($activeCategory) ? 'active' : '' }}" data-filter="semua">Semua</a>
        @foreach($categories ?? [] as $category)
        <a href="{{ route('public.berita.index', ['category' => $category]) }}" class="chip {{ $activeCategory === $category ? 'active' : '' }}" data-filter="{{ strtolower($category) }}">{{ ucfirst($category) }}</a>
        @endforeach
      </div>
    </div>

    @if($news->isNotEmpty())
    <div class="info-grid">
      @foreach($news as $item)
      <article class="info-card" data-category="{{ strtolower($item->category ?? 'informasi') }}">
        <div class="thumb">
          <span class="info-tag {{ strtolower($item->category ?? 'pengumuman') }}">{{ $item->category ?? 'Informasi' }}</span>
          <img src="{{ $item->image ?? asset('admin/images/Bangunan.png') }}" alt="{{ $item->title ?? 'Informasi' }}">
        </div>
        <div class="body">
          <div class="info-date">📅 {{ optional($item->published_at ?? $item->created_at)->format('d M Y') ?? '' }}</div>
          <h4>{{ $item->title ?? 'Informasi Bank Waway' }}</h4>
          <p>{{ $item->excerpt ?? '' }}</p>
          <div class="info-download"><a href="{{ route('public.berita.show', ['id' => $item->id]) }}">Baca Selengkapnya →</a><span>{{ strtoupper($item->category ?? 'INFO') }}</span></div>
        </div>
      </article>
      @endforeach
    </div>

    <div class="pagination">
      {{ $news->links('vendor.pagination.default') }}
    </div>
    @endif
  </div>
</section>

@endsection
