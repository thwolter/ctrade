@extends('layouts.portfolio')

@section('container-content')

    <h3>Risikoverteilung</h3>
    <div class="row">
        <div class="container"></div>

        <div class="col-md-4">
            <div id="risk-chart"></div>
        </div>
        <div class="col-md-4">
            <div id="contrib-chart"></div>
        </div>
    </div>

    <h3>Analyse</h3>
    weitere Auswertungen und Analysen implementieren

@endsection

@gaugechart('Risk', 'risk-chart')
@piechart('Contribution', 'contrib-chart')

 




