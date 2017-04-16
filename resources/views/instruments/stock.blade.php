@extends('search.show')

    @section('instrument-content')

        <p>Name: {{ $repo->name }}</p>
        <p>Price: {{ $repo->price }}</p>

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