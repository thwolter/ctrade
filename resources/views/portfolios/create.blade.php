@extends('layouts.master')

@section('content')

    <form method=post action="/portfolios">

        <input type="text" name="name" placeholder="Portfolio Name">
        <input type="text" name="currency" placeholder="Währung">

        {{csrf_field()}}

        <input type="submit" name="submit">

    </form>

@endsection