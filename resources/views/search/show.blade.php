@extends('layouts.portfolio')

@section('container-content')

    {!! Form::open(['route' => ['positions.store', $portfolio->id], 'method' => 'POST']) !!}

    {!! Form::hidden('type', get_class($item)) !!}
    {!! Form::hidden('itemId', $item->id) !!}

    <div class="form-horizontal">

        <fieldset>
            <!-- Form Name -->
            <legend>{{ $item->name}}</legend>


            <div class="form-group">
                {!! Form::label('type', $item->typeDisp, ['class' => 'col-md-4 control-label']) !!}
                <div class="col-md-8">
                    <span> {{ $item->name }}</span>
                    <span class="help-block">ISIN: {{ $item->isin }} | WKN: {{ $item->wkn }}</span>
                </div>
            </div>

            <div class="form-group">
                {!! Form::label('price', 'Kurs', ['class' => 'col-md-4 control-label']) !!}
                <div class="col-md-8">
                    <span> {{ $item->price() }}</span>
                    <span class="help-block">Stand ...</span>
                </div>
            </div>

            <div class="form-group">
                {!! Form::label('amount', 'Stückzahl:', ['class' => 'col-md-4 control-label']) !!}
                <div class="col-md-8">
                    {!! Form::number('amount', 0, ['class' => 'form-control input-md']) !!}
                    <span class="help-block">Anzahl</span>
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


@endsection


