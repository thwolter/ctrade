@extends('portfolios.show')

@section('container-content')

    here should be the chart
    
    <div id="stock-div"></div>

    <div id="chart"></div>


@linechart('MyStocks', 'stock-div');
@gaugechart('Temps', 'chart')

 

@endsection


