<nav class="ct-nav">
    <ul>
        <li><a href="#">Überblick</a></li>
        <li class="{{ active_class(if_route_pattern(['positions.*'])) }}">
            <a href="{{ route('positions.index', [$portfolio->id]) }}">Transaktionen</a>
        </li>
        <li><a href="#">Marktwerte</a></li>
        <li><a href="#">Risiko</a></li>
        <li><a href="#">Optimieren</a></li>
    </ul>
</nav>