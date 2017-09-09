@extends('layouts.master')

@section('content')

    @if ($entity == 'stock')

        @php $stock = $instrument @endphp

        @include('stock.summary')

        <portlet title="Kaufen">
            <add-stock id="{{ $instrument->id }}"
                       pid="{{ $portfolio->id }}"
                       cash="{{ $portfolio->cash }}"
                       store="{{ route('positions.store', [], false) }}"
                       entity="{{ \App\Entities\Stock::class }}">
            </add-stock>
        </portlet>


    @endif


@endsection