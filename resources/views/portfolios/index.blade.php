@extends('layouts.master')

@section('breadcrumbs')
    <section class="g-pa-40">
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
    <div class="container g-pt-100 g-pb-50">
        <div id="accordion" class="u-accordion u-accordion-bg-primary u-accordion-color-white" role="tablist" aria-multiselectable="true">

            @foreach($portfolios as $portfolio)

                <!-- Card -->
                <div class="card g-brd-none rounded-0 g-mb-15">
                    <div id="accordion-heading-{{$portfolio->id}}" class="u-accordion__header g-pa-0" role="tab">
                        <h5 class="mb-0">
                            <a class="collapsed d-flex g-color-main g-text-underline--none--hover g-brd-around g-brd-gray-light-v4 g-rounded-5 g-pa-10-15"
                               href="#accordion-body-{{$portfolio->id}}"
                               aria-expanded="true"
                               aria-controls="accordion-body-{{$portfolio->id}}"
                               data-toggle="collapse"
                               data-parent="#accordion">

                                <span class="u-accordion__control-icon g-mr-10">
                                    <i class="fa fa-angle-down"></i>
                                    <i class="fa fa-angle-up"></i>
                                </span>

                                {{ $portfolio->name }}
                            </a>
                        </h5>
                    </div>
                    <div id="accordion-body-{{$portfolio->id}}"
                         class="collapse" role="tabpanel"
                         aria-labelledby="accordion-heading-{{$portfolio->id}}"
                         data-parent="#accordion">

                        <div class="u-accordion__body g-color-gray-dark-v5">

                            <div class="row">
                                <div class="col-7">
                                   @include('portfolios.partials.coinlist')
                                   @include('portfolios.partials.addcoin')
                                </div>

                                <div class="col-5">
                                   @include('portfolios.partials.analysis')
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- End Card -->

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

@endsection


@section('link.header')

    <link  rel="stylesheet" href="{{ asset('assets/vendor/animate.css') }}">
    <link  rel="stylesheet" href="{{ asset('assets/vendor/custombox/custombox.min.css') }}">

@endsection


@section('script.footer')

    <!-- JS Implementing Plugins -->
    <script src="{{ asset('assets/vendor/popper.min.js') }}"></script>
    <script  src="{{ asset('assets/vendor/custombox/custombox.min.js') }}"></script>

    <!-- JS Unify -->
    <script  src="{{ asset('assets/js/components/hs.modal-window.js') }}"></script>

    <!-- JS Plugins Init. -->
    <script>
        $(document).on('ready', function () {

            // initialization of popovers
            $('[data-toggle="popover"]').popover();

            // initialization of popups
            $.HSCore.components.HSModalWindow.init('[data-modal-target]');

        });
    </script>

@endsection


