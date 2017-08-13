<!-- Search container for internal api usage -->
<div id="searchStocks" class="modal fade">
    <search-stock
            store="{{ route('positions.store', [], false) }}"
            cash="{{ $portfolio->cash }}"
            pid="{{ $portfolio->id }}"
            entity="{{ \App\Entities\Stock::class }}">
    </search-stock>
</div>