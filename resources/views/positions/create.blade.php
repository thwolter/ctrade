@extends('portfolios.show')

@section('container-content')

    <form method="post" action="/portfolios/{{ $portfolio->id }}/positions">

        <input type="hidden" name="portfolio_id" value="{{ $portfolio->id }}">

        {{csrf_field()}}

        @include('layouts.errors')

        <div class="form-group">
            <label for="symbol">Symbol</label>
            <input type="text" name="symbol" class="form-control" placeholder="">
        </div>
        <br>

        <div class="form-group">
            <button type="submit" name="submit" class="button--right">Position hinzufügen</button>
        </div>

    </form>


@endsection


