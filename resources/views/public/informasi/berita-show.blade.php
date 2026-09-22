@extends('layouts.public')

@section('title', ($item->title ?? 'Informasi') . ' - Bank Waway Lampung')

@section('content')

<section class="section informasi-head">
  <div class="container">
    <a href="{{ route('public.berita.index') }}" class="back-link">&larr; Kembali ke Informasi</a>

    <article class="info-card">
      <div class="body">
        <div class="info-date">📅 {{ optional($item->published_at ?? $item->created_at)->format('d M Y') ?? '' }}</div>
        <span class="info-tag {{ strtolower($item->category ?? 'pengumuman') }}">{{ $item->category ?? 'Informasi' }}</span>
        <h1 class="info-title">{{ $item->title ?? 'Berita' }}</h1>
        <div class="article-body">
          @forelse($item->content_blocks ?? [] as $block)
          <p>{{ $block['text'] }}</p>
          @empty
          <p>{{ $item->content ?? '' }}</p>
          @endforelse
        </div>
      </div>
    </article>

    <a href="{{ route('public.berita.index') }}" class="back-link back-link-bottom">&larr; Kembali ke Informasi</a>
  </div>
</section>

@endsection
