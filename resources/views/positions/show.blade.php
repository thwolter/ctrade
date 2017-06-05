@extends('layouts.portfolio')

@section('container-content')

    @php ($item = $position->positionable)
    @include('positions/partials/stock.summary')

@endsection


