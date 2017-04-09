@extends('portfolios.show')

@section('container-content')

    <p>here are the positions</p>

    <!-- table with class, name, quantity, value, and total -->

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Tpye</th>
                <th>Name</th>
                <th>Anzahl</th>
                <th>Preis</th>
                <th>Währung</th>
                <th>Gesamt</th>
            </tr>
        </thead>

        <tbody>
            @foreach($positions as $position)
                <tr>
                    <td>{{ $position->type() }}</td>
                    <td><a href="{{ route('positions.show', $position->id) }}">{{ $position->name() }}</a></td>
                    <td>{{ $position->quantity() }}</td>
                    <td>{{ $position->value() }}</td>
                    <td>{{ $position->currency() }}</td>
                    <td>{{ $position->total() }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <form>

        <div class="form-group">
            <a href="/portfolios/{{ $portfolio->id }}/positions/create" class="button--right">Neue Position</a>
        </div>

    </form>

@endsection


