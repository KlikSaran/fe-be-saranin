@if ($paginator->hasPages())
    {{-- Desktop Pagination --}}
    <ul class="pagination">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <li class="page-item disabled">
                <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Previous</a>
            </li>
        @else
            <li class="page-item">
                <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev">Previous</a>
            </li>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <li class="page-item disabled"><span class="page-link">{{ $element }}</span></li>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="page-item active" aria-current="page">
                            <span class="page-link">{{ $page }}</span>
                        </li>
                    @else
                        <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li class="page-item">
                <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next">Next</a>
            </li>
        @else
            <li class="page-item disabled">
                <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Next</a>
            </li>
        @endif
    </ul>

    {{-- Mobile Pagination --}}
    <div class="pagination-mobile">
        @if ($paginator->onFirstPage())
            <span class="page-link-mobile disabled">Sebelumnya</span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="page-link-mobile">Sebelumnya</a>
        @endif

        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="page-link-mobile">Berikutnya</a>
        @else
            <span class="page-link-mobile disabled">Berikutnya</span>
        @endif
    </div>

@endif