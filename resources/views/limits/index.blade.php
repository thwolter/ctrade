@extends('layouts.master')

@section('content-main')

    <!-- Create New Limit -->
    @component('layouts.components.section-1')
        @slot('title')
            Neues Limit einrichten
        @endslot

        <create-limit
                :portfolio="{{ $portfolio }}"
                route="{{ route('limits.store') }}">
        </create-limit>

    @endcomponent


    <!-- Loop over existing limits -->
    @foreach($limits as $limit)

        @component('layouts.components.section')

            @slot('id')
                limit_{{ $loop->index }}
            @endslot

            @slot('title')
                <span class="g-font-weight-800 g-pr-15">
                    {{ $limit->present()->type() }} {{ $limit->present()->value() }}
                </span>
                {{ $limit->present()->utilisation() }} Auslastung
            @endslot

            @slot('menu')
                <a class="dropdown-item g-px-10" href="#">
                    <i class="icon-layers g-font-size-12 g-color-gray-dark-v5 g-mr-5"></i> Anpassen
                </a>

                <a class="dropdown-item g-px-10" href="#">
                    <i class="icon-layers g-font-size-12 g-color-gray-dark-v5 g-mr-5"></i> Optimieren
                </a>

                <div class="dropdown-divider"></div>

                <a class="dropdown-item g-px-10" href="#delete_{{ $loop->index }}"
                   data-modal-target="#delete_{{ $loop->index }}" data-modal-effect="fadein">
                    <i class="fa fa-trash-o g-font-size-12 g-color-gray-dark-v5 g-mr-5"></i> Löschen
                </a>

                <!-- Modal Window -->
                <div id="delete_{{ $loop->index }}" style="display: none;"
                     class="text-left g-max-width-600 g-bg-white g-overflow-y-auto g-pa-20">
                    <div class="g-brd-bottom g-brd-gray-light-v4 g-mb-20">
                        <button type="button" class="close" onclick="Custombox.modal.close();">
                            <i class="hs-icon hs-icon-close"></i>
                        </button>
                        <h4 class="g-mb-20">Limit löschen</h4>
                    </div>
                    <div>
                        <p class="justified-content">Bitte bestätige die Löschung des Limits:</p>
                        <p class="font-weight-bold">{{ $limit->present()->type() }} {{ $limit->present()->value() }}</p>
                    </div>

                    <div class="g-brd-gray-light-v4 g-brd-top g-mt-20 g-pt-20">
                        {!! Form::open(['route' => 'limits.destroy', 'method' => 'delete',
                            'class' => 'd-flex justify-content-end']) !!}

                        <input type="hidden" name="id" value="{{ $limit->id }}">
                        <input type="hidden" name="portfolio" value="{{ $portfolio->slug }}">

                        <button type="button" class="btn u-btn-outline-lightgray" onclick="Custombox.modal.close();">
                            Abbrechen
                        </button>
                        <button type="submit" class="btn btn-default btn-primary g-ml-10">Löschen</button>
                        {!! Form::close() !!}
                    </div>
                </div>
            @endslot

            <div class="collapse g-bg-lightblue g-px-20 g-pt-30 g-pb-20 show">

                <div class="row">
                    <div class="col-4">
                        {{ $limit->present()->description }}
                    </div>

                    <div class="col-8">
                        <h6>Limit Auslastung
                            <span class="float-right g-ml-10">{{ $limit->present()->utilisation() }}</span>
                        </h6>
                        <div class="progress g-bg-black-opacity-0_7 g-height-20 rounded-0">
                            <div class="progress-bar"
                                 role="progressbar"
                                 style="width: 84%;"
                                 aria-valuenow="84"
                                 aria-valuemin="0"
                                 aria-valuemax="100">

                            </div>
                        </div>
                        <p class="d-flex g-pt-5 justify-content-between small">
                            <span>Limithöhe {{ $limit->present()->value() }}</span>
                            <span>Zieldatum {{ $limit->present()->date() }}</span>
                        </p>
                    </div>
                </div>


            </div>

        @endcomponent

    @endforeach

    <div class="g-mb-60">
        {{ $limits->links('layouts.pagination.default-1') }}
    </div>

@endsection




@section('link.header')

    <!-- CSS Implementing Plugins -->
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