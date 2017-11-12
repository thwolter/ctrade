@extends('layouts.master')

@section('content')

   <section class="g-color-white g-bg-darkgray-radialgradient-circle g-pa-40">
       <div class="container">
           <div class="row">
               <div class="col-md-8 align-self-center">
                   <h2 class="h3 text-uppercase g-font-weight-300 g-mb-20 g-mb-0--md">
                       <strong>{{ $portfolio->name }}</strong>
                       Portfolio</h2>
               </div>
           </div>
       </div>
   </section>

    <div class="container g-pt-100 g-pb-20">
        <div class="row justify-content-between">

            <!-- Sidebar -->
           @include('layouts.partials.sidebar')

            <!-- Main section -->
            <div class="col-lg-9 order-lg-2 g-mb-80">

                @if( !count($portfolio->assets) )
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

                @else

                    <!-- Limits -->
                    @include('portfolios.panels.limits')

                    <!-- Key Figures -->
                    @include('portfolios.panels.keyfigures')

                    <!-- Performance Graph -->
                    {{--@include('portfolios.panels.performance_graph')--}}

                    <!-- Positions Graph -->
                    {{--@include('portfolios.panels.positions_graph')--}}

                @endif

            </div>
        </div>
    </div>

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

