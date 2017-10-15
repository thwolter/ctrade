@extends('layouts.master')

@section('content')

    @include('layouts.partials.header')

    <div class="container g-pt-100 g-pb-20">
        <div class="row justify-content-between">

            <!-- Sidebar -->
        @include('layouts.partials.sidebar')

        <!-- Main section -->
            <div class="col-lg-9 order-lg-2 g-mb-80">
                <!-- Nav tabs -->
                <ul class="nav u-nav-v5-3 g-brd-bottom--md g-brd-gray-light-v4"
                    role="tablist" data-target="nav-5-1-accordion-hor-left-border-bottom" data-tabs-mobile-type="accordion"
                    data-btn-classes="btn btn-md btn-block rounded-0 u-btn-outline-lightgray g-mb-20">

                    <li class="nav-item">
                        <a class="nav-link {{ active_tab('portfolio') }}" data-toggle="tab"
                           href="#portfolio" role="tab">Portfolio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ active_tab('parameter') }}" data-toggle="tab"
                           href="#parameter" role="tab">Parameter</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ active_tab('limits') }}" data-toggle="tab"
                           href="#limits" role="tab">Limite</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ active_tab('dashboard') }}" data-toggle="tab"
                           href="#dashboard" role="tab">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ active_tab('notifications') }}" data-toggle="tab"
                           href="#email" role="tab">Email</a>
                    </li>
                </ul>
                <!-- End Nav tabs -->

                <!-- Tab panes -->
                <div id="nav-5-1-accordion-hor-left-border-bottom" class="tab-content g-pt-20--md">
                    <div class="tab-pane fade {{ active_tab('portfolio', 'show active') }}"
                         id="portfolio" role="tabpanel">
                        @include('portfolios.edit.portfolio')
                    </div>
                    <div class="tab-pane fade {{ active_tab('parameter', 'show active') }}"
                         id="parameter" role="tabpanel">
                        @include('portfolios.edit.parameter')
                    </div>
                    <div class="tab-pane fade {{ active_tab('limits', 'show active') }}"
                         id="limits" role="tabpanel">
                        @include('portfolios.edit.limits')
                    </div>
                    <div class="tab-pane fade {{ active_tab('dashboard', 'show active') }}"
                         id="dashboard" role="tabpanel">
                        @include('portfolios.edit.dashboard')
                    </div>
                    <div class="tab-pane fade {{ active_tab('notifications', 'show active') }}"
                         id="email" role="tabpanel">
                        @include('portfolios.edit.notifications')
                    </div>
                </div>
                <!-- End Tab panes -->
            </div>
        </div>
    </div>



    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif


@endsection

@section('link.header')

    <!-- CSS Implementing Plugins -->
    <link  rel="stylesheet" href="{{ asset('assets/vendor/jquery-ui/themes/base/jquery-ui.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/chosen/chosen.css') }}">

@endsection

@section('script.footer')

    <!-- jQuery UI Helpers -->
    <script  src="{{ asset('assets/vendor/jquery-ui/ui/widgets/menu.js') }}"></script>
    <script  src="{{ asset('assets/vendor/jquery-ui/ui/widgets/mouse.js') }}"></script>

    <!-- jQuery UI Widgets -->
    <script  src="{{ asset('assets/vendor/jquery-ui/ui/widgets/datepicker.js') }}"></script>

    <!-- JS Implementing Plugins -->
    <script src="{{ asset('assets/vendor/chosen/chosen.jquery.js') }}"></script>
    <script  src="{{ asset('assets/vendor/jquery.maskedinput/src/jquery.maskedinput.js') }}"></script>

    <!-- JS Unify -->
    <script src="{{ asset('assets/js/components/hs.tabs.js') }}"></script>
    <script src="{{ asset('assets/js/components/hs.select.js') }}"></script>
    <script src="{{ asset('assets/js/components/hs.masked-input.js') }}"></script>
    <script src="{{ asset('assets/js/components/hs.datepicker.js') }}"></script>


    <!-- JS Plugins Init. -->
    <script >
        $(document).on('ready', function () {
            // initialization of tabs
            $.HSCore.components.HSTabs.init('[role="tablist"]');

            // initialization of custom select
            $.HSCore.components.HSSelect.init('.js-custom-select');

            // initialization of forms
            $.HSCore.components.HSMaskedInput.init('[data-mask]');
            $.HSCore.components.HSDatepicker.init('#datepickerDefault');
        });

        $(window).on('resize', function () {
            setTimeout(function () {
                $.HSCore.components.HSTabs.init('[role="tablist"]');
            }, 200);
        });
    </script>
@endsection