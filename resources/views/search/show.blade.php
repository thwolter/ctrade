@extends('layouts.portfolio')

@section('container-content')

    <div class="panel-body">

        @include('positions/partials/stock.summary')

        <div class="space-70"></div>
        <div class="container">

            <h4>Position dem Portfolio hinzufügen</h4>
            <div class="space-40"></div>

            {!! Form::open(['route' => ['positions.store', $portfolio->id],
                'method' => 'POST', 'class' => 'form-horizontal']) !!}

                {!! Form::hidden('type', get_class($item)) !!}
                {!! Form::hidden('itemId', $item->id) !!}

                @include('partials.errors')

                <!-- text field for number of shares -->
                <div class="form-group row">
                    {!! Form::label('amount', 'Stückzahl', ['class' => 'col-md-2 offset-md-1 col-form-label']) !!}
                    <div class="col-md-2">
                        {!! Form::number('amount', 0, ['class' => 'form-control input-md']) !!}
                    </div>
                </div>

                @include('partials.charging')

                <!-- Button (Double) -->
                <div class="space-70"></div>
                <div class="col-md-8 offset-md-3">
                    {!! Form::submit('Hinzufügen', ['class' => 'btn theme-btn-color']) !!}
                    <a href="{{ URL::previous() }}" class="btn btn-secondary">Abbrechen</a>
                </div>

             {!! Form::close() !!}
        </div>
    </div>
@endsection


