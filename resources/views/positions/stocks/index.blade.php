@php
    $assets = $portfolio->assets()->ofType(\App\Entities\Stock::class)->get();
@endphp

<div class="u-heading-v3-1 g-mb-40">
    <h2 class="h3 u-heading-v3__title">Aktien</h2>
</div>

<div class="table-responsive">
    <table class="table table-hover">
        <thead class="thead-default">
        <tr>
            <th>Nr</th>
            <th>Position</th>
            <th>ISIN</th>
            <th>Updated</th>
            <th class="text-right">Preis</th>
            <th class="text-center">Stück</th>
            <th class="text-right">Gesamt</th>
            <th></th>
        </tr>
        </thead>

        <tbody>
        @foreach($assets as $asset)

            @php $stock = $asset->positionable @endphp

            <tr>
                <td class="align-middle">{{ $loop->iteration }}</td>
                <td class="align-middle">
                    <a href="{{ route('assets.show', [$portfolio, $stock->slug]) }}">
                        {{ $stock->name }}</a>
                </td>
                <td class="align-middle">{{ $stock->present()->isin }}</td>
                <td class="align-middle">{{ $stock->present()->priceDate() }}</td>
                <td class="align-middle text-right">{{ $stock->present()->price() }}</td>
                <td class="align-middle text-center">{{ $asset->present()->amount() }}</td>
                <td class="align-middle text-right">
                    {{ $asset->present()->value() }}
                    @if ($stock->currency->code != $portfolio->currency->code)
                        <div>({{ $asset->present->value($portfolio->currency->code) }})</div>
                    @endif
                </td>

                <td class="align-middle">
                    <div>
                        <span>
                            <a href="{{ route('positions.tradeStock', [$portfolio->slug, $asset->slug, 'buy']) }}"
                               class="btn btn-xs btn-outline-secondary g-mr-10">
                            <i class="fa fa-plus"></i>
                            <span class="sr-only">Kaufen</span>
                        </a>
                        </span>
                        <span>
                             <a href="{{ route('positions.tradeStock', [$portfolio->slug, $asset->slug, 'sell']) }}"
                                class="btn btn-xs btn-outline-secondary">
                            <i class="fa fa-minus"></i>
                            <span class="sr-only">Verkaufen</span>
                        </a>
                        </span>

                    </div>

                </td>
            </tr>

        @endforeach
        </tbody>
    </table>
</div>

<a data-toggle="modal" href="#searchStocks" class="btn btn-outline-secondary g-mt-20">Aktien hinzufügen</a>


<div id="searchStocks" class="modal fade">
    <search-stock
            portfolio-id="{{ $portfolio->id }}"
            instrument-type="{{ \App\Entities\Stock::class }}"
            submit-route="{{ route('positions.create', [$portfolio->slug, '%entity%', '%instrument%'], false) }}">
    </search-stock>
</div>


@section('scripts.footer')
    <script>
        $('#searchStocks').on('hidden.bs.modal', function () {
            Event.fire('resetSearch');
        });
    </script>
@endsection