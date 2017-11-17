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
                <!-- Card -->
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
                                           data-content="Gewinn/Verlust über einen Zeitraum von 52 Wochen. Der Zeitraum kann in den Einstellungen festgelegt werden.">
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
                                           data-content="Das Risiko der Aktie für einen Zeitraum von 1 Monat mit einer Sicherheit von 95%. Zeitraum und Sicherheitslevel können über die Einstellungen festgelegt werden.">
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
                            <!-- Buy/Sell Buttons -->
                            <div class="col-md-2 align-self-center">
                                <a class="btn w-100 g-mb-10 u-btn-outline-darkgray"
                                   href="#buy" data-modal-target="#buy" data-modal-effect="fadein">
                                    {{--<i class="fa fa-plus-square g-font-size-12 g-mr-5"></i>--}}
                                    Kaufen
                                </a>
                                <a class="btn w-100 u-btn-outline-darkgray"
                                   href="#sell" data-modal-target="#sell" data-modal-effect="fadein">
                                    Verkaufen
                                    {{--<i class="fa fa-minus-square g-font-size-12 g-mr-5"></i>--}}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- Modal window -->
                <div id="buy" class="text-left g-max-width-600 g-bg-white g-overflow-y-auto g-pa-20"
                     style="display: none;">
                    <button type="button" class="close" onclick="Custombox.modal.close();">
                        <i class="hs-icon hs-icon-close"></i>
                    </button>

                    <trade-stock
                            transaction="buy"
                            portfolio-id="{{ $portfolio->id }}"
                            instrument-type="{{ get_class($stock) }}"
                            instrument-id="{{ $stock->id }}"
                            store-route="{{ route('positions.store', [], false) }}"
                            cash="{{ $portfolio->cash() }}"
                            amount=""
                            min-date="{{ $portfolio->latestTransactionDate()->toDateString() }}">
                    </trade-stock>

                </div>


            </div>
        </div>
    </div>

@endsection



@section('link.header')

@endsection



@section('script.footer')

    <!-- JS Unify -->
    <script src="{{ asset('assets/js/components/hs.modal-window.js') }}"></script>

    <!-- JS Implementing Plugins -->
    <script src="{{ asset('assets/vendor/popper.min.js') }}"></script>

    <!-- JS Plugins Init. -->
    <script>
        $(document).on('ready', function () {

            // initialization of popups
            $.HSCore.components.HSModalWindow.init('[data-modal-target]');

            // initialization of popovers
            $('[data-toggle="popover"]').popover();
        });
    </script>

@endsection

