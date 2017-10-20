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


                        <div class="u-heading-v3-1 g-mb-40">
                            <h2 class="h3 u-heading-v3__title">{{ $stock->name }} Aktie</h2>
                        </div>

                            <stock-performance
                                    :exchanges="{{ json_encode($exchanges) }}"
                                    :history="{{ json_encode($history) }}"
                                    :stock="{{ json_encode($stock) }}"
                                    locale="de-DE">
                            </stock-performance>


                            <div class="u-heading-v3-1 g-mb-40">
                                <h2 class="h3 u-heading-v3__title">Historie</h2>
                            </div>

                            <stock-chart
                                    :exchanges="{{ json_encode($exchanges) }}"
                                    :history="{{ json_encode($history) }}">
                            </stock-chart>

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

