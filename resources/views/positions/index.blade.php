@extends('portfolios.show')

@section('container-content')

    <dl>
        <dt>Barbestand:</dt>
        <dd>{{ $portfolio->cash() }} {{ $portfolio->currency }}</dd>
    </dl>

    <hr>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Nr.</th>
                <th>Tpye</th>
                <th>Name</th>
                <th>Anzahl</th>
                <th>Preis</th>
                <th>Gesamt</th>
            </tr>
        </thead>

        <tfoot>
            <tr>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th>Summe</th>
                <th>{{ $portfolio->total() }}</th>
            </tr>
        </tfoot>

        <tbody>
            @php( $count = 0)
            @foreach($portfolio->positions as $position)

                <tr>
                    <td>{{ ++$count }}</td>
                    <td>{{ $position->type() }}</td>
                    <td><a href="{{ route('positions.show', ['pid' => $portfolio->id, 'id' => $position->id]) }}">{{ $position->name() }}</a></td>
                    <td>{{ $position->amount() }}</td>
                    <td>{{ $position->present()->price() }}</td>
                    <td>{{ $position->present()->total() }}</td>
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


