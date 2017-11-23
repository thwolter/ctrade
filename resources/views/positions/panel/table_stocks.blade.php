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
        </tr>
        </thead>

        <tbody>
        @foreach($assets as $asset)

            @php $stock = $asset->positionable @endphp

            <tr>
                <td class="align-middle">{{ $loop->iteration }}</td>
                <td class="align-middle">
                    <a href="{{ route('positions.show',
                    [$portfolio->slug, $stock->type(), $stock->slug]) }}">
                        {{ $stock->name }}
                    </a>
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
            </tr>

        @endforeach
        </tbody>
    </table>
</div>

@section('scripts.footer')

@endsection