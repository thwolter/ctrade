@extends('layouts.master')

@section('content')


    @include('stock.summary')

    <portlet title="{{ ($transaction === 'buy') ? 'Kaufen' : 'Verkaufen' }}">
        <trade-stock
                transaction="{{ $transaction }}"
                portfolio-id="{{ $portfolio->id }}"
                instrument-type="{{ get_class($stock) }}"
                instrument-id="{{ $stock->id }}"
                store-route="{{ route('positions.store', [], false) }}"
                cash="{{ $portfolio->cash() }}"
                amount="">
        </trade-stock>
    </portlet>





@endsection