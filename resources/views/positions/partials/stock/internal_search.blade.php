<!-- Search container for internal api usage -->
<div id="searchStocks" class="modal fade">
    <search-stock
            create="{{ route('positions.create', [$portfolio->slug, null, null], false) }}"
            cash="{{ $portfolio->cash }}"
            pid="{{ $portfolio->id }}"
            entity="{{ \App\Entities\Stock::class }}">
    </search-stock>
</div>