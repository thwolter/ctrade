<nav class="sidebar-nav">
    <ul class="nav flex-column">

        <li class="my-nav-item">
            <a class="nav-link {{ active_class(if_route_pattern(['portfolios.*'])) }}"
               href="{{ route('portfolios.show', $portfolio->id) }}">Überblick</a>
        </li>

        <li class="my-nav-item">
            <a class="nav-link {{ active_class(if_route_pattern(['transactions.*'])) }}"
               href="{{ route('transactions.index', $portfolio->id) }}">Transaktionen</a>
        </li>

        <li class="my-nav-item">
            <a class="nav-link {{ active_class(if_route_pattern(['positions.*'])) }}"
               href="{{ route('positions.index', $portfolio->id) }}">Positionen</a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ active_class(if_route_pattern(['return.*'])) }}"
               href="#">Entwicklung</a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ active_class(if_route_pattern(['risks.*'])) }}"
               href="{{ route('risks.index', $portfolio->id) }}">Risiko</a></li>

        <li class="nav-item">
            <a class="nav-link" href="#">Optimieren</a></li>

        <li class="nav-item">
            <a class="nav-link {{ active_class(if_route_pattern(['edit*'])) }}"
               href="{{ route('portfolios.edit', $portfolio->id) }}">Einstellungen</a>
        </li>
    </ul>
</nav>

