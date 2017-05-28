@extends('layouts.master')

@section('content')
    <div class="row">

        <div class="col-md-3">
            @include('layouts.sidebar')
        </div>

        <div class="col-md-9">
            {!! Form::open(['route' => ['positions.store', $portfolio->id],
                'method' => 'POST', 'class' => 'form-horizontal']) !!}

            {!! Form::hidden('type', get_class($item)) !!}
            {!! Form::hidden('itemId', $item->id) !!}


            <fieldset>
                <!-- Form Name -->
                <legend>{{ $item->name}}</legend>

                <!-- item name and key figures -->
                <div class="form-group">
                    {!! Form::label('type', $item->typeDisp, ['class' => 'col-md-3 control-label']) !!}
                    <div class="col-md-8">
                        <div class="form-control-static">{{ $item->name }}</div>
                        <span class="help-block">ISIN: {{ $item->isin }} | WKN: {{ $item->wkn }}</span>
                    </div>
                </div>

                <!-- item price and price date -->
                <div class="form-group">
                    {!! Form::label('price', 'Kurs', ['class' => 'col-md-3 control-label']) !!}
                    <div class="col-md-8">
                        <div class="form-control-static"> {{ $item->present()->price() }}</div>
                        <span class="help-block">{{ $item->present()->priceDate() }}</span>
                    </div>
                </div>

                <!-- item risk -->
                <div class="form-group">
                    {!! Form::label('risk', 'Risiko', ['class' => 'col-md-3 control-label']) !!}
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
                <div class="form-group">
                    {!! Form::label('amount', 'Stückzahl', ['class' => 'col-md-3 control-label']) !!}
                    <div class="col-md-8">
                        {!! Form::number('amount', 0, ['class' => 'form-control input-md']) !!}
                        <span class="help-block">Wieviel Aktien sollen gakauft werden?</span>
                    </div>
                </div>

                <!-- select to deduct from available cash -->
                <div class="form-group">
                    {!! Form::label('deduct', 'Hinzufügen', ['class' => 'col-md-3 control-label']) !!}
                    <div class="col-md-8">
                        <div class="checkbox">
                            {!! Form::radio('deduct', 'yes', true) !!}
                            <span style="padding-left: 7px">Vom cash abziehen</span>
                        </div>
                        <div class="checkbox">
                            {!! Form::radio('deduct', 'no') !!}
                            <span style="padding-left: 7px">Portfolio hinzufügen</span>
                        </div>
                        <span class="help-block">help</span>
                    </div>
                </div>

                <!-- Button (Double) -->
                <div class="form-group">
                    <label class="col-md-3 control-label" for="button1id"></label>
                    <div class="col-md-8">
                        {!! Form::submit('Speichern', ['class' => 'btn btn-primary']) !!}
                        <a href="{{ URL::previous() }}" class="btn btn-default">Abbrechen</a>
                    </div>
                </div>
             </fieldset>
        </div>
    </div>


@endsection


