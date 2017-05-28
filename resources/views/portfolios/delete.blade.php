@extends('layouts.master')

@section('content')

    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Portfolio löschen</div>
                <div class="panel-body">

                    {!! Form::open(['route' => ['portfolios.destroy', $id], 'method' => 'DELETE']) !!}
                    <div class="form-horizontal">
                        <div class="col-md-6 col-md-offset-3">
                            <div class="form-control-static">
                                Löschen kann nicht rückgängig gemacht werden. Fortfahren?
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-3">
                                {!! Form::submit('Portfolio löschen', ['class' => 'btn btn-danger']) !!}
                                <a href="{{ URL::previous() }}" class="btn btn-default">Zurück</a>
                            </div>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection

