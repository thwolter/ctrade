@extends('layouts.master')

@section('content')

    <div class="content">
        <div class="container">

            @include('partials.message')

            <div class="row">
                <div class="col-md-6">
                    @include('positions.partials.cash')
                </div>

                <div class="col-md-3 col-sm-6">
                    @include('partials.stats.value')
                </div> <!-- /.col-md-3 -->

                <div class="col-md-3 col-sm-6">
                    @include('partials.stats.return')
                </div> <!-- /.col-md-3 -->

            </div>

            @include('positions.partials.stocks')
            
        </div>
    </div>


@endsection



