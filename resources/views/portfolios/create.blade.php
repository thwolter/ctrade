@extends('layouts.master')

@section('content')

    <div class="ct-panel">
        <div class="ct-panel__ct-header ct-header">
            <h3 class="title">Portfolio erstellen</h3>
        </div>

        <div class="ct-panel__ct-body">

            {!! Form::open(['route' => 'portfolios.store']) !!}

            @include('partials.errors')

            <div class="form-group">
                {!! Form::label('name', 'Name:') !!}
                {!! Form::text('name', null, ['class' => 'form-control']) !!}
            </div>

            <div class="form-group">
                {!! Form::label('currency', 'Währung:') !!}
                {!! Form::text('currency', null, ['class' => 'form-control']) !!}
            </div>

            <div class="form-group">
                {!! Form::label('cash', 'Barbestand:') !!}
                {!! Form::text('cash', null, ['class' => 'form-control']) !!}
            </div>

            <div class="form-group">

                {!! Form::submit('Portfolio erstellen', ['class' => 'button--right button--danger']) !!}

            </div>

            {!! Form::close() !!}

        </div>
    </div>

@endsection



