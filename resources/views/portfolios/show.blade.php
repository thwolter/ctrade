@extends('layouts.master')

@section('content')
    <!-- show single portfolio -->
    <div class="panel panel-default">
        <div class="panel-heading">Portfolios</div>

        <div class="panel-body">

            <article>
                <h4>
                    {{ $portfolio->name }}
                </h4>
                <div class="body">
                    {{ $portfolio->currency }}
                </div>

            </article>

        </div>
    </div>
@endsection



