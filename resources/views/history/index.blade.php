@extends('layouts.portfolio')

@section('container-content')

   <h3>Historische Entwicklung</h3>

    <div id="history-chart"></div>
    <div class="space-70"></div>
   <h3>Auswertung</h3>
    <p>Todo:</p>
    <p>weitere Auswertungen aufnehmen, z.B längste Verlusphasen, größte Tages-/Wochen-/Monatsverluste.
    Positionen mit größtem Gewinnanteil, etc.</p>


@endsection

@areachart('HistoryChart', 'history-chart');