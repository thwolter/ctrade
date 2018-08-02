@extends('layouts.master')

@section('breadcrumbs')
    <section class="g-pa-40">
        <div class="container">
            <div class="row">
                <div class="col-md-8 align-self-center">
                    <h2 class="h3 text-uppercase g-font-weight-300 g-mb-20 g-mb-0--md">
                        Meine <strong>Portfolios</strong>
                    </h2>
                </div>
            </div>
        </div>
    </section>
@endsection


@section('content')
    <section id="offers-section" class="">
        <div class="container g-pt-100 g-pb-130">

            <div class="row no-gutters">


                <div class="col-12">

                    @foreach($portfolios as $portfolio)

                        <div class="card g-mb-40 rounded-0">

                            <!-- Card Header -->
                            <div class="card-header g-height-50 g-bg-primary-opacity-0_2 g-color-black-opacity-0_5 rounded-0 g-brd-primary-bottom">
                                <div class="row align-items-center d-flex">
                                    <h3 class="h5 col-8 col-10-md g-mb-0 font-weight-bold">
                                        <i class="fa fa-tasks g-font-size-default g-mr-5"></i>
                                        <span class="mb-0">{{ $portfolio->name }}</span>
                                    </h3>
                                    <div class="col">
                                        <a href="{{ route('portfolios.show', $portfolio->slug) }}"
                                           class="btn btn-sm u-btn-outline-primary float-right">
                                            Öffnen
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <!-- Card Body -->
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12 col-sm-12 col-md-4">
                                        <p class="font-weight-bold">Positionen: </p>

                                    </div>
                                    <div class="col">
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Create New Portfolio -->
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

        </div>
    </section>

@endsection


@section('link.header')

@endsection


@section('script.footer')

    <!-- JS Implementing Plugins -->
    <script src="{{ asset('assets/vendor/popper.min.js') }}"></script>

    <script>
        $(document).on('ready', function () {

            // initialization of popovers
            $('[data-toggle="popover"]').popover();

        });
    </script>
@endsection


