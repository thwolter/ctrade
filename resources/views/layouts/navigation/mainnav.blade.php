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

                    <li class="{{ active_class(if_route_pattern(['transactions.*'])) }}">
                        <a href="{{ route('transactions.index', $portfolio->slug) }}">
                            @lang('navigation.transactions')
                        </a>
                    </li>

                    <li class="{{ active_class(if_route_pattern(['positions.*'])) }}">
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

    </div> <!-- /.container -->

</div> <!-- /.mainnav -->