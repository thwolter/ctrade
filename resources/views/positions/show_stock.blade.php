@extends('layouts.master')

@section('content-main')


    <div class="btn-group d-flex justify-content-end g-mb-40">
        @foreach ($stock->exchangesAsAssociativeArray() as $key => $value )

            @if ($exchange === $key)
                <span class="btn btn-sm rounded-0 u-btn-primary">{{ $value }}</span>

            @else
                <a href="{{ route('positions.show',[$portfolio, $stock->type(), $stock->slug, 'exchange' => $key]) }}"
                   class="btn btn-sm rounded-0 u-btn-outline-lightgray">{{ $value }}
                </a>
            @endif

        @endforeach
    </div>

    <!-- Summary Card -->
    @component('layouts.components.section', ['collapse' => false])

        @slot('title')
            {{ $stock->name }}
        @endslot

        @slot('subtitle')
            ISIN: {{ $stock->isin }}
        @endslot

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

    @endcomponent

    <!-- Transaction Form -->
    @component('layouts.components.section')

        @slot('title')
            Neue Transaktion
        @endslot

        <stock-trade
                :portfolio="{{ json_encode($portfolio) }}"
                :instrument="{{ json_encode($stock) }}"
                :prices="{{ json_encode($data->historiesByExchange($stock)) }}"
                store="{{ route('positions.store', [], false) }}"
                redirect="#">
        </stock-trade>

    @endcomponent

    <!-- History Chart -->
    @component('layouts.components.section')

        @slot('title')
            Wertentwicklung
        @endslot

        @slot('menu')
            <a class="dropdown-item g-px-10" href="#">
                <i class="icon-layers g-font-size-12 g-color-gray-dark-v5 g-mr-5"></i> Projects
            </a>

            <div class="dropdown-divider"></div>

            <a class="dropdown-item g-px-10" href="#">
                <i class="icon-plus g-font-size-12 g-color-gray-dark-v5 g-mr-5"></i> View More
            </a>
        @endslot

        <stock-chart
                :exchanges="{{ json_encode($stock->exchangesToArray()) }}"
                :history="{{ json_encode($data->dataHistory($stock, ['exchange' => $exchange])) }}">
        </stock-chart>

    @endcomponent

    <!-- Performance Table -->
    @component('layouts.components.section')

        @slot('title')
            Table
        @endslot

        @slot('menu')
            <a class="dropdown-item g-px-10" href="#">
                <i class="icon-layers g-font-size-12 g-color-gray-dark-v5 g-mr-5"></i> Projects
            </a>

            <div class="dropdown-divider"></div>

            <a class="dropdown-item g-px-10" href="#">
                <i class="icon-plus g-font-size-12 g-color-gray-dark-v5 g-mr-5"></i> View More
            </a>
        @endslot

        @include('positions.partials.performance')

    @endcomponent


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

