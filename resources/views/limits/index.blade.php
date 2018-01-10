@extends('layouts.master')

@section('content-main')


    <!-- Loop over existing limits -->
    @foreach($limits as $limit)

        @component('layouts.components.section', ['collapse' => false])

            @slot('id')
                limit_{{ $loop->index }}
            @endslot

            @slot('title')
                <span class="g-font-weight-800 g-pr-15">
                    {{ $limit->present()->type() }} {{ $limit->present()->value() }}
                </span>
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

            <div class="g-bg-gray-gradient-opacity-v1 g-px-20 g-pt-30 g-pb-20 show">

                <div class="row">
                    <div class="col-4">
                        {{ $limit->present()->description }}
                    </div>

                    <div class="col-8">
                        <div class="progress g-height-20 rounded-0 g-overflow-visible g-mb-20">
                            <div class="progress-bar g-pos-rel" role="progressbar"
                                 style="width: {{ $limit->present()->utilisationNumber * 100 }}%;"
                                 aria-valuenow="{{ $limit->present()->utilisationNumber * 100 }}"
                                 aria-valuemin="0"
                                 aria-valuemax="100">
                                <div class="text-center u-progress__pointer-v2 g-font-size-11 g-color-white g-bg-primary">
                                    {{ $limit->present()->utilisation() }}
                                </div>
                            </div>
                        </div>

                        <h6>Betrag<span class="float-right g-ml-10">{{ $limit->present()->value() }}</span></h6>
                        @if( $date = $limit->present()->date() )
                            <h6>Zieldatum<span class="float-right g-ml-10">{{ $limit->present()->date() }}</span></h6>
                        @endif

                    </div>
                </div>
            </div>

        @endcomponent

    @endforeach

    <div class="g-mb-60">
        {{ $limits->links('layouts.pagination.default-1') }}
    </div>


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