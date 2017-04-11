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
                <th>Währung</th>
                <th>Gesamt</th>
                <th>Währung</th>
            </tr>
        </thead>

        <tfoot>
            <tr>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th>Summe</th>
                <th>{{ $portfolio->total() }}</th>
                <th>{{ $portfolio->currency }}</th>
            </tr>
        </tfoot>

        <tbody>
            @php( $count = 0)
            @foreach($positions as $position)
                <tr>
                    <td>{{ ++$count }}</td>
                    <td>{{ $position->type() }}</td>
                    <td><a href="{{ route('positions.show', $position->id) }}">{{ $position->name() }}</a></td>
                    <td>{{ $position->quantity() }}</td>
                    <td>{{ $position->value() }}</td>
                    <td>{{ $position->currency() }}</td>
                    <td>{{ $position->total() }}</td>
                    <td>{{ $portfolio->currency }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <form>

        <div class="form-group">
            <a href="/portfolios/{{ $portfolio->id }}/positions/create" class="button--right">Neue Position</a>
        </div>

    </form>


    <!-- Form with method  -->
    {!! Form::open(['route' => ['positions.create', $portfolio->id], 'method' => 'GET']) !!}

        {{ Form::input('search', 'q', null, ['placeholder' => 'Search ...', 'class' => 'form-control'])  }}

    {!! Form::close() !!}

@endsection


