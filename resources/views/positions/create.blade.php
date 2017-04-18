@extends('search.show')

    @section('instrument-content')


        <h4>verfügbarer Cash Bestand: {{ $portfolio->cash() }} {{$portfolio->currency()}}</h4>
        <h4>{{ $stock->name($symbol) }} {{ $stock->price($symbol) }} ({{$stock->currency($symbol)}})</h4>


        <!-- Form with method POST -->
        {!! Form::open(['route' => ['positions.store', $portfolio->id], 'method' => 'POST']) !!}

            <input type="hidden" name="symbol" value ="{{ $symbol }}">
            <input type="hidden" name="portfolio_id" value ="{{ $portfolio->id }}">
            <input type="hidden" name="type" value ="{{ $stock->type() }}">

            <!-- amount form input -->
            <div class="form-group">
                {!! Form::label('amount', 'Anzahl:') !!}
                {!! Form::text('amount', null, ['class' => 'form-control']) !!}
            </div>

            <div>
                {!! Form::checkbox('cash_deduct', 'value', true) !!}
                vom Cash abziehen ?
            </div>

            <div class="form-group">
                {!! Form::submit('Übernehmen', ['class' => 'button--right']) !!}
            </div>
        
        {!! Form::close() !!}




    @endsection