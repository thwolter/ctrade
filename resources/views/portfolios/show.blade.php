@extends('layouts.master')

@section('content')


    <div class="row">

        <div class="col-lg-3 col-md-4 col-sm-5 sidebar">

            <portlet title="Limitauslastung">
                <limit-stats pid="{{ $portfolio->id }}"></limit-stats>
            </portlet>

        </div>

        <div class="col-lg-9 col-md-8 col-sm-7">

            <div class="row">

                <div class="col-md-6 col-sm-6">
                    @include('partials.stats.value')
                </div> <!-- /.col-md-3 -->

              {{--  <div class="col-md-3 col-sm-6">
                    @include('partials.stats.cash')
                </div>--}}

                <div class="col-md-6 col-sm-6">
                    @include('partials.stats.risk')
                </div> <!-- /.col-md-3 -->

              {{--  <div class="col-md-4 col-sm-6">
                    @include('partials.stats.profit')
                </div>--}}
            </div>

            <portlet title="Positionen">
                <positions-chart pid="{{ $portfolio->id }}"></positions-chart>
            </portlet>

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

    </div>

@endsection



@section('scripts.footer')

@endsection