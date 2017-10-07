@extends('layouts.master')

@section('content')

    <section id="offers-section" class="g-bg-secondary">
        <div class="container g-pt-100 g-pb-130">
            <!-- Icon Blocks -->
            <div class="row no-gutters">
                <div class="col-sm-6 col-lg-3">
                    <div class="g-pr-40 g-mt-20">
                        <div class="g-mb-30">
                            <h2 class="h2 g-color-black g-font-weight-600 g-line-height-1_2 mb-4">What can
                                <br>
                                we provide?
                            </h2>
                            <p class="g-font-weight-300 g-font-size-16">The time has come to bring those ideas and plans to life. This is where we really begin to visualize your napkin sketches and make them into beautiful pixels.</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-9">
                    <div id="we-provide" class="js-carousel" data-infinite="true" data-slides-show="3" data-slides-scroll="3" data-center-mode="true" data-center-padding="1px" data-pagi-classes="u-carousel-indicators-v1 g-absolute-centered--x g-bottom-minus-30">

                        @foreach($portfolios as $portfolio)
                            <div class="js-slide">
                                <div class="u-shadow-v21--hover g-brd-around g-brd-gray-light-v3 g-brd-left-none g-brd-transparent--hover g-bg-white--hover g-transition-0_3 g-cursor-pointer g-px-30 g-pt-30 g-pb-50 g-ml-minus-1">
                                    <div class="mb-4">
                                        <span class="d-block g-color-gray-dark-v4 g-font-weight-700 text-right mb-3">01</span>
                                        <span class="u-icon-v3 u-shadow-v19 g-bg-white g-color-primary rounded-circle mb-4">
                                        {{ $portfolio->present()->total() }}
                                            {{ $portfolio->present()->risk() }}
                                            {{ $portfolio->present()->profit() }}
                                    </span>
                                        <h3 class="h5 g-color-black g-font-weight-600 mb-3">{{ $portfolio->name }}</h3>
                                        <p>{{ $portfolio->present()->description() }}</p>
                                    </div>
                                    <a class="g-brd-bottom g-brd-gray-dark-v5 g-brd-primary--hover g-color-gray-dark-v5 g-color-primary--hover g-font-weight-600 g-font-size-12 text-uppercase g-text-underline--none--hover"
                                       href="{{ route('portfolios.show', $portfolio->slug) }}">Öffnen</a>
                                </div>
                            </div>
                        @endforeach


                    </div>
                </div>
            </div>
            <!-- End Icon Blocks -->
        </div>
    </section>

@endsection


