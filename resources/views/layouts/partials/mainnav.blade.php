<div class="mainnav ">

    <div class="container">

        <a class="mainnav-toggle" data-toggle="collapse" data-target=".mainnav-collapse">
            <span class="sr-only">Toggle navigation</span>
            <i class="fa fa-bars"></i>
        </a>
        <nav class="collapse mainnav-collapse" role="navigation">

            <ul class="mainnav-menu">

                <li class="dropdown pull-right">
                    <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown">
                        Portfolios
                        <i class="mainnav-caret"></i>
                    </a>
                    <ul class="dropdown-menu" role="menu">
                        <li>
                            <a href="#">
                                <i class="fa fa-edit dropdown-icon "></i>
                                Neues Portfolio
                            </a>
                        </li>

                        <li>
                            <a href="#">
                                <i class="fa fa-edit dropdown-icon "></i>
                                Übersicht
                            </a>
                        </li>

                    </ul>
                </li>

                <li class="{{ active_class(if_route_pattern(['portfolios.*'])) }}">
                    <a href="{{ route('portfolios.show', $portfolio->id) }}">
                        Übersicht
                    </a>
                </li>

                <li class="{{ active_class(if_route_pattern(['transactions.*'])) }}">
                    <a href="{{ route('transactions.index', $portfolio->id) }}">
                        Transaktionen
                    </a>
                </li>

                <li class="">
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

            </ul>

        </nav>

    </div> <!-- /.container -->

</div> <!-- /.mainnav -->