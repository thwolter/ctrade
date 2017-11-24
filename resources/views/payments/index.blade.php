@extends('layouts.master')

@section('content')

    @include('layouts.partials.header')

    <div class="container g-pt-100 g-pb-20">
        <div class="row justify-content-between">

            <!-- Sidebar -->
        @include('layouts.partials.sidebar')

        <!-- Main section -->
            <div class="col-lg-9 order-lg-2 g-mb-80">

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

                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="thead-default">
                        <tr>
                            <th>Nr</th>
                            <th>Datum</th>
                            <th>Transaktion</th>
                            <th>Typ</th>
                            <th>Position</th>
                            <th>ISIN</th>
                            <th class="text-center">Stück</th>
                            <th class="text-right">Preis</th>
                            <th class="text-right">Gesamt</th>
                        </tr>
                        </thead>

                        <tbody>

                        @foreach($payments as $payment)

                            @php $isin = $payment->present()->isin @endphp
                            <tr class="">
                                <td class="align-middle">{{ $loop->iteration }}</td>
                                <td class="align-middle">{{ $payment->present()->date() }}</td>
                                <td class="align-middle">{{ $payment->present()->paymentType() }}</td>
                                <td class="align-middle">{{ $payment->present()->instrumentType() }}</td>
                                <td class="align-middle">
                                    <a href="{{ route('positions.show',[$portfolio, $stock->type(), $stock->slug])  }}">
                                        {{ $payment->present()->name}}
                                    </a>
                                </td>
                                <td>{{ $payment->present()->isin() }}</td>
                                <td class="text-center">{{ $payment->present()->amount() }}</td>
                                <td class="text-right">{{ $payment->present()->price() }}</td>
                                <td class="text-right">{{ $payment->present()->total() }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>

@endsection


