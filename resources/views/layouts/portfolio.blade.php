@extends('layouts.master')

@section('content')

    <section class="portfolio-header">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <h2>{{ $portfolio->name }}</h2>
                </div>
                <div class="col-md-2">
                    <h2 class="key-figures">
                        <span class="key-desc">Wert</span><span>{{ $portfolio->present()->total() }}</span>
                        <span class="key-desc">Risiko</span><span>200</span>
                    </h2>
                </div>
            </div>
        </div>
    </section>

    <div id="container" class="container">
        <div class="space-70"></div>
        <div class="row">

            <!-- sidebar navigation -->
            <div class="col-lg-2 col-md-3 col-sm-4">
                @include('partials.sidebar')
            </div>

            <!-- main section -->
            <div class="col-lg-9 offset-lg-1 col-md-8 offset-md-1 col-sm-8">
                <div class="portfolio-panel">

                    @yield('container-content')

                </div>
            </div>
        </div>
    </div>

    <div class="space-70"></div>
@endsection


