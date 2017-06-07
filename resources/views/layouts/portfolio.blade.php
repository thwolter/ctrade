@extends('layouts.master')

@section('content')

    <section id="content-region-3" class="padding-40 page-tree-bg">
        <div class="container">
            <h3 class="page-tree-text">
                Meine Portfolios
            </h3>
        </div>
    </section><!--page-tree end here-->

    <div id="container" class="container">
        <div class="space-70"></div>
        <div class="row">

            <!-- sidebar navigation -->
            <div class="col-lg-2 col-md-3 col-sm-4">
                @include('partials.sidebar')
            </div>

            <!-- main section -->
            <div class="col-lg-9 offset-lg-1 col-md-8 offset-md-1 col-sm-8">
                <div class="panel portfolio-panel">

                    <!-- title -->
                    <div class="container panel-title">
                        <div class="row">
                            <div class="col-md-10 header-text">
                                <h2>{{ $portfolio->name }}</h2>
                                <span class="news-post-cat">{{ $portfolio->categoryName }} | angelegt 20.02.2016</span>
                            </div>
                            <div class="col-md-2 header-image">
                                <img src="{{ $portfolio->present()->image }}" class="img-fluid" alt="Mountain View">
                            </div>
                        </div>
                    </div><!-- /title -->

                    @yield('container-content')

                </div>
            </div>
        </div>
    </div>

    <div class="space-70"></div>
@endsection


