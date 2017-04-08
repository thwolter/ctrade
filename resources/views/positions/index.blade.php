@extends('portfolios.show')

@section('container-content')

    <p>here are the transactions</p>

    <form>

        <div class="form-group">
            <a href="/portfolio/{{ $portfolio->id }}/positions/create" class="button--right">Neue Transaktion</a>
        </div>

    </form>

@endsection


