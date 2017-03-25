
@extends('app')

@section('content')

    <h1>Portfolios</h1>

    @foreach($portfolios as $portfolio)

        <div>
            <h2>{{ $portfolio->name }}</h2>
            <p>{{ $portfolio->currency }}</p>
        </div>

    @endforeach

@stop