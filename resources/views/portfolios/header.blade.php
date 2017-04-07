<!-- portfolio header -->
<div class="ct-panel__ct-header">

    <header class="ct-header">

        @if (isset($portfolios))

            <h3 class="title"><a href="/portfolios/{{ $portfolio->id }}"> {{ $portfolio->name }}</a></h3>

        @else

            <h3 class="title">{{ $portfolio->name }}</h3>
            <a href="/portfolios/{{ $portfolio->id }}/edit" class="link">
                <icon class="glyphicon glyphicon-pencil"></icon>Bearbeiten</a>

        @endif


        <div class="ct-header__key-figures">
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