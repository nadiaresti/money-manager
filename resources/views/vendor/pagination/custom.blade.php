<style>
    .disabled {
        pointer-events: none;
        cursor: default;
        opacity: 0.6;
    }
</style>

@if ($paginator->hasPages())
<ul class="pagination pagination-sm m-0 mt-3 float-right">
    {{-- Previous Page Link --}}
    @if ($paginator->onFirstPage())
        <li class="page-item"><a class="page-link disabled" href="#">&laquo;</a></li>
    @else
        <li class="page-item"><a class="page-link" href="{{ $paginator->previousPageUrl() }}">&laquo;</a></li>
    @endif

    {{-- Pagination Elements --}}
    @foreach ($elements as $each)
        @if (is_string($each))
            <li class="page-item disabled"><span>{{ $each }}</span></li>
        @endif

        @if (is_array($each))
            @foreach ($each as $page => $url)
                @if ($page == $paginator->currentPage())
                    <li class="page-item active"><a class="page-link disabled">{{ $page }}</a></li>
                @else
                    <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                @endif
            @endforeach
        @endif
    @endforeach

    {{-- Next Page Link --}}
    @if ($paginator->hasMorePages())
        <li class="page-item"><a class="page-link" href="{{ $paginator->nextPageUrl() }}">&raquo;</a></li>
    @else
        <li class="page-item"><a class="page-link disabled" href="#">&raquo;</a></li>
    @endif
</ul>
@endif