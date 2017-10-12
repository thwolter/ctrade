<div class="col-lg-3 order-lg-1 g-brd-right--lg g-brd-gray-light-v4 g-mb-80">
    <div class="g-pr-20--lg">

        <div class="g-md-55">
            <a class="btn btn-outline-secondary g-mr-10 g-mb-50"
               href="#">Neue Transaktion</a>
        </div>

    @php
        $activeClass = 'g-bg-bluegray-lineargradient g-brd-none g-color-gray-light-v4';
    @endphp

    <!-- Links -->
        <div class="list-group g-mb-50">
            <h3 class="h5 g-color-black g-font-weight-600 mb-4">Portfolio</h3>

            <a class="list-group-item {{ if_route('portfolios.show') ? $activeClass : 'g-color-gray-dark-v2' }}"
               href="{{ route('portfolios.show', $portfolio->slug) }}">
                <i class="mr-2 fa fa-angle-right"></i>@lang('navigation.dashboard')
            </a>

            <a class="list-group-item {{ if_route_pattern(['transactions.*']) ? $activeClass : 'g-color-gray-dark-v2' }}"
               href="{{ route('transactions.index', $portfolio->slug) }}">
                <i class="mr-2 fa fa-angle-right"></i>@lang('navigation.transactions')
            </a>

            <a class="list-group-item {{ if_route_pattern(['positions.*', 'assets.*']) ? $activeClass : 'g-color-gray-dark-v2' }}"
               href="{{ route('positions.index', $portfolio->slug) }}">
                <i class="mr-2 fa fa-angle-right"></i>@lang('navigation.positions')
            </a>

            <a class="list-group-item g-color-gray-dark-v2"
               href="{{ route('home.coming') }}">
                <i class="mr-2 fa fa-angle-right"></i>@lang('navigation.optimize')</a>

            <a class="list-group-item {{ if_route('portfolios.edit') ? $activeClass : 'g-color-gray-dark-v2' }}"
               href="{{ route('portfolios.edit', ['slug' => $portfolio->slug]) }}">
                <i class="mr-2 fa fa-angle-right"></i>@lang('navigation.settings.title')</a>
        </div>
    </div>
</div>

