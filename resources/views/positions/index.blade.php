@extends('layouts.master')

@section('content')

    <div class="content">
        <div class="container">
     
            
            @if (count($portfolio->positions) == 0)
                <div class="alert alert-info alert-dismissible role=" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    
                    <strong>Portfolio enthält noch keine Positionen.</strong>
                </div>
            @endif

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



