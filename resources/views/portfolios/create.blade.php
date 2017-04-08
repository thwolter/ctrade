@extends('layouts.master')

@section('content')

    <div class="ct-panel">
        <div class="ct-panel__ct-header ct-header">
            <h3 class="title">Portfolio erstellen</h3>
        </div>

        <div class="ct-panel__ct-body">

            <form method="post" action="/portfolios">

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
                    <button type="submit" name="submit" class="button--right">Portfolio erstellen</button>
                </div>

            </form>

        </div>
    </div>

@endsection



