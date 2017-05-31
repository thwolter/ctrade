@extends('layouts.portfolio')

@section('container-content')

    {!! Form::open(['route' => ['positions.update', $portfolio->id, $position->id], 'method' => 'PUT']) !!}

        <!-- Form Name -->
        <h4>{{ $position->typeDisp() }} | {{ $position->name() }} ({{ $position->present()->price() }})</h4>

        <!-- amount form input -->
        <div class="form-group row">
            {!! Form::label('amount', 'Neue Stückzahl:', ['class' => 'col-md-3 offset-md-1 col-form-label']) !!}
            <div class="col-md-8">
                {!! Form::number('amount', $position->amount(), ['class' => 'form-control input-md']) !!}
                <span class="help-block">Trage 0 ein, um die Position zu löschen</span>
            </div>
        </div>

        @include('partials.charging')

        <!-- Button (Double) -->
        <div class="text-right">
            {!! Form::submit('Speichern', ['class' => 'btn theme-btn-color']) !!}
            <button href="{{ URL::previous() }}" class="btn theme-btn-outline">Abbrechen</button>
        </div>

    {!! Form::close() !!}

@endsection


