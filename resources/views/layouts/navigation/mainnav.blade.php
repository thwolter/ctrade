<div class="mainnav">
    <div class="container">

        <a class="mainnav-toggle" data-toggle="collapse" data-target=".mainnav-collapse">
            <span class="sr-only">@lang('navigations.toggle')</span>
            <i class="fa fa-bars"></i>
        </a>

        <nav class="collapse mainnav-collapse" role="navigation">
            <ul class="mainnav-menu">

                @include('layouts.dropdowns.portfolios')

                @if ((!isset($focus)) and isset($portfolio))

                    <li class="{{ active_class(if_route('portfolios.show')) }}">
                        <a href="{{ route('portfolios.show', $portfolio->slug) }}">
                            @lang('navigation.dashboard')
                        </a>
                    </li>

                    <li class="dropdown {{ active_class(if_route_pattern(['transactions.*'])) }}">
                        <a class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown">
                            @lang('navigation.transactions')
                            <i class="mainnav-caret"></i>
                        </a>

                        <ul class="dropdown-menu" role="menu">

                            <li>
                                <a href="{{ route('payments.index', $portfolio->slug) }}">
                                    <i class="fa fa-pie-chart" aria-hidden="true"></i>
                                    @lang('navigation.transaction.overview')

                                </a>
                            </li>

                            <li>
                                <a data-toggle="modal" href="#deposit">
                                    <i class="fa fa-plus-square-o" aria-hidden="true"></i>
                                    @lang('navigation.transaction.deposit')
                                </a>
                            </li>

                            <li>
                                <a data-toggle="modal" href="#withdraw">
                                    <i class="fa fa-minus-square-o" aria-hidden="true"></i>
                                    @lang('navigation.transaction.withdrawal')

                                </a>
                            </li>

                            <li>
                                <a data-toggle="modal" href="#searchStocks">
                                    <i class="fa fa-pie-chart" aria-hidden="true"></i>
                                    Aktien hinzufügen
                                </a>
                            </li>


                        </ul>
                    </li>

                    <li class="{{ active_class(if_route_pattern(['positions.*', 'assets.*'])) }}">
                        <a href="{{ route('positions.index', $portfolio->slug) }}">
                            @lang('navigation.positions')
                        </a>
                    </li>

                    <li class="">
                        <a href="{{ route('home.coming') }}">
                            @lang('navigation.optimize')
                        </a>
                    </li>

                    <li class="dropdown {{ active_class(if_route('portfolios.edit')) }}">
                        <a href="./index.html" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown">
                            @lang('navigation.settings.title')
                            <i class="mainnav-caret"></i>
                        </a>

                        <ul class="dropdown-menu" role="menu">

                            <li>
                                <a href="{{ route('portfolios.edit', ['slug' => $portfolio->slug, 'tab' => 'portfolio']) }}">
                                    <i class="fa fa-pie-chart" aria-hidden="true"></i>
                                    @lang('navigation.settings.portfolio')
                                </a>
                            </li>

                            <li>
                                <a href="{{ route('portfolios.edit', ['slug' => $portfolio->slug, 'tab' => 'parameter']) }}">
                                    <i class="fa fa-calculator" aria-hidden="true"></i>
                                    @lang('navigation.settings.parameter')
                                </a>
                            </li>

                            <li>
                                <a href="{{ route('portfolios.edit', ['slug' => $portfolio->slug, 'tab' => 'limits']) }}">
                                    <i class="fa fa-bar-chart" aria-hidden="true"></i>
                                    @lang('navigation.settings.limits')
                                </a>
                            </li>

                            <li>
                                <a href="{{ route('portfolios.edit', ['slug' => $portfolio->slug, 'tab' => 'dashboard']) }}">
                                    <i class="fa fa-tachometer" aria-hidden="true"></i>
                                    @lang('navigation.settings.dashboard')
                                </a>
                            </li>

                            <li>
                                <a href="{{ route('portfolios.edit', ['slug' => $portfolio->slug, 'tab' => 'notifications']) }}">
                                    <i class="fa fa-envelope" aria-hidden="true"></i>
                                    @lang('navigation.settings.message')
                                </a>
                            </li>

                        </ul>

                    </li>
                @endif

            </ul>

        </nav>
    </div>
</div>

<div id="searchStocks" class="modal fade">
    <search-stock
            portfolio-id="{{ $portfolio->id }}"
            instrument-type="{{ \App\Entities\Stock::class }}"
            submit-route="{{ route('positions.create', [$portfolio->slug, '%entity%', '%instrument%'], false) }}">
    </search-stock>
</div>

<div id="deposit" class="modal fade">
    <cash-trade
            route="{{ route('portfolios.pay', [], false) }}"
            cash="{{ $portfolio->cash() }}"
            id="{{ $portfolio->id }}"
            transaction="deposit">
    </cash-trade>
</div>

<div id="withdraw" class="modal fade">
    <cash-trade
            route="{{ route('portfolios.pay', [], false) }}"
            cash="{{ $portfolio->cash() }}"
            id="{{ $portfolio->id }}"
            transaction="withdraw">
    </cash-trade>
</div>