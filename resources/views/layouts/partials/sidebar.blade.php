<div class="col-lg-3 order-lg-1 g-brd-right--lg g-brd-gray-light-v4 g-mb-80">
    <div class="g-pr-20--lg">

        @php
            $activeClass = 'g-bg-bluegray-lineargradient g-brd-none g-color-gray-light-v4';
        @endphp

        <h3 class="h5 g-color-black g-font-weight-600 mb-4">Portfolio</h3>

        <!-- Links -->
        <div class="list-group g-mb-50">

            <a class="list-group-item list-group-item-action {{ if_route('portfolios.show') ? $activeClass : 'g-color-gray-dark-v2' }}"
               href="{{ route('portfolios.show', $portfolio->slug) }}">
                <i class="mr-2 fa fa-angle-right"></i>@lang('navigation.dashboard')
            </a>

            <a class="list-group-item list-group-item-action {{ if_route_pattern(['transactions.*']) ? $activeClass : 'g-color-gray-dark-v2' }}"
               href="{{ route('payments.index', $portfolio->slug) }}">
                <i class="mr-2 fa fa-angle-right"></i>@lang('navigation.transactions')
            </a>

            <a class="list-group-item list-group-item-action {{ if_route_pattern(['positions.*', 'assets.*']) ? $activeClass : 'g-color-gray-dark-v2' }}"
               href="{{ route('positions.index', $portfolio->slug) }}">
                <i class="mr-2 fa fa-angle-right"></i>@lang('navigation.positions')
            </a>

            <a class="list-group-item list-group-item-action g-color-gray-dark-v2"
               href="{{ route('home.coming') }}">
                <i class="mr-2 fa fa-angle-right"></i>@lang('navigation.optimize')
            </a>

            <a class="list-group-item list-group-item-action {{ if_route('portfolios.edit') ? $activeClass : 'g-color-gray-dark-v2' }}"
               href="{{ route('portfolios.edit', ['slug' => $portfolio->slug]) }}">
                <i class="mr-2 fa fa-angle-right"></i>@lang('navigation.settings.title')
            </a>

        </div>

        <!-- Transaction button -->
        <div class="drowdown g-mb-50">

            <a class="dropdown-toggle btn btn-block btn-outline-secondary g-color-white-opacity-0_9--hover rounded-0 btn-md"
                  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                     Neue Transaktion
                </a>
            <div class="dropdown-menu rounded-0 g-mt-10">
                <div class="list-group">
                    <a class="dropdown-item list-group-item list-group-item-action"
                       href="{{ route('payments.create', $portfolio) }}">
                        <i class="icon-layers g-font-size-12 g-color-gray-dark-v5 g-mr-5"></i>Ein-/Auszahlung
                    </a>
                    <a class="dropdown-item list-group-item list-group-item-action"
                       href="{{ route('positions.search', $portfolio) }}">
                        <i class="icon-layers g-font-size-12 g-color-gray-dark-v5 g-mr-5"></i>Aktien
                    </a>
                </div>
            </div>

        </div>
    </div>
</div>



