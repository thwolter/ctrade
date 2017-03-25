@extends('app')

@section('content')

    <form method=post action="/portfolios">

        <input type="text" name="name" placeholder="Portfolio Name">

        {{csrf_field()}}

        <input type="submit" name="submit">

    </form>

@endsection