@extends('layouts.master')

@section('content')

    @include('layouts.partials.header')

    <div class="container g-pt-100 g-pb-20">
        <div class="row justify-content-between">

            <!-- Sidebar -->
            @include('layouts.partials.sidebar')

            <!-- Main section -->
            <div class="col-lg-9 order-lg-2 g-mb-80">

                @unless ( $portfolio->payments->count() )
                    <div class="alert alert-info alert-dismissible role=" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                        <strong>Noch keine Positionen vorhanden.</strong>
                    </div>
                @endunless

                <div class="u-heading-v3-1 g-mb-40">
                    <h2 class="h3 u-heading-v3__title">Positionen</h2>
                </div>

                @include('positions.stocks.index')

            </div>
        </div>
    </div>

@endsection


@section('script.footer')

@endsection



