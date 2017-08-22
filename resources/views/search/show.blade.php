@extends('layouts.portfolio')

@section('container-content')

    <div class="panel-body">

        @include('positions/partials/stock.summary')

        <div class="space-70"></div>
        <div class="container">

            <h4>Aktien kaufen</h4>
            <div class="space-40"></div>

            {!! Form::open(['route' => 'positions.new',
                'method' => 'POST', 'class' => 'form-horizontal']) !!}

                {!! Form::hidden('itemId', $item->id) !!}
                {!! Form::hidden('itemType', get_class($item)) !!}


                <div class="space-70"></div>
                <div class="col-md-8 offset-md-3">
                    {!! Form::submit('Hinzufügen', ['class' => 'btn theme-btn-color']) !!}
                </div>

             {!! Form::close() !!}
        </div>
    </div>
@endsection


