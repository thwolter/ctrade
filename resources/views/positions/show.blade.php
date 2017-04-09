@extends('portfolios.show')

@section('container-content')

    <h4>{{ $position->name() }}</h4>
    <p>aktuell: {{ $position->value() }} {{ $position->currency() }}</p>


    {!! Form::open(['url' => 'positions/'.$position->id, 'method' => 'delete']) !!}

        <div class="form-group">

            {!! Form::submit('Position löschen', ['class' => 'button--right button--danger']) !!}

        </div>

    {!! Form::close() !!}

@endsection