@extends('portfolios.show')

@section('container-content')

    <form method=post action="/portfolios/{{ $portfolio->id }}/positions/">

        {{csrf_field()}}

        @include('layouts.errors')

        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" class="form-control" placeholder="">
        </div>
        <br>

        <div class="form-group">
            <label for="currency">Währung</label>
            <input type="text" name="currency" class="form-control" placeholder="">
        </div>
        <br>

        <div class="form-group">
            <button type="submit" name="submit" class="button--right">Transaktion hinzufügen</button>
        </div>

    </form>


@endsection


