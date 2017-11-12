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

                <p class="g-mb-30">Zahle Geld ein oder aus.</p>



                <div class="row justify-content-center">
                    <form class="col-md-8 g-brd-around g-brd-gray-light-v4 g-pa-30 g-mb-30">

                        <div class="g-mb-15">
                            <label class="form-check-inline u-check g-pl-25 ml-0 g-mr-25">
                                <input class="g-hidden-xs-up g-pos-abs g-top-0 g-left-0" name="radInline1_1" type="radio" checked="">
                                <div class="u-check-icon-radio-v4 g-absolute-centered--y g-left-0 g-width-18 g-height-18">
                                    <i class="g-absolute-centered d-block g-width-10 g-height-10 g-bg-primary--checked"></i>
                                </div>
                                Einzahlung
                            </label>

                            <label class="form-check-inline u-check g-pl-25 ml-0 g-mr-25">
                                <input class="g-hidden-xs-up g-pos-abs g-top-0 g-left-0" name="radInline1_1" type="radio">
                                <div class="u-check-icon-radio-v4 g-absolute-centered--y g-left-0 g-width-18 g-height-18">
                                    <i class="g-absolute-centered d-block g-width-10 g-height-10 g-bg-primary--checked"></i>
                                </div>
                                Auszahlung
                            </label>
                        </div>
                        <!-- Text Input -->
                        <div class="form-group g-mb-20">
                            <label class="g-mb-10" for="inputGroup1_1">Text input</label>
                            <input id="inputGroup1_1" class="form-control form-control-md rounded-0" type="email" placeholder="Enter email">
                            <small class="form-text text-muted g-font-size-default g-mt-10">We'll never share your email with anyone else.</small>
                        </div>

                        <!-- Select Single Date -->
                        <div class="form-group g-mb-30">
                            <label class="g-mb-10">Select single date</label>
                            <div class="input-group g-brd-primary--focus">
                                <input id="datepickerDefault" class="form-control form-control-md u-datepicker-v1 g-brd-right-none rounded-0" type="text">
                                <div class="input-group-addon d-flex align-items-center g-bg-white g-color-gray-dark-v5 rounded-0">
                                    <i class="icon-calendar"></i>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>

                <div class="row justify-content-center">
                    <cash-trade
                            route="{{ route('portfolios.pay', [], false) }}"
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