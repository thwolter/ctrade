@extends('layouts.master')

@section('content')

    <section id="content-region-3" class="padding-40 page-tree-bg">
        <div class="container">
            <h3 class="page-tree-text">
                Meine Portfolios
            </h3>
        </div>
    </section><!--page-tree end here-->
    <div class="space-70"></div>
    
    <div class="container">
        <div class="row">

            <div class="col-md-3">
                <!-- sidebar navigation -->
                @include('partials.sidebar')
            </div>

            <div class="col-md-9">
                <div class="panel panel-primary">

                    <!-- title and nav -->
                    <h3>{{ $portfolio->name }}</h3>
                    @include('partials.pills')
                    <hr><!-- /title and nav -->

                    @yield('container-content')

                </div>
            </div>
        </div>
    </div>
@endsection



