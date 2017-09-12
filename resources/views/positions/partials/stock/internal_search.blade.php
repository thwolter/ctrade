<!-- Search container for internal api usage -->
<div id="searchStocks" class="modal fade">
    <search-stock
            create-route="{{ route('positions.create', [$portfolio->slug, null, null], false) }}"
            cash="{{ $portfolio->cash() }}"
            portfolio-id="{{ $portfolio->id }}"
            instrument-type="{{ \App\Entities\Stock::class }}">
    </search-stock>
</div>