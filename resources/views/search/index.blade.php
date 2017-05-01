@extends('portfolios.show')

@section('container-content')

    <!-- Form with method  -->
    {!! Form::open(['route' => ['search.index', $portfolio->id], 'method' => 'Get']) !!}

    @include('partials.errors')

    <!-- search form input -->
    <div class="form-group">
        {!! Form::label('search', 'Suchen:') !!}
        {!! Form::text('search', null, ['placeholder' => 'Search ...', 'class' => 'form-control']) !!}
    </div>

    <div class="form-group">
        {!! Form::submit('Suchen', ['class' => 'button--right']) !!}
    </div>


    {!! Form::close() !!}


    @if(isset($suggest))

    <table class="table table-striped">
        <thead>
        <tr>
            <th>Nr.</th>
            <th>Tpye</th>
            <th>Symbol</th>
            <th>Name</th>
            <th>Börse</th>
        </tr>
        </thead>

        <tbody>
        @php( $count = 0)
        @foreach($suggest as $item)
            <tr>
                <td>{{ ++$count }}</td>
                <td>{{ $item['typeDisp'] }}</td>
                <td>{{ $item['symbol'] }}</td>
                <td><a href="{{ route('search.show', [$portfolio->id, $item['type'], $item['symbol']]) }}">{{ $item['name'] }}</a></td>
                <td>{{ $item['exchDisp'] }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    @endif

@endsection


