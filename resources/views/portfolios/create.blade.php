@extends('layouts.master')

@section('content')

    <section class="g-color-white g-bg-darkgray-radialgradient-circle g-pa-40">
        <div class="container">
            <div class="row">
                <div class="col-md-8 align-self-center">
                    <h2 class="h3 text-uppercase g-font-weight-300 g-mb-20 g-mb-0--md">
                        Neues Portfolio
                    </h2>
                </div>
            </div>
        </div>
    </section>

    <div class="container g-pt-100 g-pb-20">
        <div class="row justify-content-between g-mb-40">

            <div class="col-md-3">
                <header class="text-uppercase g-mb-35">
                    <div class="g-mb-30">
                        <h2 class="h2 g-font-weight-700 mb-0">Portfolio eröffnen</h2>
                    </div>
                    <div class="g-width-70 g-brd-bottom g-brd-2 g-brd-primary"></div>
                </header>

                <p class="g-mb-30">{{ trans('limits.dialog.text') }}</p>
            </div>

            <div class="col-md-9">
                <div class="row justify-content-center">
                {!! Form::open([
                    'route' => 'portfolios.store',
                    'method' => 'PUT',
                    'class' => 'col-7 g-brd-around g-brd-gray-light-v4 g-pa-30 g-mb-30 g-bg-brown-opacity-0_1'
                ]) !!}

                <!-- Name Input -->
                    <div class="form-group g-mb-20 {{ $errors->has('name') ? 'u-has-error-v1' : ''}}">
                        <label class="g-mb-10" for="name">Name des Portfolios</label>
                        <input id="name" name="name" class="form-control form-control-md rounded-0 g-mb-10"
                               placeholder="Mein Portfolio">
                        <small class="form-control-feedback">{{ $errors->first('name')  }}</small>
                    </div>


                    <!-- Currency Input -->
                    <div class="form-group g-mb-25 {{ $errors->has('currency') ? 'u-has-error-v1' : ''}}">
                        <label class="g-mb-10">Währung des Portfolios</label>

                        {!! Form::select('currency', ['EUR', 'USD'], ['Euro', 'Dollar'], [
                            'class' => 'js-custom-select u-select-v1 form-control form-control-md g-brd-gray-light-v2 g-color-gray-dark-v5 w-100 g-pt-11 g-pb-10',
                            'data-open-icon' => "fa fa-angle-down",
                            'data-close-icon' => "fa fa-angle-up"
                            ])
                        !!}
                        <small class="form-control-feedback">{{ $errors->first('currency')  }}</small>
                        <small class="form-text text-muted g-font-size-default g-mt-10">
                            Die Währung, in der das Portfolio geführt werden soll.
                        </small>
                    </div>

                    <!-- Description Input -->
                    <div class="form-group g-mb-20 {{ $errors->has('currency') ? 'u-has-error-v1' : ''}}">
                        <label class="g-mb-10" for="description">Beschreibung</label>
                        <textarea id="description" name="description"
                                  class="form-control form-control-md g-resize-none rounded-0"
                                  rows="3" placeholder="Text area"></textarea>
                        <small class="form-control-feedback">{{ $errors->first('currency')  }}</small>
                        <small class="form-text text-muted g-font-size-default g-mt-10">
                            Die Beschreibung hilft dir, bei mehreren Portfolios den Überblick zu behalten.
                        </small>
                    </div>

                    <!-- Buttons -->
                    <div class="text-sm-right">
                        <button type="submit" class="btn u-btn-darkgray rounded-0 g-py-12 g-px-25 g-mr-10">
                            Portfolio anlegen
                        </button>
                    </div>

                    {!! Form::close() !!}
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

    <!-- jQuery UI Helpers -->
    <script src="{{ asset('assets/vendor/jquery-ui/ui/widgets/menu.js') }}"></script>
    <script src="{{ asset('assets/vendor/jquery-ui/ui/widgets/mouse.js') }}"></script>

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

            // initialization of custom select
            $.HSCore.components.HSSelect.init('.js-custom-select');

        });

    </script>
@endsection
