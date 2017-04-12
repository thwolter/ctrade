<!-- portfolio header -->
<div class="ct-panel__ct-header">

    <header class="ct-header">


        @if (isset($portfolios))

            <!-- header if portfolio list is shown-->
            <h3 class="title"><a href="{{ route('portfolios.show', $portfolio->id) }}"> {{ $portfolio->name }}</a></h3>

        @else

            <!-- header for a single portfolio -->
            <h3 class="title">{{ $portfolio->name }}</h3>
            <a href="{{ route('portfolios.edit', $portfolio->id) }}" class="link">
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