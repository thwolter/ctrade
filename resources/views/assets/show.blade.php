@extends('layouts.master')

@section('content')

    @if ($asset->isType('Stock'))

        @php $stock = $asset->positionable @endphp
        @include('stocks.summary')

    @endif

@endsection


