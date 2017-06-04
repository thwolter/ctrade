@extends('layouts.portfolio')

@section('container-content')

    <h3>Zusammenfassung</h3>
    <div class="space-20"></div>

    <div class="boxed-container">
        <table class="summary-table">
            <tr>
                <td class="table-key">Barbestand</td>
                <td class="pull-right table-value">{{ $portfolio->present()->cash() }}</td>
            </tr>
            <tr>
                <td class="table-key">Aktien</td>
                <td class="pull-right table-value">{{ $portfolio->present()->stockTotal() }}</td>
            </tr>
            <tfoot>
                <tr>
                    <th class="table-key">Gesamt</th>
                    <th class="pull-right table-value">{{ $portfolio->present()->total() }}</th>
                </tr>
            </tfoot>
        </table>
    </div>

    <div class="space-40"></div>

    <!-- Form with method Post -->
    {!! Form::open(['route' => ['positions.create', $portfolio->id], 'method' => 'Get']) !!}
        <div class="pull-right">
            {!! Form::submit('Neue Position', ['class' => 'btn theme-btn-color']) !!}
        </div>
    {!! Form::close() !!}

    <div class="space-70"></div>
    <h3>Aktien</h3>
    <div class="space-40"></div>
    <table class="table table-striped">

        <thead>
            <tr>
                <th>Nr</th>
                <th>Aktien</th>
                <th class="pull-right">Stück</th>
                <th class="pull-right">Gesamt</th>
                <th></th>
            </tr>
        </thead>

        <tbody>
            @php( $count = 0)
            @foreach($portfolio->positions as $position)
                <tr>
                    <td class="align-middle">{{ ++$count }}</td>
                    <td class="align-middle">
                        <h5><a href="{{ route('positions.show', ['pid' => $portfolio->id, 'id' => $position->id]) }}">
                                {{ $position->name() }}</a>
                        </h5>
                        <span>
                            {{ $position->typeDisp() }} | {{ $position->present()->price() }}
                            ({{ $position->present()->priceDate() }})
                        </span>
                    </td>
                    <td class="align-middle pull-right">{{ $position->amount() }}</td>
                    <td class="align-middle pull-right">
                        {{ $position->present()->total() }}
                        @if ($position->currencyCode() != $portfolio->currencyCode())
                            <span>{{ $position->present()->total($portfolio->currencyCode()) }}</span>
                        @endif
                    </td>

                    <td class="align-middle">
                        <p style="margin-bottom: 0px"><a href="{{ route('positions.buy', ['id' => $position->id]) }}">Zukaufen</a></p>
                        <p style="margin-bottom: 0px"><a href="{{ route('positions.sell', ['id' => $position->id]) }}">Verkaufen</a></p>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection


