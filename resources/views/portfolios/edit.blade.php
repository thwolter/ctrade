@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-md-8 col-md-offset-2 ">
            <div class="panel panel-default">
                <div class="panel-heading">{{ $portfolio->name }}</div>
                <div class="panel-body">

                    <!-- Form with method PUT -->
                    {!! Form::open(['route' => ['portfolios.update', $portfolio->id], 'method' => 'PUT']) !!}
                        <div class="form-horizontal">
                            @include('partials.errors')

                            <!-- name form input -->
                            <div class="form-group">
                                {!! Form::label('name', 'Name', ['class' => 'col-md-4 control-label']) !!}
                                <div class="col-md-6">
                                    {!! Form::text('name', $portfolio->name, ['class' => 'form-control input-md']) !!}
                                    <span class="help-block">Den Portfolionamen kannst du jederzeit ändern</span>
                                </div>
                            </div>


                            <!-- confidence level form input -->
                            <div class="form-group">
                                {!! Form::label('confidence', 'Sicherheit', ['class' => 'col-md-4 control-label']) !!}
                                <div class="col-md-6">
                                    {!! Form::text('confidence', $portfolio->confidence, ['class' => 'form-control input-md']) !!}
                                    <span class="help-block">Konfidencelevel</span>
                                </div>
                            </div>

                            <!-- period form input -->
                            <div class="form-group">
                                {!! Form::label('period', 'Periode', ['class' => 'col-md-4 control-label']) !!}
                                <div class="col-md-6">
                                    {!! Form::text('period', $portfolio->period, ['class' => 'form-control input-md']) !!}
                                    <span class="help-block">Zeiteinheit</span>
                                </div>
                            </div>

                            <!-- mailing form input -->
                            <div class="form-group">
                                {!! Form::label('mailing', 'Email', ['class' => 'col-md-4 control-label']) !!}
                                <div class="col-md-6">
                                    {!! Form::text('mailing', $portfolio->mailing, ['class' => 'form-control input-md']) !!}
                                    <span class="help-block">Häufigkeit für Mailversand</span>
                                </div>
                            </div>

                            <!-- threshold form input -->
                            <div class="form-group">
                                {!! Form::label('threshold', 'Threshold', ['class' => 'col-md-4 control-label']) !!}
                                <div class="col-md-6">
                                    {!! Form::text('threshold', $portfolio->threshold, ['class' => 'form-control input-md']) !!}
                                    <span class="help-block">Grenze, ab der Mail geschickt wird</span>
                                </div>
                            </div>

                            <!-- limit form input -->
                            <div class="form-group">
                                {!! Form::label('limit', 'Limit', ['class' => 'col-md-4 control-label']) !!}
                                <div class="col-md-6">
                                    {!! Form::text('limit', $portfolio->limit, ['class' => 'form-control input-md']) !!}
                                    <span class="help-block">Verlustlimit</span>
                                </div>
                            </div>

                            <!-- limit_abs form input -->
                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    {!! Form::checkbox('limit_abs', 'yes', $portfolio->limit_abs, ['class' => '']) !!}
                                    Absolutes Limit
                                    <span class="help-block">Verlustlimit</span>
                                </div>
                            </div>

                            <!-- currency form input -->
                            <div class="form-group">
                                {!! Form::label('currency', 'Währung', ['class' => 'col-md-4 control-label']) !!}
                                <div class="col-md-6">
                                    <div class="form-control-static">{{ $portfolio->currencyCode() }}</div>
                                    <span class="help-block">Die Währung kann nachträglich nicht geändert werden</span>
                                </div>
                            </div>

                            <div class="form-group">
                                {!! Form::label('delete', 'Löschen', ['class' => 'col-md-4 control-label']) !!}
                                <div class="col-md-6">
                                    <div class="form-control-static">
                                        {!! Form::checkbox('delete', 'yes', false) !!}
                                        Portfolio löschen
                                        <span class="help-block">Achtung: kann nicht rückgängig gemacht werden</span>
                                    </div>
                                </div>

                            </div>

                            <!-- submit button -->
                            <div class="form-group">
                            <label class="col-md-4 control-label" for="button1id"></label>
                            <div class="col-md-6">
                                {!! Form::submit('Speichern', ['class' => 'btn btn-primary']) !!}
                                <a href="{{ URL::previous() }}" class="btn btn-default">Abbrechen</a>
                            </div>
                        </div>

                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>

@endsection



