@extends('layouts.portfolio')

@section('container-content')

    <div class="panel-body">
        @include('positions/partials/stock.summary')

        <div class="space-70"></div>
        <div class="container">

            <h4>Neue Position hinzufügen</h4>
            <div class="space-40"></div>

        {!! Form::open([
            'route' => ['positions.store', $portfolio->id],
            'method' => 'POST', 'class' => 'form-horizontal']) !!}

        {!! Form::hidden('itemId', $item->id) !!}
        {!! Form::hidden('itemType', get_class($item)) !!}


        @include('partials.errors')

        <!-- text field for number of shares -->
            <div class="form-group row">
                {!! Form::label('amount', 'Stückzahl', ['class' => 'col-md-2 offset-md-1 col-form-label']) !!}
                <div class="col-md-2">
                    {!! Form::number('amount', 0, ['class' => 'form-control input-md']) !!}
                </div>
            </div>

        <!-- Button (Double) -->
            <div class="space-70"></div>
            <div class="col-md-8 offset-md-3">
                {!! Form::submit('Kaufen', ['class' => 'btn theme-btn-color']) !!}
                <a href="{{ URL::previous() }}" class="btn btn-secondary">Abbrechen</a>
            </div>

            {!! Form::close() !!}
        </div>
    </div>

@endsection