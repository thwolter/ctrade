@extends('layouts.master')

@section('content')

    @include('layouts.partials.header')

    <div class="container g-pt-100 g-pb-20">
        <div class="row justify-content-between">

            <!-- Sidebar -->
            @include('layouts.partials.sidebar')

            <!-- Main section -->
            <div class="col-lg-9 order-lg-2 g-mb-80">


                <header class="text-uppercase g-mb-35">
                    <div class="g-mb-30">
                    <span class="d-block g-color-primary g-font-weight-700 g-font-size-default g-mb-15">
                       Cash Transaktion
                    </span>
                        <h2 class="h2 g-font-weight-700 mb-0">Geld ein-/auszahlen</h2>
                    </div>
                    <div class="g-width-70 g-brd-bottom g-brd-2 g-brd-primary"></div>
                </header>


                    <cash-trade
                            route="{{ route('payments.store', [$portfolio->slug], false) }}"
                            :portfolio="{{ $portfolio }}">
                    </cash-trade>
                </div>

            </div>

        </div>
    </div>

@endsection




@section('link.header')

@endsection




@section('script.footer')

@endsection