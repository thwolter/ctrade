@extends('layouts.master')

@section('content')

    <div class="row">

        <div class="col-md-3 col-sm-6">
            @include('partials.stats.value')
        </div> <!-- /.col-md-3 -->

        <div class="col-md-3 col-sm-6">
            @include('partials.stats.cash')
        </div> <!-- /.col-md-3 -->

        <div class="col-md-3 col-sm-6">
            @include('partials.stats.risk')
        </div> <!-- /.col-md-3 -->

        <div class="col-md-3 col-sm-6">
            @include('partials.stats.profit')
        </div> <!-- /.col-md-3 -->
    </div>

    <div class="row">

        <div class="col-md-5">
            <portlet title="Positionen">
                <positions-chart pid="{{ $portfolio->id }}"></positions-chart>
            </portlet>
        </div>


        <div class="col-md-7">
            <portlet title="Wertentwicklung">
                <value-chart
                        pid="{{ $portfolio->id }}"
                        date="{{ \Carbon\Carbon::today()->toDateString() }}"
                        conf="{{ 0.95 }}"
                        count="{{ 50 }}"
                        height="100px">

                </value-chart>
            </portlet>
        </div>


        <div class="col-md-4">
            <portlet title="Limitauslastung">
                <limit-stats pid="{{ $portfolio->id }}"></limit-stats>
            </portlet>
        </div>

    </div> <!-- /.row -->

@endsection



@section('scripts.footer')

@endsection