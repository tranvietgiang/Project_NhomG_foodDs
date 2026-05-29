@if ($paginator->hasPages())
    <nav class="fd-pagination" role="navigation" aria-label="Phân trang">
        <div class="fd-pagination-info">
            Hiển thị {{ $paginator->firstItem() }} đến {{ $paginator->lastItem() }}
            trong tổng số {{ $paginator->total() }} kết quả
        </div>

        <div class="fd-pagination-links">
            @if ($paginator->onFirstPage())
                <span class="fd-page-link disabled">Trước</span>
            @else
                <a class="fd-page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev">Trước</a>
            @endif

            @foreach ($elements as $element)
                @if (is_string($element))
                    <span class="fd-page-link disabled">{{ $element }}</span>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span class="fd-page-link active">{{ $page }}</span>
                        @else
                            <a class="fd-page-link" href="{{ $url }}">{{ $page }}</a>
                        @endif
                    @endforeach
                @endif
            @endforeach

            @if ($paginator->hasMorePages())
                <a class="fd-page-link" href="{{ $paginator->nextPageUrl() }}" rel="next">Sau</a>
            @else
                <span class="fd-page-link disabled">Sau</span>
            @endif
        </div>
    </nav>
@endif
