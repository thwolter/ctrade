<div class="row">

    <div class="btn-element">
        <deposit-btn
                event-buy="depositCash" event-sell="withdrawCash">
        </deposit-btn>
    </div>

    <div class="btn-element">
        <withdraw-btn
                event-buy="depositCash" event-sell="withdrawCash">
        </withdraw-btn>
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

<cash-trade
        route="{{ route('portfolios.pay', [], false) }}"
        cash="{{ $portfolio->cash() }}"
        id="{{ $portfolio->id }}">
</cash-trade>