@extends('layouts.master')

@section('content')

    @php $stock = $position->positionable @endphp

    @include('stocks.summary')

@endsection


