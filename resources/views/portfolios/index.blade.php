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

                <!-- Summary -->
                <div class="col-12 col-lg-3">
                    <div class="g-pr-40 g-mt-20">
                        <div class="g-mb-30">
                            <h2 class="h2 g-color-black g-font-weight-600 g-line-height-1_2 mb-4">
                                Meine Portfolios
                            </h2>
                            <p class="g-font-weight-300 g-font-size-16">Du hast 3 Portfolios angelegt mit einem
                                Gesamtwert von
                                4.500 €. Alle Portfolios sind in innerhalb der gesetzten Risikolimie. Für das Portfolio
                                "Dubadi" hast
                                du noch kein Limit gesetzt.</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-9">

                    @foreach($portfolios as $portfolio)

                        <div class="card g-mb-40 rounded-0">

                            <!-- Card Header -->
                            <div class="card-header g-height-50 g-bg-primary-opacity-0_2 g-color-black-opacity-0_5 rounded-0 g-brd-primary-bottom">
                                <div class="row align-items-center d-flex">
                                    <h3 class="h5 col-8 col-10-md g-mb-0 font-weight-bold">
                                        <i class="fa fa-tasks g-font-size-default g-mr-5"></i>
                                        <span class="mb-0">{{ $portfolio->name }}</span>
                                    </h3>
                                    <div class="col">
                                        <a href="{{ route('portfolios.show', $portfolio->slug) }}"
                                           class="btn btn-sm u-btn-outline-primary float-right">
                                            Öffnen
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <!-- Card Body -->
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12 col-sm-12 col-md-4">
                                        <p class="font-weight-bold">Positionen: </p>
                                        <p>{{ $portfolio->present()->description() }}</p>
                                    </div>
                                    <div class="col">

                                    @php ($limits = $limitRepository->getLimits($portfolio))

                                    <!-- Portfolio Key Figures -->
                                        <div class="row">
                                            <div class="col-4">
                                                <h3 class="font-weight-light g-mb-minus-2">{{ $portfolio->present()->value() }}</h3>
                                                <span class="g-color-gray-light-v1">Wert</span>
                                            </div>
                                            <div class="col-4">
                                                <h3 class="font-weight-light d-flex justify-content-center g-mb-minus-2">{{ $portfolio->present()->balance() }}</h3>
                                                <span class="d-flex justify-content-center g-color-gray-light-v1">Cash</span>
                                            </div>
                                            <div class="col-4">
                                                <h3 class="font-weight-light d-flex justify-content-end g-mb-minus-2">{{ $portfolio->present()->risk(0) }}</h3>
                                                <span class="d-flex justify-content-end g-color-gray-light-v1">Risiko</span>
                                            </div>
                                        </div>

                                        <!-- Limits -->
                                        <div class="row">
                                            <div class="col-12">
                                                @include('layouts.components.progress', ['limit' => $limits->first()])
                                            </div>

                                            <div id="thresholds-body" class="col-12 collapse"
                                                 role="tabpanel" aria-labelledby="thresholds-heading">
                                                @if (count($limits) < 1)
                                                    keine weiteren Schwellenwerte definiert
                                                @else
                                                    @foreach ($limits as $index => $limit)
                                                        @if ($index === 0)
                                                            @continue;
                                                        @endif
                                                        @include('layouts.components.progress', ['limit' => $limit])
                                                    @endforeach
                                                @endif
                                            </div>
                                        </div>
                                        @if (count($limits) > 1)
                                            <div class="row">
                                                <div class="col">
                                                    <div class="g-pa-0" role="tab">
                                                        <a class="collapsed float-right g-text-underline--none--hover g-color-cyan-gradient-opacity-v1"
                                                           href="#thresholds-body" data-toggle="collapse"
                                                           data-parent="#thresholds" aria-expanded="false"
                                                           aria-controls="thresholds-body">
                                                            Weitere Limite
                                                            <span class="u-accordion__control-icon">
                                                        <i class="fa fa-angle-down"></i>
                                                        <i class="fa fa-angle-up"></i>
                                                      </span>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

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


