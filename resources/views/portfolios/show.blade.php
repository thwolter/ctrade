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

                <!-- Limits -->
                @include('portfolios.panels.limits')

                <!-- Key Figures -->
                @include('portfolios.panels.keyfigures')

                <!-- Performance Graph -->
                {{--@include('portfolios.panels.performance_graph')--}}

                <!-- Positions Graph -->
                {{--@include('portfolios.panels.positions_graph')--}}

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

