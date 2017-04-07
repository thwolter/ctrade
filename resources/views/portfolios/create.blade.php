@extends('layouts.master')

@section('content')

    <div class="edit-panel">
        <div class="panel__header">
            <h3 class="title">Portfolio erstellen</h3>
        </div>

        <div class="panel__body">

            <form method=post action="/portfolios">

                {{csrf_field()}}

                @include('layouts.errors')

                <div class="input-group--default">
                    <label for="name">Name</label>
                    <input type="text" name="name" class="form-control" placeholder="Name">
                </div>
                <br>

                <div class="input-group--default">
                    <label for="currency">Währung</label>
                    <input type="text" name="currency" class="form-control" placeholder="Währung">
                </div>
                <br>

                <div class="form-group">
                    <button type="submit" name="submit" class="btn btn-primary">Erstellen</button>
                </div>

            </form>

        </div>
    </div>

@endsection



