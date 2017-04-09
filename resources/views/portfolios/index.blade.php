@extends('layouts.master')

@section('content')

    <!-- show list of portfolios -->
    @foreach($portfolios as $portfolio)

        <!-- a single portfolio -->
        <section class="ct-panel">

            @include('portfolios.header')

            <div class="ct-panel__ct-body">



                <div class="">
                    <a class="btn btn-primary inline-block-tight pull-right"
                       href="/portfolios/{{ $portfolio->id }}">Öffnen</a>
                </div>

                <p>
                    {{ $portfolio->currency }}
                </p>
            </div>
        </section>

    @endforeach

@endsection


