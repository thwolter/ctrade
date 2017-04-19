@extends('portfolios.show')

@section('container-content')

    <h4>{{ $position->name() }}</h4>
    <p>aktuell: {{ $position->amount() }} </p>


    {!! Form::open([route('positions.destroy', ['portfolio' => $portfolio->id, 'position' => $position->id]), 'method' => 'DELETE']) !!}

        <div class="form-group">

            {!! Form::submit('Position löschen', ['class' => 'button--right button--danger']) !!}

        </div>

    {!! Form::close() !!}

@endsection