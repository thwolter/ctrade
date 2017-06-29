<div class="mainnav">
    <div class="container">

        <a class="mainnav-toggle" data-toggle="collapse" data-target=".mainnav-collapse">
            <span class="sr-only">Toggle navigation</span>
            <i class="fa fa-bars"></i>
        </a>

        <nav class="collapse mainnav-collapse" role="navigation">
            <ul class="mainnav-menu">

                <li class="dropdown pull-right {{ active_class(if_route_pattern(['portfolios.index'])) }}">
                    <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown">
                        @if (if_route(['portfolios.index']))
                            Meine Portfolios
                        @elseif (isset($focus)) 
                            {{ $focus }} 
                        @elseif (isset($portfolio)) 
                            {{ $portfolio->name }}
                        @endif
                        <i class="mainnav-caret"></i>
                    </a>

                    <ul class="dropdown-menu" role="menu">

                        <li>
                            <a href="{{ route('portfolios.create') }}">
                                <i class="fa fa-plus dropdown-icon "></i>
                                Neues Portfolio
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('portfolios.index') }}">
                                <i class="fa fa-edit dropdown-icon "></i>
                                Übersicht
                            </a>
                        </li>

                        @if (Auth::user()->portfolios->count())
                            <div class="separator"></div>
                        @endif

                        @foreach (Auth::user()->portfolios as $portfolio)
                            <li>
                                <a href="{{ route('portfolios.show', $portfolio->id) }}">
                                    <i class="fa fa-angle-double-right dropdown-icon "></i>
                                    {{ $portfolio->name }}
                                </a>
                            </li>
                        @endforeach

                    </ul>
                </li>

                @if ((!isset($focus)) and isset($portfolio))

                    <li class="{{ active_class(if_route(['portfolios.show'])) }}">
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

                    <li class="">
                        <a href="#">
                            Optimieren
                        </a>
                    </li>
                @endif
            </ul>

        </nav>

    </div> <!-- /.container -->

</div> <!-- /.mainnav -->