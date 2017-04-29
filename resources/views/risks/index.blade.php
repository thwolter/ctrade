@extends('portfolios.show')

@section('container-content')

    here should be the chart
    
    <div id="history-chart"></div>

    <div id="risk-chart"></div>

    <div id="contrib-chart"></div>


@areachart('HistoryChart', 'history-chart');
@gaugechart('Risk', 'risk-chart')
    @piechart('Contribution', 'contrib-chart')

 

@endsection


