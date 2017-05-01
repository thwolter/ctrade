@extends('layouts.portfolio')

@section('container-content')

    <div class="key-figure">
        <label class="label">Aktuell</label>
        <span class="value">{{ $portfolio->present()->total() }}</span>
    </div>

    <!-- Form with method get -->
    {!! Form::open(['route' => ['portfolios.edit', $portfolio->id], 'method' => 'get']) !!}



    <!-- submit button -->
        <div class="form-group">

            <label class="col-md-4 control-label" for="button1id"></label>
            <div class="col-md-8">
                <a href="{{ route('portfolios.destroy', $portfolio->id) }}">Portfolio löschen</a>
                {!! Form::submit('Bearbeiten', ['class' => 'btn btn-primary']) !!}
            </div>
         </div>

    {!! Form::close() !!}

@endsection