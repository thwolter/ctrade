@extends('portfolios.show')

@section('container-content')

    <h4>{{ $position->name() }}</h4>
    <p>aktuell: {{ $position->value }} {{ $position->currency }}</p>


    {!! Form::open([route('positions.destroy'), 'method' => 'DELETE']) !!}

        <div class="form-group">

            {!! Form::submit('Position löschen', ['class' => 'button--right button--danger']) !!}

        </div>

    {!! Form::close() !!}

@endsection