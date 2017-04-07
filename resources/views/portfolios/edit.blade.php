@extends('layouts.master')

@section('content')

    <div class="portfolio-panel is-edit">
        <div class="portfolio-panel__portfolio-header">
            <div class="portfolio-header">Portfolio erstellen</div>

        <div class="portfolio-panel__portfolio-body">
            <div class="portfolio-body">

            <form method="post" action="/portfolios/{{ $portfolio->id }}">

                <input type="hidden" name="_method" value="PUT">

                {{ csrf_field() }}

                @include('layouts.errors')

                <div class="input-group">
                    <label for="name">Name</label>
                    <input type="text" name="name" class="form-control" value="{{ $portfolio->name }}">
                </div>
                <br>

                <div class="input-group">
                    <label for="currency">Währung</label>
                    <input type="text" name="currency" class="form-control" value="{{ $portfolio->currency }}">
                </div>
                <br>

                <div class="form-group">
                    <button type="submit" name="submit" class="btn btn-primary">Ändern</button>
                </div>

            </form>

        </div>
    </div>

@endsection



