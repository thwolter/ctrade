@extends('layouts.master')

@section('content')

    @if ($entity == 'stock')

        @php $stock = $instrument @endphp

        @include('stock.summary')

        <portlet title="Kaufen">
            <trade-stock
                    portfolio-id="{{ $portfolio->id }}"
                    instrument-type="{{ \App\Entities\Stock::class }}"
                    instrument-id="{{ $instrument->id }}"
                    store-route="{{ route('positions.store', [], false) }}"
                    cash="{{ $portfolio->cash() }}">
            </trade-stock>
        </portlet>


    @endif


@endsection