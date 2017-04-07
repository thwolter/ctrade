@extends('layouts.master')

@section('content')

    <!-- show portfolios -->
    @foreach($portfolios as $portfolio)

        <section class="portfolio-panel">

            @include('portfolios.header')

            <div class="portfolio-panel__portfolio-body">

                <!-- summary table -->
                <div class="summary-table">
                    <table>
                        <tbody>
                        <tr>
                            <td>Gesamtwert</td>
                            <td>130 EUR</td>
                        </tr>
                        <tr>
                            <td>Gewinn</td>
                            <td>130 EUR</td>
                        </tr>
                        <tr>
                            <td>Risiko</td>
                            <td>130 EUR</td>
                        </tr>
                        </tbody>
                    </table>
                </div>

                <!-- summary chart -->
                <div class="summary-chart">
                    <img src="img/Pie Chart.png" class="img-responsive">
                </div>

                <div class="">
                    <a class="btn btn-primary inline-block-tight pull-right"
                       href="/portfolios/{{ $portfolio->id }}">Öffnen</a>
                </div>

                <p>
                    {{ $portfolio->currency }}
                </p>
            </div>
        </div><!-- end show portfolio -->

    @endforeach

@endsection
