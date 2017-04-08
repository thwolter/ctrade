@extends('portfolios.show')

@section('container-content')

    <p>shows a position with some further information, e.g. current value, risk, etc.</p>

    {!! Form::open(['url' => 'positions/'.$position->id, 'method' => 'delete']) !!}

        <div class="form-group">

            {!! Form::submit('Position löschen', ['class' => 'button--right button--danger']) !!}

        </div>

    {!! Form::close() !!}

@endsection