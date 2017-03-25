@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Portfolios</div>

                    <div class="panel-body">
                        @foreach($portfolios as $portfolio)
                            <article>
                                <h4>
                                    {{ $portfolio->name }}
                                </h4>
                                <div class="body">
                                    {{ $portfolio->currency }}
                                </div>

                            </article>
                        @endforeach

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
