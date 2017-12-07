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

                        <div class="card g-mb-40 rounded-0">
                            <h3 class="card-header h5 text-white g-bg-primary g-brd-transparent rounded-0">
                                <i class="fa fa-tasks g-font-size-default g-mr-5"></i>
                                <span>Portfolio</span> {{ $portfolio->name }}
                            </h3>

                            <div class="card-block">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h2 class="h4 text-uppercase g-letter-spacing-1 g-mb-20">
                                            <span>Portfolio</span>
                                            {{ $portfolio->name }}
                                        </h2>
                                        <p class="lead mb-0 g-line-height-2 g-mb-30"
                                           style="overflow: hidden; white-space: nowrap; text-overflow: ellipsis;">
                                            {{ $portfolio->present()->description() }}
                                        </p>

                                        <h6 class="text-uppercase g-font-size-12 g-font-weight-600 g-letter-spacing-0_5 g-pos-rel g-z-index-2">Successful of marketing</h6>

                                        <div class="js-hr-progress-bar progress g-height-20 rounded-0 g-overflow-visible">
                                            <div class="js-hr-progress-bar-indicator progress-bar g-pos-rel" role="progressbar" style="width: 64%;" aria-valuenow="64" aria-valuemin="0" aria-valuemax="100">
                                                <div class="text-center u-progress__pointer-v1 g-font-size-11 g-color-white g-bg-primary g-rounded-50x">64%</div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-3 align-self-center g-py-20">
                                        <img class="w-100" src="{{ asset('assets/img-temp/200x100/img1.jpg') }}" alt="Iamge Description">
                                    </div>

                                    <div class="col-md-3 text-right">
                                        <div class="row h-100">
                                            <div class="col-12">
                                                <div class="h4">{{ $portfolio->present()->total() }}</div>
                                                <div>
                                                    <i class="fa fa-caret-up g-color-green" aria-hidden="true"></i>
                                                    {{ $portfolio->present()->valueChange(1) }}
                                                </div>
                                            </div>

                                            <div class="col-12 align-self-end justify-content-end g-mt-20">
                                                <a class="btn btn-md u-btn-primary g-font-weight-600 g-font-size-11 text-uppercase"
                                                   href="{{ route('portfolios.show', $portfolio->slug) }}">Öffnen</a>
                                            </div>
                                        </div>


                                    </div>
                                </div>
                            </div>
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


