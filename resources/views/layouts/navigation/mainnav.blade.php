<div class="mainnav">
    <div class="container">

        <a class="mainnav-toggle" data-toggle="collapse" data-target=".mainnav-collapse">
            <span class="sr-only">Toggle navigation</span>
            <i class="fa fa-bars"></i>
        </a>

        <nav class="collapse mainnav-collapse" role="navigation">
            <ul class="mainnav-menu">

                @include('layouts.dropdowns.portfolios')

                @if ((!isset($focus)) and isset($portfolio))

                    <li class="{{ active_class(if_route('portfolios.show')) }}">
                        <a href="{{ route('portfolios.show', $portfolio->id) }}">
                            Dashboard
                        </a>
                    </li>

                    <li class="{{ active_class(if_route_pattern(['transactions.*'])) }}">
                        <a href="{{ route('transactions.index', $portfolio->id) }}">
                            Transaktionen
                        </a>
                    </li>

                    <li class="{{ active_class(if_route_pattern(['positions.*'])) }}">
                        <a href="{{ route('positions.index', $portfolio->id) }}">
                            Positionen
                        </a>
                    </li>

                    <li class="">
                        <a href="{{ route('risks.index', $portfolio->id) }}">
                            Risiko
                        </a>
                    </li>

                    <li class="dropdown {{ active_class(if_route('portfolios.edit')) }}">
                        <a href="./index.html" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown">
                            Einstellungen
                            <i class="mainnav-caret"></i>
                        </a>

                        <ul class="dropdown-menu" role="menu">

                            <li>
                                <a href="{{ route('portfolios.edit', ['id' => $portfolio->id, 'tab' => 'portfolio']) }}">
                                    <i class="fa fa-pie-chart" aria-hidden="true"></i>
                                    Portfolio
                                </a>
                            </li>

                            <li>
                                <a href="{{ route('portfolios.edit', ['id' => $portfolio->id, 'tab' => 'parameter']) }}">
                                    <i class="fa fa-calculator" aria-hidden="true"></i>
                                    Parameter
                                </a>
                            </li>

                            <li>
                                <a href="{{ route('portfolios.edit', ['id' => $portfolio->id, 'tab' => 'limits']) }}">
                                    <i class="fa fa-bar-chart" aria-hidden="true"></i>
                                    Limite
                                </a>
                            </li>

                            <li>
                                <a href="{{ route('portfolios.edit', ['id' => $portfolio->id, 'tab' => 'notifications']) }}">
                                    <i class="fa fa-envelope" aria-hidden="true"></i>
                                    Benachichtigungen
                                </a>
                            </li>

                        </ul>

                    </li>
                @endif

            </ul>

        </nav>

    </div> <!-- /.container -->

</div> <!-- /.mainnav -->