<style>
    .disabled {
        pointer-events: none;
        cursor: default;
        opacity: 0.6;
    }
</style>

@if ($paginator->hasPages())
<ul class="pagination pagination-sm m-0 mt-3 float-right">
    @if ($paginator->onFirstPage())
        <li class="page-item"><a class="page-link disabled" href="#">&laquo;</a></li>
    @else
    <li class="page-item"><a class="page-link" href="#">&laquo;</a></li>
    @endif


    <li class="page-item"><a class="page-link" href="#">1</a></li>
    <li class="page-item"><a class="page-link" href="#">2</a></li>
    <li class="page-item"><a class="page-link" href="#">3</a></li>
    <li class="page-item"><a class="page-link" href="#">&raquo;</a></li>
</ul>
@endif