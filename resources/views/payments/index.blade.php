@extends('layouts.master')

@section('content')

    @unless ( $portfolio->payments->count() )
        <div class="alert alert-info alert-dismissible role=" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            <strong>Noch keine Transaktionen vorhanden.</strong>
        </div>
    @endunless

    <portlet title="Transaktionen">
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
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
                                <a href="{{ route('transactions.show', [$portfolio->id, 'id' => $payment->id]) }}">
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

    </portlet>

@endsection


