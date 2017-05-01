@extends('layouts.portfolio')

@section('container-content')

    {!! Form::open(['route' => ['positions.update', $portfolio->id, $position->id], 'method' => 'PUT']) !!}

    <div class="form-horizontal">
        <fieldset>

            <!-- Form Name -->
            <legend>{{ $position->typeDisp() }} | {{ $position->name() }} ({{ $position->present()->price() }})</legend>

            <!-- Text input-->
            <div class="form-group">
               <!-- amount form input -->
               <div class="form-group">
                   {!! Form::label('amount', 'Neue Stückzahl:', ['class' => 'col-md-4 control-label']) !!}
                   <div class="col-md-4">
                       {!! Form::number('amount', $position->amount(), ['class' => 'form-control input-md']) !!}
                       <span class="help-block">Trage 0 ein, um die Position zu löschen</span>
                   </div>
               </div>
            </div>

            <!-- Button (Double) -->
            <div class="form-group">
                <label class="col-md-4 control-label" for="button1id"></label>
                <div class="col-md-8">
                    {!! Form::submit('Abbrechen', ['class' => 'btn btn-inverse']) !!}
                    {!! Form::submit('Speichern', ['class' => 'btn btn-primary']) !!}
                </div>
            </div>

        </fieldset>
    </div>

    {!! Form::close() !!}

@endsection


