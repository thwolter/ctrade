<!-- portfolio header -->
<div class="portfolio-panel__portfolio-header">

    <header class="portfolio-header">

        @if (isset($portfolios))

            <h3 class="title"><a href="/portfolios/{{ $portfolio->id }}"> {{ $portfolio->name }}</a></h3>

        @else

            <h3 class="title">{{ $portfolio->name }}</h3>
            <a href="/portfolios/edit/{{ $portfolio->id }}" class="link">
                <icon class="glyphicon glyphicon-pencil"></icon>Bearbeiten</a>

        @endif


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