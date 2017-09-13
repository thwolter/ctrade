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
                        <a href="{{ route('assets.show', [$portfolio->slug, $stock->slug]) }}">
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
                        <div class="row buy-sell-icons text-center">
                            <div class="col-md-2 col-md-push-2">
                                <a href="{{ route('positions.buyStock', [$portfolio->slug, $asset->slug]) }}"
                                   class="btn-link">
                                    <i class="fa fa-plus-square buy-icon" aria-hidden="true"></i>
                                </a>
                            </div>
                            <div>
                                <a href="{{ route('positions.sellStock', [$portfolio->slug, $asset->slug]) }}"
                                   class="btn-link">
                                    <i class="fa fa-minus-square sell-icon" aria-hidden="true"></i>
                                </a>
                            </div>
                        </div>

                    </td>
                </tr>

            @endforeach
            </tbody>
        </table>
    </div>

    <a data-toggle="modal" href="#searchStocks" class="btn btn-default ">Neue Position</a>

</portlet>


<div id="searchStocks" class="modal fade">
    <search-stock
            portfolio-id="{{ $portfolio->id }}"
            instrument-type="{{ \App\Entities\Stock::class }}"
            submit-route="{{ route('positions.create', [$portfolio->slug, null, null], false) }}">
    </search-stock>
</div>


@section('scripts.footer')
    <script>
        $('#searchStocks').on('hidden.bs.modal', function () {
            Event.fire('resetSearch');
        });
    </script>
@endsection