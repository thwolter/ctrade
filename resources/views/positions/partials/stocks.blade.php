@php( $positions = $portfolio->positions()->wherePositionableType('stock')->get() )

<portlet title="Aktien">
    <table class="table table-striped table-hover positions-table">
        <thead>
        <tr>
            <th>Nr</th>
            <th>Position</th>
            <th>ISIN</th>
            <th>WKN</th>
            <th class="text-right">Preis</th>
            <th class="text-right">Stück</th>
            <th class="text-right">Gesamt</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @foreach($positions as $position)

            <tr class="h5">
                <td class="align-middle">{{ $loop->iteration }}</td>
                <td class="align-middle">
                    <a href="{{ route('positions.show', [$portfolio->id, $position->id]) }}">
                        {{ $position->name() }}</a>
                    <span>
                            ({{ $position->present()->priceDate() }})
                        </span>
                </td>
                <td>{{ $position->positionable->isin }}</td>
                <td>{{ $position->positionable->wkn }}</td>
                <td class="align-middle text-right">{{ $position->present()->price() }}</td>
                <td class="align-middle text-right">{{ $position->amount() }}</td>
                <td class="align-middle text-right">
                    {{ $position->present()->total() }}
                    @if ($position->currencyCode() != $portfolio->currencyCode())
                        <div>({{ $position->present()->total($portfolio->currencyCode()) }})</div>
                    @endif
                </td>

                <td class="align-middle">
                    <buy-sell-btn id="{{ $position->id }}" event-buy="buyStock" event-sell="sellStock"
                                  toggle="false" inline-template>
                        <div class="buy-sell-icons text-center">
                            <button @click="doBuy" class="btn-link">
                                <i class="fa fa-plus-square buy-icon" aria-hidden="true"></i>
                            </button>

                            <button @click="doSell" class="btn-link">
                                <i class="fa fa-minus-square sell-icon" aria-hidden="true"></i>
                            </button>
                        </div>
                    </buy-sell-btn>
                </td>
            </tr>

        @endforeach
        </tbody>
    </table>

    <a data-toggle="modal" href="#searchStocks" class="btn btn-default ">Neue Position</a>

</portlet>

<!-- Search container -->
<div id="searchStocks" class="modal fade">
    <search-stock
            route="{{ route('search.stock', [], false) }}"
            lookup="{{ route('search.lookup', [], false) }}"
            store="{{ route('positions.store', $portfolio->id, false) }}"
            cash="{{ $portfolio->cash }}">
    </search-stock>
</div>

<trade-stock
        route="{{ route('positions.update', [], false) }}"
        lookup="{{ route('positions.fetch', [], false) }}">
</trade-stock>

@section('scripts.footer')
    <script>
        $('#searchStocks').on('hidden.bs.modal', function () {
            Event.fire('resetSearch');
        });
    </script>
@endsection