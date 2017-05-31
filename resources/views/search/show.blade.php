@extends('layouts.portfolio')

@section('container-content')


    {!! Form::open(['route' => ['positions.store', $portfolio->id],
        'method' => 'POST', 'class' => 'form-horizontal']) !!}

    {!! Form::hidden('type', get_class($item)) !!}
    {!! Form::hidden('itemId', $item->id) !!}


    <fieldset>
        <!-- Form Name -->
        <legend>{{ $item->name}}</legend>

        <!-- item name and key figures -->
        <div class="form-group row">
            {!! Form::label('type', $item->typeDisp, ['class' => 'col-md-3 offset-md-1 col-form-label']) !!}
            <div class="col-md-8">
                <div class="form-control-static">{{ $item->name }}</div>
                <span class="help-block">ISIN: {{ $item->isin }} | WKN: {{ $item->wkn }}</span>
            </div>
        </div>

        <!-- item price and price date -->
        <div class="form-group row">
            {!! Form::label('price', 'Kurs', ['class' => 'col-md-3 offset-md-1 col-form-label']) !!}
            <div class="col-md-8">
                <div class="form-control-static"> {{ $item->present()->price() }}</div>
                <span class="help-block">{{ $item->present()->priceDate() }}</span>
            </div>
        </div>

        <!-- item risk -->
        <div class="form-group row">
            {!! Form::label('risk', 'Risiko', ['class' => 'col-md-3 offset-md-1 col-form-label']) !!}
            <div class="col-md-8">
                <div class="form-control-static">
                    {{ $item->present()->valueAtRisk() }}
                    <pan style="padding-left: 7px">
                        ({{ $item->present()->percentRisk() }}
                        vom Kurswert)
                    </pan>
                </div>
                <span class="help-block">{{ $item->present()->priceDate() }}</span>
            </div>
        </div>

        <!-- text field for number of shares -->
        <div class="form-group row">
            {!! Form::label('amount', 'Stückzahl', ['class' => 'col-md-3 offset-md-1 col-form-label']) !!}
            <div class="col-md-8">
                {!! Form::number('amount', 0, ['class' => 'form-control input-md']) !!}
                <span class="help-block">Wieviel Aktien sollen gakauft werden?</span>
            </div>
        </div>

        @include('partials.charging')

        <!-- Button (Double) -->
        <div class="form-group">
            <label class="col-md-3 control-label" for="button1id"></label>
            <div class="col-md-8">
                {!! Form::submit('Speichern', ['class' => 'btn theme-btn-color']) !!}
                <button href="{{ URL::previous() }}" class="btn theme-btn-outline">Abbrechen</button>
            </div>
        </div>
    </fieldset>

@endsection


