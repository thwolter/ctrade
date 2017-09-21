@extends('layouts.master')

@section('content')

    @if ($asset->isType('Stock'))

        @php $stock = $asset->positionable @endphp
        @include('stocks.summary')

        <div class="row">
            <div class="col-md-8">

            </div>
            <div class="col-md-4">
                @include('stocks.performance')
            </div>
        </div>


    @endif

@endsection


