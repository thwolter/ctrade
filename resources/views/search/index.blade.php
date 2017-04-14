@extends('portfolios.show')

@section('container-content')

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


@endsection


