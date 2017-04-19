@extends('layouts.master')

@section('content')

    <div class="ct-panel">
        <div class="ct-panel__ct-header ct-header">
            <h3 class="title">Portfolio: {{ $portfolio->name }}</h3>
        </div>

        <div class="ct-panel__ct-body">

            <!-- Form with method PUT -->
            {!! Form::open(['route' => ['portfolios.update', $portfolio->id], 'method' => 'PUT']) !!}

                <div class="form-horizontal">
                    <fieldset>

                        @include('layouts.errors')

                        <!-- Text input-->
                        <div class="form-group">
                            <!-- name form input -->
                            <div class="form-group">
                                {!! Form::label('name', 'Name:', ['class' => 'col-md-4 control-label']) !!}
                                <div class="col-md-4">
                                    {!! Form::text('name', $portfolio->name, ['class' => 'form-control input-md']) !!}
                                    <span class="help-block">Den Portfolionamen kannst du jederzeit ändern</span>
                                </div>
                            </div>
                        </div>

                        <!-- currency form input -->
                        <div class="form-group">
                            <div class="form-group">
                                {!! Form::label('currency', 'Währung:', ['class' => 'col-md-4 control-label']) !!}
                                    <div class="col-md-4">
                                        {!! Form::text('currency', $portfolio->currency, ['class' => 'form-control input-md']) !!}
                                        <span class="help-block">Gib eine gültige Währung ein</span>
                                    </div>
                                </div>
                            </div>

                        <!-- submit button -->
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
        </div>
    </div>

@endsection



