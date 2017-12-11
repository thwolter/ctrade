@extends('layouts.master')


@section('breadcrumbs')

    <section class="g-color-white g-bg-gray-dark-v5 g-pa-40">
        <div class="container">
            <div class="row">
                <div class="col-md-8 align-self-center">
                    <h2 class="h3 text-uppercase g-font-weight-300 g-mb-20 g-mb-0--md">
                        Benutzer <strong>Einstellungen</strong>
                    </h2>
                </div>
            </div>
        </div>
    </section>

@endsection


@section('content')

    <section class="g-mb-100 g-pt-100">
        <div class="container">
            <div class="row">

                <!-- Profile Content -->
                <div class="col-lg-9">

                    <!-- Nav tabs -->
                    <ul class="nav nav-justified u-nav-v1-1 u-nav-primary g-brd-bottom--md g-brd-bottom-2 g-brd-primary g-mb-20"
                        role="tablist"
                        data-target="tab-panes"
                        data-tabs-mobile-type="slide-up-down"
                        data-btn-classes="btn btn-md btn-block rounded-0 u-btn-outline-primary g-mb-20">

                        <li class="nav-item">
                            <a class="nav-link {{ active_tab('profile') }}" data-toggle="tab"
                               href="#profile" role="tab">@lang('user.profile.title')
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ active_tab('password') }}" data-toggle="tab"
                               href="#password" role="tab">@lang('user.password.title')
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ active_tab('messaging') }}" data-toggle="tab"
                               href="#messaging" role="tab">@lang('user.messaging.title')
                            </a>
                        </li>

                    </ul>
                    <!-- End Nav tabs -->

                    <!-- Tab panes -->
                    <div id="tab-panes" class="tab-content g-pt-20--md">
                        <div class="tab-pane fade {{ active_tab('profile', 'show active') }}"
                             id="profile" role="tabpanel">
                            @include('users.edit.profile')
                        </div>

                        <div class="tab-pane fade {{ active_tab('password', 'show active') }}"
                             id="password" role="tabpanel">
                            @include('users.edit.password')
                        </div>

                        <div class="tab-pane fade {{ active_tab('messaging', 'show active') }}"
                             id="messaging" role="tabpanel">
                            @include('users.edit.messaging')
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

    </section>

@endsection


@section('link.header')

    <!-- CSS Implementing Plugins -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/jquery-ui/themes/base/jquery-ui.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/chosen/chosen.css') }}">

@endsection


@section('script.footer')

    <!-- jQuery UI Widgets -->
    <script src="{{ asset('assets/vendor/jquery-ui/ui/widgets/datepicker.js') }}"></script>

    <!-- JS Implementing Plugins -->
    <script src="{{ asset('assets/vendor/chosen/chosen.jquery.js') }}"></script>
    <script src="{{ asset('assets/vendor/jquery.maskedinput/src/jquery.maskedinput.js') }}"></script>

    <!-- JS Unify -->
    <script src="{{ asset('assets/js/components/hs.tabs.js') }}"></script>
    <script src="{{ asset('assets/js/components/hs.select.js') }}"></script>
    <script src="{{ asset('assets/js/components/hs.masked-input.js') }}"></script>
    <script src="{{ asset('assets/js/components/hs.datepicker.js') }}"></script>


    <!-- JS Plugins Init. -->
    <script>
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