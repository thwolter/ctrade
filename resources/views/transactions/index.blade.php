@extends('layouts.master')

@section('content')

    <div class="content">
        <div class="container">
            @if (count($portfolio->transactions)== 0)
                <div class="alert alert-info alert-dismissible role=" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <strong>Noch keine Transaktionen vorhanden.</strong>
                </div>
            @endif

            <portlet title="Transaktionen">
                <table class="table table-striped table-hover">
                    <thead>
                    <tr>
                        <th>Nr</th>
                        <th>Datum</th>
                        <th>Transaktion</th>
                        <th class="align-middle text-right">Stück</th>
                        <th>Position</th>
                        <th>Preis</th>
                        <th class="align-middle text-right">Gesamt</th>
                    </tr>
                    </thead>

                    <tbody>

                        @foreach(array_reverse($portfolio->transactions->all()) as $transaction)
                            @php ($instrument = $transaction->instrumentable)
                            <tr class="h5">
                                <td class="align-middle">{{ $loop->iteration }}</td>
                                <td class="align-middle">{{ $transaction->present()->date }}</td>
                                <td class="align-middle">{{ $transaction->present()->type }}</td>
                                <td class="align-middle text-right">{{ $transaction->amount }}</td>
                                <td class="align-middle">
                                    <a href="{{ route('transactions.show', [$portfolio->id, 'id' => $transaction->id]) }}">
                                            {{ $transaction->present()->name}}</a>
                                    <span>
                                        {{ $instrument->typeDisp}} | {{ $instrument->wkn }}
                                        | {{ $instrument->isin }}
                                    </span>
                                </td>
                                <td class="align-middle text-right">{{ $transaction->present()->price() }}</td>
                                <td class="align-middle text-right">{{ $transaction->present()->total() }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </portlet>
        </div>
    </div>

@endsection


