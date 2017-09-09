<div>
    <portlet title="{{ $stock->name }}">
        <div class="col-md-3">
            <p><span>ISIN: </span>{{ $stock->isin }}</p>
            <p><span>WKN: </span>{{ $stock->wkn }}</p>
        </div>
        <div class="col-md-3">
            {{ $stock->present()->price() }}
        </div>
    </portlet>
</div>