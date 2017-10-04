<div class="row">

    <div class="btn-element">
        <a data-toggle="modal" href="#deposit" class="btn btn-default">Cash einzahlen</a>
    </div>

    <div class="btn-element">
        <a data-toggle="modal" href="#withdraw" class="btn btn-default">Cash auszahlen</a>
    </div>

    <div class="btn-element">
        <a class="btn btn-default disabled">Kredit aufnehmen</a>
    </div>

    <div class="btn-element">
        <a data-toggle="modal" href="#searchStocks" class="btn btn-default">Aktien hinzufügen</a>
    </div>

    <div class="btn-element">
        <a class="btn btn-default disabled">Fonds hinzufügen</a>
    </div>

</div>

<div id="searchStocks" class="modal fade">
    <search-stock
            portfolio-id="{{ $portfolio->id }}"
            instrument-type="{{ \App\Entities\Stock::class }}"
            submit-route="{{ route('positions.create', [$portfolio->slug, '%entity%', '%instrument%'], false) }}">
    </search-stock>
</div>

<div id="deposit" class="modal fade">
    <cash-trade
            route="{{ route('portfolios.pay', [], false) }}"
            cash="{{ $portfolio->cash() }}"
            id="{{ $portfolio->id }}"
            transaction="deposit">
    </cash-trade>
</div>

<div id="withdraw" class="modal fade">
    <cash-trade
            route="{{ route('portfolios.pay', [], false) }}"
            cash="{{ $portfolio->cash() }}"
            id="{{ $portfolio->id }}"
            transaction="withdraw">
    </cash-trade>
</div>
