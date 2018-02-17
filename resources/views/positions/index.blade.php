@extends('layouts.master')

@section('content-main')

    @unless ( $portfolio->payments->count() )
        <div class="alert alert-info alert-dismissible role=" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            <strong>Noch keine Positionen vorhanden.</strong>
        </div>
    @endunless


    <!-- Cash -->
    @component('layouts.components.section')

        @slot('title')
            Cashbestand
        @endslot

        <div class="table-responsive">
            <table class="table table-striped table-hover positions-table">
                <thead>
                <tr>
                    <th>Nr</th>
                    <th>Position</th>
                    <th class="text-right">Gesamt</th>
                </tr>
                </thead>
                <tbody>
                <tr class="">
                    <td class="align-middle">1</td>
                    <td class="align-middle">Cash</td>
                    <td class="text-right">{{ $portfolio->present()->balance() }}</td>
                    <td></td>
                </tr>
                </tbody>
            </table>

        </div>

    @endcomponent


    <!-- Stocks -->
    @component('layouts.components.section')

        @slot('title')
            Aktien
        @endslot

        <table class="table table-hover u-table-v1">
            <thead class="thead-default">
            <tr>
                <th>
                    <p class="g-ma-0">Name</p>
                    <p class="g-ma-0">ISIN / WKN</p>
                    <p class="g-ma-0">Gattung</p>
                </th>
                <th class="text-right">
                    <p class="g-ma-0">Einstandskurs</p>
                    <p class="g-ma-0">Investment</p>
                    <p class="g-ma-0">Veränderung</p>
                </th>
                <th class="text-right">
                    <p class="g-ma-0">Kurs</p>
                    <p class="g-ma-0">Datum</p>
                    <p class="g-ma-0">Handelsplatz</p>
                </th>
                <th class="text-right">
                    <p class="g-ma-0">Gesamtwert</p>
                    <p class="g-ma-0">Entwicklung abs.</p>
                    <p class="g-ma-0">Entwicklung %</p>
                </th>
                <th class="text-right">
                    <p class="g-ma-0">Stückzahl</p>
                    <p class="g-ma-0">Risiko abs.</p>
                    <p class="g-ma-0">Risiko %</p>
                </th>
            </tr>
            </thead>

            <tbody>
            @foreach($portfolio->assets as $asset)

                @php $stock = $asset->positionable @endphp

                <tr>
                    <td class="align-middle">
                        <p class="g-ma-0">
                            <a href="{{ route('positions.show', [$portfolio->slug, $asset->type, $asset->slug]) }}">
                                {{ $asset->present()->name }}
                            </a>
                        </p>
                        <p class="g-ma-0">
                            {{ $asset->present()->isin }}
                            @if ($wkn = $asset->present()->wkn ) / {{ $wkn }} @endif
                        </p>
                        <p class="g-ma-0">{{ $asset->present()->type }}</p>
                    </td>
                    <td class="align-middle text-right">
                        <p class="g-ma-0">{{ $asset->present()->cost }}</p>
                        <p class="g-ma-0">{{ $asset->present()->investment }}</p>
                        <p class="g-ma-0">{{ $asset->present()->deltaPosition }}</p>
                    </td>
                    <td class="align-middle text-right">
                        <p class="g-ma-0">{{ $asset->present()->price }}</p>
                        <p class="g-ma-0">{{ $asset->present()->priceDate }}</p>
                        <p class="g-ma-0">{{ $asset->present()->exchange }}</p>
                    </td>
                    <td class="align-middle text-right">
                        <p class="g-ma-0">{{ $asset->present()->value }}</p>
                        <p class="g-ma-0">{{ $asset->present()->returnAbsolute }}</p>
                        <p class="g-ma-0">{{ $asset->present()->convertedYieldPercent }}</p>
                    </td>
                    <td class="align-middle text-right">
                        <p class="g-ma-0">{{ $asset->present()->amount }}</p>
                        <p class="g-ma-0">{{ $asset->present()->risk() }}</p>
                        <p class="g-ma-0">{{ $asset->present()->riskToValueRatio() }}</p>
                    </td>
                </tr>

            @endforeach
            </tbody>
        </table>

    @endcomponent


@endsection


