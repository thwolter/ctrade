@extends('layouts.portfolio')

@section('container-content')

    <div class="container">
        @if (count($portfolio->transactions)== 0)
            @include('positions.partials.empty')
        @endif

        @if (count($portfolio->transactions) > 0)
            <h3>Transaktionen</h3>
            <div class="space-40"></div>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Nr</th>
                        <th>Datum</th>
                        <th>Transaktion</th>
                        <th>Position</th>
                        <th class="pull-right">Stück</th>
                        <th class="pull-right">Betrag</th>
                    </tr>
                </thead>

                <tbody>
                    @php( $count = 0)
                    @foreach($portfolio->transactions as $transaction)
                        @php ($instrument = $transaction->instrumentable)
                        <tr>
                            <td class="align-middle">{{ ++$count }}</td>
                            <td class="align-middle">{{ $transaction->present()->date }}</td>
                            <td class="align-middle">{{ $transaction->present()->type }}</td>
                            <td class="align-middle">
                                <h5><a href="{{ route('transactions.show', [$portfolio->id, 'id' => $transaction->id]) }}">
                                        {{ $transaction->present()->name}}</a></h5>
                                <span>
                                    {{ $instrument->typeDisp}} | {{ $instrument->wkn }}
                                    | {{ $instrument->isin }}
                                </span>
                            </td>
                            <td class="align-middle pull-right">{{ $transaction->amount }}</td>
                            <td class="align-middle pull-right">
                                {{ $transaction->present()->total() }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="space-20"></div>
            {!! Form::open(['route' => ['positions.create', $portfolio->id], 'method' => 'Get']) !!}
                <div class="pull-right">
                    {!! Form::submit('Neue Transaktion', ['class' => 'btn theme-btn-color']) !!}
                </div>
            {!! Form::close() !!}
        @endif

    </div>
@endsection


