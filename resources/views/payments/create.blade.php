@extends('layouts.master')

@section('content-main')

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

@endsection




@section('link.header')

@endsection




@section('script.footer')

@endsection