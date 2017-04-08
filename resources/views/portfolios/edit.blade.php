@extends('layouts.master')

@section('content')

    <div class="ct-panel">
        <div class="ct-panel__ct-header ct-header">
            <h3 class="title">Portfolio bearbeiten</h3>
        </div>

        <div class="ct-panel__ct-body">

            <form method="post" action="/portfolios/{{ $portfolio->id }}">

                <input type="hidden" name="_method" value="PUT">

                {{ csrf_field() }}

                @include('layouts.errors')

                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" name="name" class="form-control" value="{{ $portfolio->name }}">
                </div>
                <br>

                <div class="form-group">
                    <label for="currency">Währung</label>
                    <input type="text" name="currency" class="form-control" value="{{ $portfolio->currency }}">
                </div>
                <br>

                <div class="button-group">
                    <button type="submit" name="submit" class="button--right">Ändern</button>
                </div>

            </form>


            <!-- form to delete portfolio -->
            <form method="post" action="/portfolios/{{ $portfolio->id }}">

                {{ csrf_field() }}

                <input type="hidden" name="_method" value="DELETE">
                <button type="submit" name="delete" class="btn-link text-danger">Portfolio löschen</button>

            </form>

        </div>
    </div>

@endsection



