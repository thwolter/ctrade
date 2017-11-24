@extends('layouts.master')

@section('content-main')

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

@endsection




@section('link.header')

@endsection




@section('script.footer')

@endsection