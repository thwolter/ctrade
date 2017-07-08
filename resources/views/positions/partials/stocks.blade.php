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
                    <a href="{{ route('positions.show', ['id' => $position->id]) }}">
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
                    <div class="buy-sell-icons text-center">
                        <a href="{{ route('positions.buy', ['id' => $position->id]) }}">
                            <i class="fa fa-plus-square buy-icon" aria-hidden="true"></i>
                        </a>
                        <a href="{{ route('positions.sell', ['id' => $position->id]) }}">
                            <i class="fa fa-minus-square sell-icon" aria-hidden="true"></i>
                        </a>
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <a data-toggle="modal" href="#searchStocks" class="btn btn-default">Neue Position</a>

</portlet>

<div id="searchStocks" class="modal fade">
    <search-stock
            route="{{ route('search.stock', [], false) }}"
            lookup="{{ route('search.lookup', [], false) }}"
            cash="{{ $portfolio->cash }}">
    </search-stock>
</div>

@section('scripts.footer')
    <script>
        $('#searchStocks').on('hidden.bs.modal', function () {
            Event.fire('resetSearch');
        });
    </script>
@endsection