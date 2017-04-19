@extends('portfolios.show')

@section('container-content')

    <dl>
        <dt>Barbestand:</dt>
        <dd>{{ $portfolio->present()->cash() }} </dd>
    </dl>

    <hr>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Nr.</th>
                <th>Tpye</th>
                <th>Name</th>
                <th class="table-cell-value">Anzahl</th>
                <th class="table-cell-value">Preis</th>
                <th class="table-cell-value">Gesamt</th>
                <th class="table-cell-value">{{ $portfolio->currency }}-Equivalent</th>
            </tr>
        </thead>

        <tfoot>
            <tr>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th class="table-cell-value">Summe</th>
                <th class="table-cell-value">{{ $portfolio->present()->total() }}</th>
                <th class="table-cell-value">{{ $portfolio->present()->total() }}</th>
            </tr>
        </tfoot>

        <tbody>
            @php( $count = 0)
            @foreach($portfolio->positions as $position)

                <tr>
                    <td>{{ ++$count }}</td>
                    <td>{{ $position->typeDisp() }}</td>
                    <td><a href="{{ route('positions.show', ['pid' => $portfolio->id, 'id' => $position->id]) }}">{{ $position->name() }}</a></td>
                    <td class="table-cell-value">{{ $position->amount() }}</td>
                    <td class="table-cell-value">{{ $position->present()->price() }}</td>
                    <td class="table-cell-value">{{ $position->present()->total() }}</td>
                    <td class="table-cell-value">{{ $position->present()->total($portfolio->currency) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Form with method Post -->
    {!! Form::open(['route' => ['positions.create', $portfolio->id], 'method' => 'Get']) !!}

        <div class="form-group">
            {!! Form::submit('Neue Position', ['class' => 'button--right']) !!}
        </div>

    {!! Form::close() !!}


@endsection


