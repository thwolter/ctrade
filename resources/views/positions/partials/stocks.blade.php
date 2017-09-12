@php
    $assets = $portfolio->assets()->ofType(\App\Entities\Stock::class)->get();
@endphp

    <portlet title="Aktien">
        <div class="table-responsive">
            <table class="table table-striped table-hover positions-table">
                <thead>
                <tr>
                    <th>Nr</th>
                    <th>Position</th>
                    <th>ISIN</th>
                    <th>Updated</th>
                    <th class="text-right">Preis</th>
                    <th class="text-right">Stück</th>
                    <th class="text-right">Gesamt</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($assets as $asset)

                    @php
                        $stock = $asset->positionable;
                    @endphp

                    <tr class="">
                        <td class="align-middle">{{ $loop->iteration }}</td>
                        <td class="align-middle">
                            <a href="{{ route('positions.show', [$portfolio->slug, $stock->slug]) }}">
                                {{ $stock->name }}</a>
                        </td>
                        <td>{{ $stock->present()->isin }}</td>
                        <td>{{ $stock->present()->priceDate() }}</td>
                        <td class="align-middle text-right">{{ $stock->present()->price() }}</td>
                        <td class="align-middle text-right">{{ $asset->present()->amount() }}</td>
                        <td class="align-middle text-right">
                            {{ $asset->present()->value() }}
                            @if ($stock->currencyCode() != $portfolio->currencyCode())
                                <div>({{ $asset->present->value($portfolio->currencyCode()) }})</div>
                            @endif
                        </td>

                        <td class="align-middle col-md-1">
                            <buy-sell-btn
                                    instrument-id="{{ $asset->id }}"
                                    event-buy="buyStock"
                                    event-sell="sellStock"
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
            instrument-type="{{ get_class($stock) }}"
            submit-route="{{ route('positions.update', [], false) }}">
    </trade-stock>


@section('scripts.footer')
    <script>
        $('#searchStocks').on('hidden.bs.modal', function () {
            Event.fire('resetSearch');
        });
    </script>
@endsection