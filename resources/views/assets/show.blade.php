@extends('layouts.master')

@section('content')

    @include('layouts.partials.header')

    <div class="container g-pt-100 g-pb-20">
        <div class="row justify-content-between">

            <!-- Sidebar -->
        @include('layouts.partials.sidebar')

        <!-- Main section -->
            <div class="col-lg-9 order-lg-2 g-mb-80">

                <div class="g-mb-55">
                    @if ($asset->isType('Stock'))

                        @php $stock = $asset->positionable @endphp

                        <div class="row">
                            <div class="col-lg-8 col-md-7">

                                <div class="u-heading-v3-1 g-mb-40">
                                    <h2 class="h3 u-heading-v3__title">{{ $stock->name }} Aktie</h2>
                                </div>


                                <div class="col-md-6 g-mb-30">
                                    <!-- List -->
                                    <ul class="list-unstyled g-color-text">
                                        <li class="g-brd-bottom g-brd-gray-light-v3 pt-1 mb-3">
                                            <span>Name:</span>
                                            <span class="float-right g-color-black">{{ $stock->name }}</span>
                                        </li>
                                        <li class="g-brd-bottom g-brd-gray-light-v3 pt-1 mb-3">
                                            <span>ISIN:</span>
                                            <span class="float-right g-color-black">{{ $stock->isin }}</span>
                                        </li>
                                        <li class="g-brd-bottom g-brd-gray-light-v3 pt-1 mb-3">
                                            <span>WKN:</span>
                                            <span class="float-right g-color-black">{{ $stock->wkn }}</span>
                                        </li>
                                        <li class="g-brd-bottom g-brd-gray-light-v3 pt-1 mb-3">
                                            <span>Kurs:</span>
                                            <span class="float-right g-color-black">{{ $stock->present()->price() }}</span>
                                        </li>
                                        <li class="g-brd-bottom g-brd-gray-light-v3 pt-1 mb-3">
                                            <span>Kursdatum:</span>
                                            <span class="float-right g-color-black">Casual</span>
                                        </li>
                                    </ul>
                                    <!-- End List -->
                                </div>


                                <div class="u-heading-v3-1 g-mb-40">
                                    <h2 class="h3 u-heading-v3__title">Historie</h2>
                                </div>

                                <stock-chart
                                        :exchanges="{{ json_encode($exchanges) }}"
                                        :history="{{ json_encode($history) }}">
                                </stock-chart>
                            </div>

                            <div class="col-lg-4 col-md-5">

                                <div class="u-heading-v3-1 g-mb-40">
                                    <h2 class="h3 u-heading-v3__title">Kennzahlen</h2>
                                </div>

                                <stock-performance
                                        stock-id="{{ $stock->id }}"
                                        locale="de-DE">
                                </stock-performance>
                            </div>
                        </div>


                    @endif
                </div>
            </div>
        </div>
    </div>

@endsection


@section('link.header')

    <!-- CSS Implementing Plugins -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/jquery-ui/themes/base/jquery-ui.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/chosen/chosen.css') }}">

@endsection


@section('script.footer')

    <!-- JS Unify -->
    <script src="{{ asset('assets/js/components/hs.select.js') }}"></script>


    <!-- JS Plugins Init. -->
    <script>
        $(document).on('ready', function () {

            // initialization of custom select
            $.HSCore.components.HSSelect.init('.js-custom-select');

        });
    </script>
@endsection

