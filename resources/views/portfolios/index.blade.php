@extends('layouts.master')

@section('content')

    <section class="padding-40">
        <div class="container">
            <h3 class="">
                Meine Portfolios
            </h3>
        </div>
    </section><!--page-tree end here-->


    @if (count($portfolios) == 0)
      @include('portfolios.partials.welcome')

        <div id="examples" class="space-70"></div>
        <!-- example masonry -->
        <div class="portfolio-list-wrapper">
            <div class="container">
                <div class="portfolio-list">
                    @foreach ($examples as $portfolio)
                        @php($bounceIn = '0.3s')
                        @include('portfolios.partials.masonry')
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    @if (count($portfolios) > 0)
        <!-- portfolio masonry -->
        <div class="portfolio-list-wrapper">
            <div class="container">
                <div class="row">
                    @foreach ($portfolios as $portfolio)
                        @include('portfolios.partials.masonry')
                    @endforeach
                </div>
            </div>
        </div>

        <!-- create-button-box -->
        <div class="row">
        <div class="container">
            <div class="create-button-box">
                <a class="btn theme-btn-color btn-lg"
                   href="{{ route('portfolios.create') }}"
                   role="button">Neues Portfolio</a>
            </div>
        </div>
        </div><!-- /create-button-box -->
        <div class="space-70"></div>

    @endif
@endsection



