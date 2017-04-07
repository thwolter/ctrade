<!-- portfolio header -->
<div class="portfolio-container__portfolio-header">

    <header class="portfolio-header">
        <a href="/portfolios/{{ $portfolio->id }}">
            <h3 class="title">{{ $portfolio->name }}</h3>
        </a>
        <a href="/portfolios/edit/{{ $portfolio->id }}" class="link">
            <icon class="glyphicon glyphicon-pencil"></icon>Bearbeiten
        </a>

        <div class="portfolio-header__key-figures">
            <div class="key-figure">
                <label class="label">Aktuell</label>
                <span class="value">1.200,33</span>
            </div>

            <div class="key-figure">
                <label class="label">Risiko</label>
                <span class="value">234,43</span>
            </div>
        </div>
    </header>
</div>