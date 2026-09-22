@if ($paginator->hasPages())
<nav class="pagination-nav" role="navigation" aria-label="Navigasi Halaman">
  @if ($paginator->onFirstPage())
  <span class="page-link page-disabled" aria-disabled="true">&laquo;</span>
  @else
  <a href="{{ $paginator->previousPageUrl() }}" class="page-link" rel="prev">&laquo;</a>
  @endif

  @foreach ($elements as $element)
    @if (is_string($element))
    <span class="page-link page-disabled">{{ $element }}</span>
    @endif
    @if (is_array($element))
      @foreach ($element as $page => $url)
        @if ($page == $paginator->currentPage())
        <span class="page-link page-current" aria-current="page">{{ $page }}</span>
        @else
        <a href="{{ $url }}" class="page-link">{{ $page }}</a>
        @endif
      @endforeach
    @endif
  @endforeach

  @if ($paginator->hasMorePages())
  <a href="{{ $paginator->nextPageUrl() }}" class="page-link" rel="next">&raquo;</a>
  @else
  <span class="page-link page-disabled" aria-disabled="true">&raquo;</span>
  @endif
</nav>
@endif
