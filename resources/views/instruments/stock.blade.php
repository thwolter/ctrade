@extends('search.show')

    @section('instrument-content')

        <!-- show
        current price
        price chart
        industry sector
        currency
        ...
        -->

        <p>{{ $daten->price() }}</p>



    @endsection