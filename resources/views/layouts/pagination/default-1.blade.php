@if ($paginator->hasPages())
    <nav class="text-center" aria-label="Page Navigation">
        <ul class="list-inline">

            {{-- Previous Page Link --}}
            @php
                $status = $paginator->onFirstPage() ? 'u-pagination-v1__item--disabled' : '';
            @endphp
            <li class="list-inline-item float-sm-left {{ $status }}">
                <a class="u-pagination-v1__item g-brd-around g-bg-gray-dark-v3 g-color-white g-bg-gray-dark-v2--hover g-pa-7-14"
                   href="{{ $paginator->previousPageUrl() }}" aria-label="Previous">
                        <span aria-hidden="true">
                          <i class="fa fa-angle-left g-mr-5"></i>
                            {{ trans('pagination.previous') }}
                        </span>
                    <span class="sr-only">{{ trans('pagination.previous') }}</span>
                </a>
            </li>

            {{-- Pagination Elements --}}
            <li class="list-inline-item hidden-down">
                {{ trans('pagination.pageof', [
                    'page' => $paginator->currentPage(), 'total' => $paginator->lastPage()
                ]) }}
            </li>


            {{-- Next Page Link --}}
            @php
                $status = $paginator->hasMorePages() ? '' : 'u-pagination-v1__item--disabled';
            @endphp
            <li class="list-inline-item float-sm-right">
                <a class="u-pagination-v1__item g-brd-around g-bg-gray-dark-v3 g-color-white g-bg-gray-dark-v2--hover g-pa-7-14"
                   href="{{ $paginator->nextPageUrl() }}" aria-label="Next">
                        <span aria-hidden="true">
                          {{ trans('pagination.next') }}
                          <i class="fa fa-angle-right g-ml-5"></i>
                        </span>
                    <span class="sr-only">{{ trans('pagination.next') }}</span>
                </a>
            </li>

        </ul>
    </nav>
@endif
