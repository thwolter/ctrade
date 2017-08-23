@extends('layouts.master')

@section('content')

    <div class="content">
        <div class="container">

            @include('partials.message')

            <div class="row">
                <div class="col-md-6">
                    @include('positions.partials.cash')
                </div>


                <div class="col-md-3">
                    <icon-stat label="Portfoliowert" icon="fa-dollar bg-primary">
                        {{ $portfolio->present()->total() }}
                    </icon-stat>
                </div>

                <div class="col-md-3">
                    <icon-stat label="Entwicklung" icon="fa-dollar bg-primary">
                        {{ $portfolio->present()->total() }}
                    </icon-stat>
                    </div>
            </div>

            @include('positions.partials.stocks')
            
        </div>
    </div>


@endsection



