@extends('layouts.master')

@section('content-main')


    @unless ( $portfolio->payments->count() )
        <div class="alert alert-info alert-dismissible role=" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            <strong>Noch keine Transaktionen vorhanden.</strong>
        </div>
    @endunless

    <div class="u-heading-v3-1 g-mb-40">
        <h2 class="h3 u-heading-v3__title">Transaktionen</h2>
    </div>

    <table class="table table-hover u-table-v1">
        <thead class="thead-default">
        <tr>
            <th>
                <p class="g-ma-0">Transaktion</p>
                <p class="g-ma-0">Datum</p>
                <p class="g-ma-0 d-md-none">Stückzahl</p>
            </th>
            <th>
                <p class="g-ma-0">Name</p>
                <p class="g-ma-0">ISIN / WKN</p>
            </th>
            <th>
                <p class="g-ma-0">Handelsplatz</p>
                <p class="g-ma-0">Preis</p>
                <p class="g-ma-0 d-md-none">Gesamt</p>
            </th>
            <th class="d-none d-md-table-cell">
                <p class="g-ma-0">Stückzahl</p>
                <p class="g-ma-0">Total</p>
            </th>
        </tr>
        </thead>

        <tbody>

        @foreach($payments as $payment)

            <tr>
                <td class="align-middle">
                    <p class="g-ma-0">
                            <span class="u-label {{$payment->present()->paymentTypeLabel }}">
                                {{ $payment->present()->paymentType }}
                            </span>
                    </p>
                    <p class="g-ma-0">{{ $payment->present()->date }}</p>
                    <p class="g-ma-0 d-md-none">{{ $payment->present()->amount }}</p>
                </td>
                <td class="align-middle">
                    <p class="g-ma-0">
                        @if ($name = $payment->present()->name)
                            <a href="{{ route('positions.show',[$portfolio, $payment->asset->type, $payment->asset->slug])  }}">
                                {{ $payment->present()->name}}
                            </a>
                        @else
                            {{ $payment->present()->description }}
                        @endif

                    </p>
                    <p class="g-ma-0">
                        {{ $payment->present()->isin }}
                        @if ($wkn = $payment->present()->wkn ) / {{ $wkn }} @endif
                    </p>
                </td>
                <td class="align-middle">
                    <p class="g-ma-0">{{ $payment->present()->exchange }}</p>
                    <p class="g-ma-0">{{ $payment->present()->price }}</p>
                    <p class="g-ma-0 d-md-none">{{ $payment->present()->total }}</p>

                </td>
                <td class="align-middle d-none d-md-table-cell">
                    <p class="g-ma-0">{{ $payment->present()->amount }}</p>
                    <p class="g-ma-0">{{ $payment->present()->total }}</p>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div class="col-12">
        {{ $payments->links('layouts.pagination.default-2') }}
    </div>

@endsection


