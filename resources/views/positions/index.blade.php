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
                    <td class="text-right">{{ $portfolio->present()->cash() }}</td>
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

        @php
            $assets = $portfolio->assets()->ofType(\App\Entities\Stock::class)->get();
        @endphp

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
                    <th class="text-right">Risiko</th>
                    <th class="text-right">Risiko (%)</th>
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
                        <td class="align-middle text-right">{{ $asset->present()->risk() }}</td>
                        <td class="align-middle text-right">{{ $asset->present()->riskRatio() }}</td>
                    </tr>

                @endforeach
                </tbody>
            </table>
        </div>

    @endcomponent


@endsection


