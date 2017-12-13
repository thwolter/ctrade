@extends('layouts.master')

@section('content-main')


    @if( !count($portfolio->assets) )
        <div class="alert alert-dismissible fade show g-bg-teal g-color-white rounded-0" role="alert">
            <button type="button" class="close u-alert-close--light" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>

            <div class="media">
                <span class="d-flex g-mr-10 g-mt-5">
                    <i class="icon-check g-font-size-25"></i>
                </span>
                <span class="media-body align-self-center">
                    <strong>Glückwunsch!</strong> Du hast dein erstes Portfolio erfolgreich eingerichtet.
                        Füge neue Positionen über den Menüpunt Transaktionen hinzu.
                </span>
            </div>
        </div>
    @else

        <!-- Limits -->
        @include('portfolios.panels.limits')

        <!-- Key Figures -->
        @include('portfolios.panels.keyfigures')

        <!-- Performance Graph -->
        @include('portfolios.panels.performance_graph')

        <!-- Positions Graph -->
        @include('portfolios.panels.positions_graph')

    @endif


@endsection



@section('link.header')

    <link rel="stylesheet" href="{{ asset('assets/vendor/custombox/custombox.min.css') }}">

@endsection



@section('script.footer')

    <!-- JS Implementing Plugins -->
    <script src="{{ asset('assets/vendor/custombox/custombox.min.js') }}"></script>

    <!-- JS Unify -->
    <script src="{{ asset('assets/js/components/hs.modal-window.js') }}"></script>

    <!-- JS Plugins Init. -->
    <script>
        $(document).on('ready', function () {
            // initialization of popups
            $.HSCore.components.HSModalWindow.init('[data-modal-target]');
        });
    </script>

@endsection

