@extends('layouts.master')

@section('content')

    @if ($asset->isType('Stock'))

        @php $stock = $asset->positionable @endphp
        @include('stocks.summary')

        <div class="row">
            <div class="col-lg-9 col-md-8 col-sm-7">
                @include('stocks.performancechart')
            </div>
            <div class="col-lg-3 col-md-4 col-sm-5">
                @include('stocks.performance')
            </div>
        </div>


    @endif

@endsection


