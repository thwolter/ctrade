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


                <div class="input-group-btn">

                    <a

                    <a class="btn btn-primary inline-block-tight pull-right"
                       href="/portfolios/{{ $portfolio->id }}/edit">Edit</a>


                    <form method="post" action="/portfolios/{{ $portfolio->id }}">

                        {{ csrf_field() }}

                        <input type="hidden" name="_method" value="DELETE">
                        <button type="submit" class="btn btn-default inline-block-tight pull-right">Löschen</button>
                    </form>

                </div>
            </article>

        </div>
    </div>
@endsection



