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

            <a class="collapsed list-group-item list-group-item-action
                    {{ if_route_pattern(['payments.*']) ? $activeClass : 'g-color-gray-dark-v2' }}"
               href="#transaction-menu" data-toggle="collapse" aria-expanded="false">
                <i class="mr-2 fa fa-angle-right"></i>@lang('navigation.transactions')
                <span class="ml-3 fa fa-angle-down"></span>
            </a>

            <div id="transaction-menu" class="collapse">
                <div class="list-group">
                    <a class="list-group-item list-group-item-action g-pl-50"
                       href="{{ route('payments.index', $portfolio->slug) }}">
                        <i class="mr-2 fa fa-angle-right"></i>Überblick
                    </a>
                    <a class="list-group-item list-group-item-action g-pl-50"
                       href="{{ route('payments.create', $portfolio) }}">
                        <i class="mr-2 fa fa-angle-right"></i>Ein-/Auszahlung
                    </a>
                    <a class="list-group-item list-group-item-action g-pl-50 g-brd-bottom-0"
                       href="{{ route('positions.search', $portfolio) }}">
                        <i class="mr-2 fa fa-angle-right"></i>Aktien
                    </a>
                </div>
            </div>


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

            <a class="list-group-item list-group-item-action {{ if_route('portfolios.edit') ? $activeClass : 'g-color-gray-dark-v2' }}"
               href="#transaction-menu">
                <i class="mr-2 fa fa-angle-right"></i>@lang('navigation.settings.title')
            </a>

        </div>
    </div>
</div>



