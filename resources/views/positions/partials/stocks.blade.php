@php( $positions = $portfolio->positions()->wherePositionableType('stock')->get() )

    <portlet title="Aktien">
        <div class="table-responsive">
            <table class="table table-striped table-hover positions-table">
                <thead>
                <tr>
                    <th>Nr</th>
                    <th>Position</th>
                    <th>ISIN</th>
                    <th>Börse</th>
                    <th>Updated</th>
                    <th class="text-right">Preis</th>
                    <th class="text-right">Stück</th>
                    <th class="text-right">Gesamt</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($positions as $position)

                    <tr class="">
                        <td class="align-middle">{{ $loop->iteration }}</td>
                        <td class="align-middle">
                            <a href="{{ route('positions.show', $position->id) }}">
                                {{ $position->name() }}</a>
                        </td>
                        <td>{{ $position->positionable->isin }}</td>
                        <td>{{ $position->present()->exchange }}</td>
                        <td>{{ $position->present()->priceDate() }}</td>
                        <td class="align-middle text-right">{{ $position->present()->price() }}</td>
                        <td class="align-middle text-right">{{ $position->amount() }}</td>
                        <td class="align-middle text-right">
                            {{ $position->present()->total() }}
                            @if ($position->currencyCode() != $portfolio->currencyCode())
                                <div>({{ $position->present()->total($portfolio->currencyCode()) }})</div>
                            @endif
                        </td>

                        <td class="align-middle col-md-1">
                            <buy-sell-btn id="{{ $position->id }}" event-buy="buyStock" event-sell="sellStock"
                                          toggle="false">
                            </buy-sell-btn>
                        </td>
                    </tr>

                @endforeach
                </tbody>
            </table>
        </div>

        <a data-toggle="modal" href="#searchStocks" class="btn btn-default ">Neue Position</a>

    </portlet>


    @include('positions.partials.stock.internal_search')

    {{--@include('positions.partials.stock.algolia_search')--}}


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