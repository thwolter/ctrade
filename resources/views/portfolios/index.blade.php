@extends('layouts.master')

@section('content')

    <section id="content-region-3" class="padding-40 page-tree-bg">
        <div class="container">
            <h3 class="page-tree-text">
                Portfolio anlegen
            </h3>
        </div>
    </section><!--page-tree end here-->
    <div class="space-70"></div>

    @if (count($portfolios) == 0)

        <div>

        </div>

        <div class="cbp cbp-l-grid-work">
            <div class="cbp-item identity">
                <a href="#" class="cbp-caption" rel="nofollow">
                    <div class="cbp-caption-defaultWrap">
                        <img src="{{ asset('img/work/work-1.jpg') }}" alt="">
                    </div>
                    <div class="cbp-caption-activeWrap"></div>
                </a>
                <a href="#" class="cbp-l-grid-work-title" rel="nofollow">Dashboard</a>
                <div class="cbp-l-grid-work-desc">Web Design / Graphic</div>
            </div>

        </div><!--/portfolio-->

        <!--cube portfolio-->
        <link href="{{ asset('cubeportfolio/css/cubeportfolio.min.css') }}" rel='stylesheet'>
        <script src="{{ asset('cubeportfolio/js/jquery.cubeportfolio.min.js') }}"></script>

    @endif

    <!-- show list of portfolios -->
    @foreach($portfolios as $portfolio)

        <!-- a single portfolio -->
        <section class="ct-panel">

            <h2 class="portfolio-title"><a href="{{ route('portfolios.show', $portfolio->id) }}"> {{ $portfolio->name }}</a></h2>

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


