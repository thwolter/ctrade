<div class="container boxed-container">
    <div class="row">
        <div class="col-md-6">
            <h3>{{ $item->name }}</h3>
            <span>{{ $item->typeDisp }}|{{ $item->isin }}|{{ $item->wkn }}</span>
        </div>
        <div class="col-md-3">
            <p class="value-caption">Preis</p>
            <span class="value-highlight neutral">{{ $item->present()->price() }}</span>
        </div>
        <div class="col-md-3">
            <p class="value-caption">Risiko</p>
            <span class="value-highlight red">{{ $item->present()->valueAtRisk() }}</span>
        </div>
    </div>
</div>