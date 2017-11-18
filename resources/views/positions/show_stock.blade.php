@extends('layouts.master')

@section('content')

    <section class="g-color-white g-bg-darkgray-radialgradient-circle g-pa-40">
        <div class="container">
            <div class="row">
                <div class="col-md-8 align-self-center">
                    <h2 class="h3 text-uppercase g-font-weight-300 g-mb-20 g-mb-0--md">
                        <strong>{{ $portfolio->name }}</strong>
                        Portfolio</h2>
                </div>
            </div>
        </div>
    </section>

    <div class="container g-pt-100 g-pb-20">
        <div class="row justify-content-between">

            <!-- Sidebar -->
        @include('layouts.partials.sidebar')

        <!-- Main section -->
            <div class="col-lg-9 order-lg-2 g-mb-80">

                <!-- Summary Card -->
                <div class="card g-bg-secondary g-brd-none rounded-0">

                    <!-- Header -->
                    <div class="card-header d-flex justify-content-between g-bg-teal g-color-white">
                        <h5 class="font-weight-bold">{{ $stock->name }}</h5>
                        <div class="g-font-size-14 align-self-center">
                            <span>ISIN: {{ $stock->isin }}</span>
                        </div>

                    </div>

                    <!-- Content -->
                    <div class="card-block">
                        <div class="row">

                            <!-- Key Figures -->
                            <div class="col-md-10">
                                <div class="g-mb-10">
                                    <div class="row">
                                        <a class="col-md-4 btn" data-toggle="popover" data-placement="bottom"
                                           data-title="Kurs"
                                           data-content="Schlusskurs der Börse Stuttgart vom 10.02.2017">
                                            <div class="font-weight-bold g-bg-black-opacity-0_8 g-color-white g-font-size-12 text-center text-uppercase g-pa-3">
                                                Kurs
                                            </div>
                                            <div class="d-flex g-bg-white g-height-70 justify-content-center g-bg-bluegray-opacity-0_1">
                                                <p class="align-self-center g-color-gray-dark-v3 g-font-size-20 g-font-weight-200">
                                                    {{ $stock->present()->price() }}
                                                </p>
                                            </div>
                                        </a>
                                        <a class="col-md-4 btn" data-toggle="popover" data-placement="top"
                                           data-title="Rendite"
                                           data-content="Gewinn/Verlust über einen Zeitraum von 52 Wochen. Der Zeitraum kann in den <a href='#'>Einstellungen</a> festgelegt werden.">
                                            <div class="font-weight-bold g-bg-blue g-color-white g-font-size-12 text-center text-uppercase g-pa-3">
                                                Rendite
                                            </div>
                                            <div class="d-flex g-bg-white g-height-70 justify-content-center g-bg-bluegray-opacity-0_1">
                                                <p class="align-self-center g-color-gray-dark-v3 g-font-size-20 g-font-weight-200">
                                                    {{ $stock->present()->price() }}
                                                </p>
                                            </div>
                                        </a>
                                        <a class="col-md-4 btn" data-toggle="popover" data-placement="bottom"
                                           data-title="Risiko"
                                           data-content="Das Risiko der Aktie für einen Zeitraum von 1 Monat mit einer Sicherheit von 95%. Zeitraum und Sicherheitslevel können über die <a href='#'>Einstellungen</a> festgelegt werden.">
                                            <div class="font-weight-bold g-bg-red g-color-white g-font-size-12 text-center text-uppercase g-pa-3">
                                                Risiko
                                            </div>
                                            <div class="d-flex g-bg-white g-height-70 justify-content-center g-bg-bluegray-opacity-0_1">
                                                <p class="align-self-center g-color-gray-dark-v3 g-font-size-20 g-font-weight-200">
                                                    {{ $stock->present()->price() }}
                                                </p>
                                            </div>
                                        </a>
                                    </div>

                                </div>

                            </div>

                        </div>
                    </div>
                </div>

                <!-- Buy/Sell Form -->
                <div id="accordion-01" class="mb-4" role="tablist" aria-multiselectable="true">
                    <div id="buy-sell-heading" class="g-brd-y g-brd-gray-light-v2 g-brd-top-0 py-3" role="tab">
                        <h5 class="g-font-weight-400 g-font-size-default mb-0">
                            <a class="g-color-gray-dark-v4 g-text-underline--none--hover" href="#buy-sell-dialog"
                               data-toggle="collapse" data-parent="#accordion-01" aria-expanded="false"
                               aria-controls="accordion-01-body-01">
                                Neue Transaktion
                                <span class="ml-3 fa fa-angle-down"></span></a>
                        </h5>
                    </div>

                    <div id="buy-sell-dialog" class="collapse g-mt-20" role="tabpanel"
                         aria-labelledby="buy-sell-heading">

                        <div class="justify-content-center d-flex">
                            <div class="w-50">
                                <div class="btn-group justified-content g-my-30">
                                <label class="g-width-120 u-check">
                                    <input class="g-hidden-xs-up g-pos-abs g-top-0 g-left-0" name="radGroupBtn1_1"
                                           type="radio" checked>
                                    <span class="btn btn-md btn-block u-btn-outline-lightgray g-color-white--checked g-bg-primary--checked rounded-0">
                                        Kauf
                                    </span>
                                </label>
                                <label class="g-width-120 u-check">
                                    <input class="g-hidden-xs-up g-pos-abs g-top-0 g-left-0" name="radGroupBtn1_1"
                                           type="radio">
                                    <span class="btn btn-md btn-block u-btn-outline-lightgray g-color-white--checked g-bg-primary--checked g-brd-left-none--md rounded-0">
                                        Verkauf
                                    </span>
                                </label>
                            </div>
                            </div>
                        </div>

                        <div class="row g-mb-20 row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="d-block g-color-gray-dark-v2 g-font-size-13">Handelsplatz</label>
                                    <input id="inputGroup1"
                                           class="form-control u-form-control g-placeholder-gray-light-v1 rounded-0 g-py-15"
                                           name="country" type="text" placeholder="Stuttgart" required>
                                </div>
                                <div class="mb-3">
                                    <label class="d-block g-color-gray-dark-v2 g-font-size-13">Preis</label>
                                    <input id="inputGroup2"
                                           class="form-control u-form-control g-placeholder-gray-light-v1 rounded-0 g-py-15"
                                           name="stateProvince" type="text" placeholder="10,20" required>
                                </div>
                                <div class="mb-3">
                                    <label class="d-block g-color-gray-dark-v2 g-font-size-13">Anzahl</label>
                                    <input id="inputGroup3"
                                           class="form-control u-form-control g-placeholder-gray-light-v1 rounded-0 g-py-15"
                                           name="zip" type="text" placeholder="10" required>
                                </div>
                                <div class="mb-3">
                                    <label class="d-block g-color-gray-dark-v2 g-font-size-13">Gebühren</label>
                                    <input id="inputGroup3"
                                           class="form-control u-form-control g-placeholder-gray-light-v1 rounded-0 g-py-15"
                                           name="zip" type="text" placeholder="12,45" required>
                                </div>
                            </div>

                            <div class="col-md-6">

                                <div class="row justify-content-end">
                                    <div class="col-md-10">
                                        <div class="d-flex g-bg-brown-opacity-0_1 g-my-20 g-pa-20 justify-content-between">
                                            <span class="align-self-end g-pb-4">Total</span>
                                            <span class="float-right g-font-size-30 pull-right">1200,40 €</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="row justify-content-end">
                                    <div class="col-md-10">
                                        <div class="d-flex g-bg-brown-opacity-0_1 g-my-20 g-pa-20 justify-content-between">
                                            <span class="align-self-end g-pb-4">Risiko</span>
                                            <span class="float-right g-font-size-30 pull-right">1200,40 €</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="row justify-content-end g-mt-10">
                                    <div class="col-md-10">
                                        <p>Das Risiko für dein Gesamtportfolio kann niedriger ausfallen und ist
                                            abhängig von der Zusammensetzung deines Portfolios</p>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="pull-right py-3">
                            <a href="#" class="btn btn-md u-btn-darkgray g-mr-10 g-mb-15">Kaufen</a>
                        </div>

                    </div>
                </div>
            </div>
            <!-- End Accordion -->
        </div>
    </div>
    </div>


    <!-- Modal window -->
    <div id="buy" class="text-left g-max-width-600 g-bg-white g-overflow-y-auto g-pa-20"
         style="display: none;">

        <button type="button" class="close" onclick="Custombox.modal.close();">
            <i class="hs-icon hs-icon-close"></i>
        </button>

        <header class="text-uppercase g-mb-35">
            <div class="g-mb-30">
                    <span class="d-block g-color-primary g-font-weight-700 g-font-size-default g-mb-15">
                        Subtitle
                    </span>
                <h2 class="h2 g-font-weight-700 mb-0">Title</h2>
            </div>
            <div class="g-width-70 g-brd-bottom g-brd-2 g-brd-primary"></div>
        </header>


        <trade-stock
                :portfolio="{{ $portfolio }}"
                :instrument="{{ $stock }}"
                transaction="buy"
                route="{{ route('positions.store', [], false) }}"
                min-date="{{ $portfolio->latestTransactionDate()->toDateString() }}">
        </trade-stock>
    </div>


    <div id="sell" class="text-left g-max-width-600 g-bg-white g-overflow-y-auto g-pa-20"
         style="display: none;">
        <button type="button" class="close" onclick="Custombox.modal.close();">
            <i class="hs-icon hs-icon-close"></i>
        </button>

        <trade-stock
                :portfolio="{{ $portfolio }}"
                :instrument="{{ $stock }}"
                transaction="sell"
                route="{{ route('positions.store', [], false) }}"
                min-date="{{ $portfolio->latestTransactionDate()->toDateString() }}">
        </trade-stock>
    </div>

@endsection



@section('link.header')

    <link rel="stylesheet" href="{{ asset('assets/vendor/custombox/custombox.min.css') }}">

@endsection



@section('script.footer')

    <!-- JS Unify -->
    <script src="{{ asset('assets/js/components/hs.modal-window.js') }}"></script>

    <!-- JS Implementing Plugins -->
    <script src="{{ asset('assets/vendor/custombox/custombox.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/popper.min.js') }}"></script>

    <!-- JS Plugins Init. -->
    <script>
        $(document).on('ready', function () {

            // initialization of popups
            $.HSCore.components.HSModalWindow.init('[data-modal-target]');

            // initialization of popovers
            $('[data-toggle="popover"]').popover({html: true});
        });
    </script>

@endsection

