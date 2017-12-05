@extends('layouts.master')

@section('breadcrumbs')
    <section class="g-color-white g-bg-primary-opacity-0_8 g-pa-40">
        <div class="container">
            <div class="row">
                <div class="col-md-8 align-self-center">
                    <h2 class="h3 text-uppercase g-font-weight-300 g-mb-20 g-mb-0--md">
                        Meine <strong>Portfolios</strong>
                    </h2>
                </div>
            </div>
        </div>
    </section>
@endsection


@section('content')
    <section id="offers-section" class="g-bg-secondary">
        <div class="container g-pt-100 g-pb-130">

            <div class="row no-gutters">
                <div class="col-sm-6 col-lg-3">
                    <div class="g-pr-40 g-mt-20">
                        <div class="g-mb-30">
                            <h2 class="h2 g-color-black g-font-weight-600 g-line-height-1_2 mb-4">What can
                                <br>
                                we provide?
                            </h2>
                            <p class="g-font-weight-300 g-font-size-16">The time has come to bring those ideas and plans
                                to life. This is where we really begin to visualize your napkin sketches and make them
                                into beautiful pixels.</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-9">

                    @foreach($portfolios as $portfolio)

                        <div class="g-mb-30">
                            <!-- Portfolio -->
                            <article class="row align-items-stretch text-center mx-0">
                                <!--Portfolio title-->
                                <div class="col-sm-3 g-bg-black">
                                    <button type="button"
                                            class="btn btn-link pull-right g-color-white g-bg-transparent g-mr-minus-10"
                                            data-toggle="popover"
                                            data-placement="right"
                                            data-title="Beschreibung"
                                            data-content="{{ $portfolio->present()->description() }}">
                                        <i class="fa fa fa-question-circle-o"></i>
                                    </button>
                                    <div class="g-py-30 g-py-45--sm">
                                        <h3 class="h6 g-color-white g-font-weight-600 text-uppercase g-mb-25">
                                            Portfolio
                                            <span class="d-block g-color-primary g-font-weight-700">{{ $portfolio->name }}</span>
                                        </h3>
                                        <a class="btn btn-md u-btn-outline-white g-font-weight-600 g-font-size-11 text-uppercase"
                                           href="{{ route('portfolios.show', $portfolio->slug) }}">Öffnen</a>
                                    </div>
                                </div>


                                <!-- Portfolio summary -->
                                <div class="col-sm-9 px-0 g-bg-gray-light-v4">
                                    <div class="container row g-py-45 d-flex h-100">

                                        <div class="col align-self-center g-mx-15">
                                            <div class="g-font-size-32 g-font-weight-300 g-line-height-1 mb-0">
                                                {{ $portfolio->present()->total() }}
                                            </div>
                                            <span>Wert</span>
                                        </div>

                                        <div class="col align-self-center g-mx-15">
                                            <div class="g-font-size-32 g-font-weight-300 g-line-height-1 mb-0">
                                                {{ $portfolio->present()->risk() ?? '-'}}
                                            </div>
                                            <span>Risiko</span>
                                        </div>

                                        <div class="col align-self-center g-mx-15">
                                            <div class="g-font-size-32 g-font-weight-300 g-line-height-1 mb-0">
                                                {{ $portfolio->present()->profit() ?? '-'}}
                                            </div>
                                            <span>Performance</span>
                                        </div>

                                    </div>
                                </div>
                                <!-- End Article Image -->
                            </article>
                        </div>
                    @endforeach


                    <!-- Create New Portfolio -->
                    <a href="{{ route('portfolios.create') }}"
                       class="g-mb-30 btn btn-block g-bg-gray-light-v5 g-brd-around
                        g-brd-gray-light-v4 g-bg-gray-light-v4--hover g-color-gray-light-v1 g-color-gray-dark-v4--hover">
                        <div class="align-items-stretch text-center mx-0">
                            <div class="g-px-30 g-py-70">
                                <i class="fa fa-plus-circle"></i>
                                Neues Portfolio anlegen
                            </div>
                        </div>
                    </a>

                </div>
            </div>
        </div>
    </section>

@endsection


@section('link.header')

@endsection


@section('script.footer')

    <!-- JS Implementing Plugins -->
    <script src="{{ asset('assets/vendor/popper.min.js') }}"></script>

    <script>
        $(document).on('ready', function () {

            // initialization of popovers
            $('[data-toggle="popover"]').popover();

        });
    </script>
@endsection


