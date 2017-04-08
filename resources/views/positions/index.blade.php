@extends('portfolios.show')

@section('container-content')

    <p>here are the transactions</p>

    <form>

        <div class="form-group">
            <a href="/portfolios/{{ $portfolio->id }}/positions/create" class="button--right">Neue Position</a>
        </div>

    </form>

@endsection


