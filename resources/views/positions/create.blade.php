@extends('search.show')

    @section('instrument-content')


        <h4>verfügbarer Cash Bestand: {{ $portfolio->cash() }} {{$portfolio->currency()}}</h4>
        <h4>{{ $repo->name }} {{ $repo->price }} ({{$repo->currency}})</h4>


        <!-- Form with method POST -->
        {!! Form::open(['route' => ['positions.store', $portfolio->id], 'method' => 'POST']) !!}

            <input type="hidden" name="symbol" value ="{{ $repo->symbol }}">
            <input type="hidden" name="portfolio_id" value ="{{ $portfolio->id }}">
            <input type="hidden" name="type" value ="{{ $repo->type }}">
        
            <div class="form-group">
                {!! Form::submit('Übernehmen', ['class' => 'button--right']) !!}
            </div>
        
        {!! Form::close() !!}




    @endsection