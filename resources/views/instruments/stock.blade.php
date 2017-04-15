@extends('search.show')

    @section('instrument-content')

        <p>Name: {{ $instrument->name() }}</p>
        <p>Price: {{ $instrument->price() }}</p>

        <!-- Form with method POST -->
        {!! Form::open(['route' => ['positions.store', $portfolio->id], 'method' => 'POST']) !!}

            <input type="hidden" name="symbol" value ="{{ $instrument->symbol() }}">
            <input type="hidden" name="portfolio_id" value ="{{ $portfolio->id }}">
            <input type="hidden" name="type" value ="{{ $instrument->type() }}">
        
            <div class="form-group">
                {!! Form::submit('Übernehmen', ['class' => 'button--right']) !!}
            </div>
        
        {!! Form::close() !!}




    @endsection