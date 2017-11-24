@extends('layouts.master')

@section('content')

    <!-- Header -->
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
                <div class="card g-bg-secondary border-0 rounded-0 g-mb-40">

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

                <!-- Transaction Form -->
                <div id="transaction" class="card border-0 rounded-0 g-mb-40" role="tablist" aria-multiselectable="true">

                    <!-- Transaction Heading -->
                    <div id="transaction-heading" role="tab"
                         class="card-header d-flex align-items-center justify-content-between g-bg-gray-light-v5 border-0 g-mb-15">
                        <h3 class="h6 g-pa-5">
                            <a class="g-color-gray-dark-v3 g-text-underline--none--hover" href="#transaction-body"
                               data-toggle="collapse" data-parent="#transaction" aria-expanded="false"
                               aria-controls="transaction-body-01">
                                Neue Transaktion
                                <span class="ml-3 fa fa-angle-down"></span>
                            </a>
                        </h3>
                    </div>

                    <!-- Transaction Body -->
                    <div id="transaction-body" class="collapse g-mt-20" role="tabpanel"
                         aria-labelledby="transaction-heading">

                        <stock-trade
                                :portfolio="{{ json_encode($portfolio) }}"
                                :instrument="{{ json_encode($stock) }}"
                                :prices="{{ json_encode($prices) }}"
                                store="{{ route('positions.store', [], false) }}"
                                redirect="#">
                        </stock-trade>

                    </div>
                </div>

                <!-- History Chart -->
                @include('positions.panel.graph_history')

                <!-- Performance Table -->
               @include('positions.panel.table_performance')


            </div>
            <!-- End Accordion -->
        </div>
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

