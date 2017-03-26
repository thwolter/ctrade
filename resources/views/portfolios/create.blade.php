@extends('layouts.master')

@section('content')

    <div class="panel panel-default">
        <div class="panel-heading">Portfolio erstellen</div>

        <div class="panel-body">

            <form method=post action="/portfolios">

                {{csrf_field()}}

                @include('layouts.errors')

                <div class="input-group">
                    <span class="input-group-addon">Name</span>
                    <input type="text" name="name" class="form-control" placeholder="Name">
                </div>
                <br>

                <div class="input-group">
                    <span class="input-group-addon">Währung</span>
                    <input type="text" name="currency" class="form-control" placeholder="Währung">
                </div>
                <br>

                <div class="form-group">
                    <input type="submit" name="submit" class="btn btn-primary">
                </div>

            </form>

        </div>
    </div>

@endsection



