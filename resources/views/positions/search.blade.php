@extends('layouts.master')

@section('content')

    @include('layouts.partials.header')

    <div class="container g-pt-100 g-pb-20">
        <div class="row justify-content-between">

            <!-- Sidebar -->
        @include('layouts.partials.sidebar')

        <!-- Main section -->
            <div class="col-lg-9 order-lg-2 g-mb-80">

                <!-- Search Form -->
                <div class="container">

                    <div class="text-center">
                        <h2 class="h1 text-uppercase g-font-weight-300 g-mb-30">
                            Wertpapier suchen
                        </h2>
                    </div>

                    <search-instrument
                        :portfolio="{{ $portfolio }}"
                        route="{{ route('positions.show', [$portfolio->slug, '%entity%', '%instrument%'], false) }}">
                    </search-instrument>

                </div>
            </div>
        </div>
    </div>

@endsection




@section('link.header')

@endsection




@section('script.footer')
    <script>
        Vue.component('add-stock', {

            props: {
                portfolio: {
                    type: Object,
                    required: true
                },
                route: {
                    type: String,
                    required: true
                }
            }
        })

    </script>
@endsection