@extends('layouts.master')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Portfolio erstellen</div>
                <div class="panel-body">
                    {!! Form::open(['route' => 'portfolios.store']) !!}

                    @include('partials.errors')

                    <div class="form-group">
                        {!! Form::label('name', 'Name:', ['class' => 'col-md-3 col-md-offset-1 control-label']) !!}
                        <div class="col-md-8">
                            {!! Form::text('name', null, ['class' => 'form-control']) !!}
                            <span class="help-block">Wie soll dein Portfolio heißen?</span>
                        </div>
                    </div>

                    <div class="form-group">
                        {!! Form::label('currency', 'Währung:', ['class' => 'col-md-3 col-md-offset-1 control-label']) !!}
                        <div class="col-md-8">
                            {!! Form::select('currency', $currencies, ['class' => 'form-control']) !!}
                            <span class="help-block">
                                Währung, in der das Portfolio geführt wird.
                            </span>
                        </div>
                    </div>

                    <div class="form-group">
                        {!! Form::label('cash', 'Barbestand:', ['class' => 'col-md-3 col-md-offset-1 control-label']) !!}
                        <div class="col-md-8">
                            {!! Form::text('cash', null, ['class' => 'form-control col-md-3']) !!}
                            <span class="help-block">
                                Barbestand in Portfoliowährung.
                            </span>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="pull-right">
                            <a href="{{ URL::previous() }}" class="btn btn-default">Abbrechen</a>
                            {!! Form::submit('Portfolio erstellen', ['class' => 'btn btn-primary']) !!}
                        </div>
                    </div>

                    {!! Form::close() !!}

                </div>
            </div>
        </div>
    </div>
</div>
@endsection



