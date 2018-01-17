@extends('layouts.master')

@section('content-main')


    <!-- Loop over existing limits -->
    @foreach($limits as $limit)

        <div class="col-12">
            @component('limits.components.section', ['limit' => $limit])

                <div class="row">
                    <div class="col-4">
                        {{ $limit->present()->description }}
                    </div>

                    <div class="col-8">
                        <div class="g-mt-40">
                            <div class="progress g-height-20 rounded-0 g-overflow-visible g-mb-5">
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
                        </div>

                        <h6>Betrag<span class="float-right g-ml-10">{{ $limit->present()->value() }}</span></h6>
                        @if( $limit->type = 'target')
                            <h6>Zieldatum<span class="float-right g-ml-10">{{ $limit->present()->date() }}</span></h6>
                        @endif

                    </div>
                </div>

                <!-- Edit -->
                <div id="edit_{{ $limit->id }}" class="row g-mt-40">
                    <update-limit
                            :portfolio="{{ $limit->portfolio }}"
                            :limit="{{ $limit }}"
                            route="{{ route('limits.update') }}">
                    </update-limit>
                </div>

            @endcomponent
        </div>

    @endforeach

    <div class="col-12">
        {{ $limits->links('layouts.pagination.default-1') }}
    </div>

    <!-- Create New Limit -->
    <div class="col-12 g-mb-50" role="tab">
        <a class="collapsed float-right btn u-btn-outline-primary"
           href="#new-limit-body" data-toggle="collapse"
           data-parent="#thresholds" aria-expanded="false"
           aria-controls="new-limit-body">
            Neues Limite definieren
            <span class="u-accordion__control-icon">
                <i class="fa fa-angle-down"></i>
                <i class="fa fa-angle-up"></i>
            </span>
        </a>
    </div>

    <div id="new-limit-body" class="col-12 collapse"
         role="tabpanel" aria-labelledby="thresholds-heading">
        <create-limit
                :portfolio="{{ $portfolio }}"
                route="{{ route('limits.store') }}">
        </create-limit>
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