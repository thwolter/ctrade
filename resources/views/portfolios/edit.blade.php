@extends('layouts.portfolio')

@section('container-content')

    <!-- Form with method PUT -->
    {!! Form::open(['route' => ['portfolios.update', $portfolio->id], 'method' => 'PUT']) !!}

        @include('partials.errors')

        <!-- name form input -->
        <div class="form-group row">
            {!! Form::label('name', 'Name', ['class' => 'col-md-3 offset-md-1 col-form-label']) !!}
            <div class="col-md-8">
                {!! Form::text('name', $portfolio->name, ['class' => 'form-control input-md']) !!}
                <span class="help-block">Den Portfolionamen kannst du jederzeit ändern</span>
            </div>
        </div>

        <!-- currency form input -->
        <div class="form-group row">
            {!! Form::label('currency', 'Währung', ['class' => 'col-md-3 offset-md-1 col-form-label']) !!}
            <div class="col-md-8">
                <div class="form-control-static">{{ $portfolio->currencyCode() }}</div>
                <span class="help-block">Die Währung kann nachträglich nicht geändert werden</span>
            </div>
        </div><hr>

        <!-- confidence level form input -->
        <div class="form-group row">
            {!! Form::label('confidence', 'Sicherheit', ['class' => 'col-md-3 offset-md-1 col-form-label']) !!}
            <div class="col-md-8">
                {!! Form::text('confidence', $portfolio->settings('confidence_level'), ['class' => 'form-control input-md']) !!}
                <span class="help-block">Konfidencelevel</span>
            </div>
        </div>

        <!-- period form input -->
        <div class="form-group row">
            {!! Form::label('horizon', 'Periode', ['class' => 'col-md-3 offset-md-1 col-form-label']) !!}
            <div class="col-md-8">
                {!! Form::text('horizon', $portfolio->settings('horizon'), ['class' => 'form-control input-md']) !!}
                <span class="help-block">Zeiteinheit</span>
            </div>
        </div><hr>

        <!-- mailing form input -->
        <div class="form-group row">
            {!! Form::label('mailing', 'Email', ['class' => 'col-md-3 offset-md-1 col-form-label']) !!}
            <div class="col-md-8">
                {!! Form::text('mailing', $portfolio->mailing, ['class' => 'form-control input-md']) !!}
                <span class="help-block">Häufigkeit für Mailversand</span>
            </div>
        </div>

        <!-- threshold form input -->
        <div class="form-group row">
            {!! Form::label('threshold', 'Threshold', ['class' => 'col-md-3 offset-md-1 col-form-label']) !!}
            <div class="col-md-8">
                {!! Form::text('threshold', $portfolio->threshold, ['class' => 'form-control input-md']) !!}
                <span class="help-block">Grenze, ab der Mail geschickt wird</span>
            </div>
        </div><hr>

        <!-- limit form input -->
        <div class="form-group row">
            {!! Form::label('limit', 'Limit', ['class' => 'col-md-3 offset-md-1 col-form-label']) !!}
            <div class="col-md-8">
                {!! Form::text('limit', $portfolio->limit, ['class' => 'form-control input-md']) !!}
                <span class="help-block">Verlustlimit</span>
            </div>
        </div>

        <!-- limit_abs form input -->
        <div class="form-group row">
            <div class="col-md-8 offset-md-4">
                {!! Form::checkbox('limit_abs', 'yes', $portfolio->limit_abs, ['class' => '']) !!}
                 Absolutes Limit
                <span class="help-block">Verlustlimit</span>
            </div>
        </div><hr>

        <!-- delete portfolio -->
        <div class="form-group row">
            {!! Form::label('delete', 'Löschen', ['class' => 'col-md-3 offset-md-1 col-form-label']) !!}
            <div class="col-md-8">
                <div class="form-control-static">
                    {!! Form::checkbox('delete', 'yes', false) !!}
                    unwiderruflich löschen?
                    <p class="help-block">Achtung: kann nicht rückgängig gemacht werden</p>
                </div>
            </div>
        </div>

        <!-- submit button -->
        <div class="text-right">
            <button href="{{ URL::previous() }}" class="btn btn-secondary">Abbrechen</button>
            {!! Form::submit('Speichern', ['class' => 'btn theme-btn-color']) !!}
        </div>

    {!! Form::close() !!}

    <div class="space-40"></div>
    <h4>Portfolio Bild</h4>
    <div class="space-10"></div>
    <form id="add-image-form" action="{{ route('image.upload', ['id' => $portfolio->id]) }}" method="POST" class="dropzone">
        {{ csrf_field() }}
        <input type="file" name="file" />
    </form>

@endsection


@section('scripts.footer')
    <script src="{{ asset('js/dropzone.js') }}"></script>
@endsection


@section('css.header')
    <link href="{{ asset('css/basic.css') }}" rel="stylesheet">
    <link href="{{ asset('css/dropzone.css') }}" rel="stylesheet">
@endsection



