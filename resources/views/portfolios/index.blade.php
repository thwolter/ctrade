@extends('layouts.master')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">Portfolios</div>

            <div class="panel-body">
                @foreach($portfolios as $portfolio)
                    <article>
                        <h4> {{ $portfolio->name }} </h4>
                        <div class="body">
                            {{ $portfolio->currency }}
                        </div>

                    </article>
                @endforeach
            </div>
        </div>
    </div>
@endsection
