@extends('layouts.master')

@section('content')

    @if (count($portfolio->transactions)== 0)
        <div class="alert alert-info alert-dismissible role=" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            <strong>Noch keine Transaktionen vorhanden.</strong>
        </div>
    @endif

    <portlet title="Transaktionen">
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                <tr>
                    <th>Nr</th>
                    <th>Datum</th>
                    <th>Transaktion</th>
                    <th>Typ</th>
                    <th class="align-middle text-right">Stück</th>
                    <th>Position</th>
                    <th>Preis</th>
                    <th class="align-middle text-right">Gesamt</th>
                </tr>
                </thead>

                <tbody>

                @foreach(array_reverse($portfolio->transactions->all()) as $transaction)

                    @php $isin = $transaction->present()->isin @endphp
                        <tr class="">
                            <td class="align-middle">{{ $loop->iteration }}</td>
                            <td class="align-middle">{{ $transaction->present()->date }}</td>
                            <td class="align-middle">{{ $transaction->present()->type }}</td>
                            <td class="align-middle">{{ $transaction->present()->instrument }}</td>
                            <td class="align-middle text-right">{{ $transaction->amount }}</td>
                            <td class="align-middle">
                                <a href="{{ route('transactions.show', [$portfolio->id, 'id' => $transaction->id]) }}">
                                    {{ $transaction->present()->name}} @if($isin) ({{ $isin }}) @endif
                                </a>
                            </td>
                            <td class="align-middle text-right">{{ $transaction->present()->price() }}</td>
                            <td class="align-middle text-right">{{ $transaction->present()->total() }}</td>
                        </tr>
                        @endforeach
                </tbody>
            </table>
        </div>

    </portlet>

@endsection


