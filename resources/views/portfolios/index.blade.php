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
                            <h2 class="h2 g-color-black g-font-weight-600 g-line-height-1_2 mb-4">
                                Meine Portfolios
                            </h2>
                            <p class="g-font-weight-300 g-font-size-16">Du hast 3 Portfolios angelegt mit einem Gesamtwert von
                            4.500 €. Alle Portfolios sind in innerhalb der gesetzten Risikolimie. Für das Portfolio "Dubadi" hast
                            du noch kein Limit gesetzt.</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-9">

                    @foreach($portfolios as $portfolio)

                        <div class="card g-mb-40 rounded-0">

                            <!-- Card Header -->
                            <div class="card-header g-py-5 text-white g-bg-primary g-brd-transparent rounded-0">
                                <div class="row align-items-center d-flex">
                                    <h3 class="h5 col-8 col-10-md g-mb-0 font-weight-bold">
                                        <i class="fa fa-tasks g-font-size-default g-mr-5"></i>
                                        <span class="mb-0">{{ $portfolio->name }}</span>
                                    </h3>
                                    <div class="col">
                                        <a href="{{ route('portfolios.show', $portfolio->slug) }}"
                                           class="btn g-bg-white-opacity-0_3--hover g-color-white g-py-3 float-right">
                                            Öffnen
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <!-- Card Body -->
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12 col-sm-12 col-md-4">
                                        <p>
                                            <span class="font-weight-bold">Positionen: </span>
                                            {{ $portfolio->present()->description() }}
                                        </p>
                                    </div>
                                    <div class="col">
                                        <div class="row">

                                            <!-- Portfolio Key Figures -->
                                            <div class="col-4">
                                                <span class="font-weight-bold">Wert</span>
                                                <h5>{{ $portfolio->present()->value() }}</h5>
                                            </div>
                                            <div class="col-4">
                                                <span class="font-weight-bold">Risiko</span>
                                                <h5>{{ $portfolio->present()->risk(0) }}</h5>
                                            </div>
                                            <div class="col-4">
                                                <span class="font-weight-bold">Limit</span>
                                                <h5>{{ $portfolio->present()->limitAmount(0) }}</h5>
                                            </div>

                                            <!-- Limit Utilisation -->
                                            <div class="col g-mt-20">
                                                <div class="row">
                                                    <div class="col-11">
                                                        <span class="font-weight-bold">Limitauslastung</span>

                                                        <div class="js-hr-progress-bar progress g-height-20 rounded-0 g-overflow-visible g-mb-20">
                                                            <div class="js-hr-progress-bar-indicator progress-bar g-pos-rel" role="progressbar"
                                                                 style="width: {{ $portfolio->present()->limitUtilisationNumber() * 100 }}%;"
                                                                 aria-valuenow="{{ $portfolio->present()->limitUtilisationNumber() * 100 }}"
                                                                 aria-valuemin="0"
                                                                 aria-valuemax="100">
                                                                <div class="pull-right g-font-size-11 g-px-5">
                                                                    {{ $portfolio->present()->limitUtilisation() }}
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>

                                                    <div class="col-1 d-flex justify-content-center align-items-center">
                                                        <a class="collapsed g-color-gray-dark-v3 g-text-underline--none--hover"
                                                           href="#thresholds-body"
                                                           data-toggle="collapse" data-parent="#thresholds" aria-expanded="false"
                                                           aria-controls="thresholds-body">
                                                            <span class="fa fa-angle-down btn btn-sm u-btn-primary"></span>
                                                        </a>
                                                    </div>

                                                    <div id="thresholds-body" class="col-11 collapse g-mt-20" role="tabpanel"
                                                         aria-labelledby="thresholds-heading">
                                                        keine weiteren Schwellenwerte definiert
                                                    </div>

                                                </div>
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


