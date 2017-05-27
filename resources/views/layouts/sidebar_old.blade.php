
<nav class="sidebar hidden-xs">

    <!-- manage portfolios -->
    <div id="sidebar-nav-manage">
        <ul class="nav nav-pills nav-stacked">
            <li><p>Manage Portfolios</p></li>
            <li class="active"><a href="{{ route('portfolios.index') }}">Portfolio wählen</a></li>
            <li><a href="{{ route('portfolios.create') }}">Neu anlegen</a></li>
            <li><a href="#">Löschen</a></li>
        </ul><br>
    </div>

    <!-- analyse portfolios -->
    <div id ="sidebar-nav-portfolio">
        <ul class="nav nav-pills nav-stacked">
            <li><p>Portfolio</p></li>
            <li><a href="#">Marktwert</a></li>
            <li><a href="#">Transaktionen</a></li>
            <li><a href="#">Historie</a></li>
            <li><a href="#">Limite</a></li>
            <li><a href="#">Risiko</a></li>
            <li><a href="#">Optimieren</a></li>
        </ul><br>
    </div>

    <!-- sidebar footer -->
    <div id="sidebar-nav-others">
        <ul class="nav nav-pills nav-stacked">
            <li><a href="#">Einstellungen</a></li>
            <li><a href="#">Newsletter</a></li>
        </ul><br>
    </div>
</nav> <!-- end sidebar navigation -->