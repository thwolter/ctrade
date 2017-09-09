@extends('layouts.master')

@section('content')

    @php $stock = $position->positionable @endphp

    @include('stock.summary')

@endsection


