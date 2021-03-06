@extends('layouts.master')

@section('content')

    <div class="row">
        <div class="col-md-6">
            @include('positions.cash.index')
        </div>

        <div class="col-md-3 col-sm-6">
            @include('partials.stats.value')
        </div> <!-- /.col-md-3 -->

        <div class="col-md-3 col-sm-6">
            @include('partials.stats.profit')
        </div> <!-- /.col-md-3 -->

    </div>

    @include('positions.stocks.index')

@endsection



