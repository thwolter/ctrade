@extends('layouts.master')

@section('content')

    <!-- show portfolios -->
    @foreach($portfolios as $portfolio)

        <div class="panel panel-default">
            <div class="panel-heading">
                <a href="/portfolios/{{ $portfolio->id }}">
                    {{ $portfolio->name }}
                </a>
            </div>

            <div class="panel-body">

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
                    <button class="btn btn-primary inline-block-tight pull-right">Öffnen</button>
                </div>

                <p>
                    {{ $portfolio->currency }}
                </p>
            </div>
        </div>

    @endforeach

@endsection






<!--
<!-- show portfolios -->
<div>
    <div class="panel panel-portfolio">
        <section class="">







        </section>
        <div clearfix></div>
    </div>
</div> <!-- end show portfolio -->