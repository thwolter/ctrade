@if ($paginator->hasPages())
    <nav class="text-center" aria-label="Page Navigation">
        <ul class="list-inline">

            {{-- Previous Page Link --}}
            @php
                $status = $paginator->onFirstPage() ? 'u-pagination-v1__item--disabled' : '';
            @endphp
            <li class="list-inline-item {{ $status }}">
                <a class="u-pagination-v1__item u-pagination-v1-3 g-pa-4-13"
                   href="{{ $paginator->previousPageUrl() }}" aria-label="Previous">
                        <span aria-hidden="true">
                          <i class="fa fa-angle-left g-mr-5"></i>
                            {{ trans('pagination.previous') }}
                        </span>
                    <span class="sr-only">{{ trans('pagination.previous') }}</span>
                </a>
            </li>


            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="list-inline-item g-hidden-sm-down"><span class="g-pa-4-11">{{ $element }}</span></li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="list-inline-item g-hidden-sm-down-item active">
                                <span class="u-pagination-v1__item u-pagination-v1-3 u-pagination-v1-3--active g-pa-4-11">{{ $page }}</span>
                            </li>
                        @else
                            <li class="list-inline-item g-hidden-sm-down">
                                <a class="u-pagination-v1__item u-pagination-v1-3 g-pa-4-11" href="{{ $url }}">{{ $page }}</a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach


            {{-- Next Page Link --}}
            @php
                $status = $paginator->hasMorePages() ? '' : 'u-pagination-v1__item--disabled';
            @endphp
            <li class="list-inline-item">
                <a class="u-pagination-v1__item u-pagination-v1-3 g-pa-4-13"
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
