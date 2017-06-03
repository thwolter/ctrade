@extends('layouts.master')

@section('content')

    <section id="content-region-3" class="padding-40 page-tree-bg">
        <div class="container">
            <h3 class="page-tree-text">
                Portfolio anlegen
            </h3>
        </div>
    </section><!--page-tree end here-->
    <div class="space-70"></div>
    

    <div class="container">
        <div class="row">
            <div class="col-lg-6 offset-lg-3">
                <div class="panel panel-default">
                    <div class="my-login-form">
                
                        {!! Form::open(['route' => 'portfolios.store']) !!}
                        <h4 class="text-uppercase">Portfolio erstellen</h4><hr>
                    
                        @include('partials.errors')

                        <!-- portfolio name -->
                        <div class="form-group row">
                            {!! Form::label('name', 'Name', ['class' => 'col-md-3 col-form-label']) !!}
                            <div class="col-md-8">
                                {!! Form::text('name', null, ['class' => 'form-control']) !!}
                            </div>
                        </div><!-- /portfolio name -->

                        <!-- currency -->
                        <div class="form-group row">
                            {!! Form::label('currency', 'Währung', ['class' => 'col-md-3 col-form-label']) !!}
                            <div class="col-md-8">
                                {!! Form::select('currency', $currencies, null, ['class' => 'form-control']) !!}
                            </div>
                        </div><!-- /currecny -->

                        <!-- cash -->
                        <div class="form-group row">
                            {!! Form::label('cash', 'Barbestand', ['class' => 'col-md-3 col-form-label']) !!}
                            <div class="col-md-8">
                                {!! Form::text('cash', null, ['class' => 'form-control']) !!}
                                <span class="help-block">
                                    Barbestand in Portfoliowährung.
                                </span>
                            </div>
                        </div><!-- /cash -->

                    <div class="text-right">
                        <button href="{{ URL::previous() }}" class="btn btn-secondary">Abbrechen</button>
                        {!! Form::submit('Erstellen', ['class' => 'btn theme-btn-color']) !!}
                        </div>
                    </div>

                    {!! Form::close() !!}

                </div>
            </div>
        </div>
    </div>

@endsection


