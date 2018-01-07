@if($paginator->hasPages())
<div class="row">
    <nav aria="Pagination">
        <ul class="pagination">
            @if($paginator->onFirstPage())
            <li class="page-item disabled">
                <span aria-hidden="true" class="page-link">&laquo;</span>
                <span class="sr-only">Previous</span>
            </li>
            @else
            <li class="page-item">
                <a class="page-item" href="{{ $paginator->previousPageUrl() }}">
                    <span class="page-link" aria-hidden="true">&laquo;</span>
                    <span class="sr-only">Previous</span>
                </a>
            </li>
            @endif

            @foreach($elements as $element)
                @if(is_string($element))
                <li class="page-item disabled"><span class="page-link">{{ $element }}</span></li>
                @endif

                @if(is_array($element))
                    @foreach($element as $page => $url)
                        @if($page == $paginator->currentPage())
                        <li class="page-item active">
                            <span class="page-link">{{ $page }}</span>
                        </li>
                        @else
                        <li class="page-item">
                            <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                        </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            @if($paginator->hasMorePages())
            <li class="page-item">
                <a class="page-item" href="{{ $paginator->nextPageUrl() }}">
                    <span class="page-link" aria-hidden="true">&raquo;</span>
                    <span class="sr-only">Next</span>
                </a>
            </li>
            @else
            <li class="page-item disabled">
                <span class="page-link" aria-hidden="true">&raquo;</span>
                <span class="sr-only">Next</span>
            </li>
            @endif
        </ul>
    </nav>
</div>
@endif