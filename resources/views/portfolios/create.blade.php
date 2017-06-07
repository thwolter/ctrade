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

    @if (count(Auth::user()->portfolios) == 0)
        <div class="container">
            <div class="row">
                <div class="col-lg-8 offset-lg-2">
                    <div class="space-40"></div>
                    <div class="alert alert-info" role="alert">
                        <p><strong>Los gehts!</strong></p>
                        <p>In einem Portfolio hälst du alle Positions, wie Aktien und Fonds.
                        Von dem Geldbestand kaufst du Positionen, Erlöse aus Verkäufen werden dem Geldbestand wieder
                            gutgeschrieben.</p>
                        <p>Du hast später die Möglichkeit, Einzahlungen und Auszahlungen vorzunehmen.</p>
                    </div>
                    <div class="space-40"></div>

                </div>
            </div>
        </div>
    @endif

    <div class="container">
        <div class="row">
            <div class="col-lg-6 offset-lg-3">
                <div class="panel panel-default">
                    <div class="input-form">
                
                        {!! Form::open(['route' => 'portfolios.store']) !!}
                        <h4 class="text-uppercase">Portfolio erstellen</h4><hr>
                    
                        @include('partials.errors')

                        <!-- portfolio name -->
                        <div class="form-group row">
                            {!! Form::label('name', 'Bezeichnung', ['class' => 'col-md-3 col-form-label']) !!}
                            <div class="col-md-8">
                                {!! Form::text('name', null,
                                ['class' => 'form-control', 'placeholder' => 'z.B. Deutsche Standardwerte']) !!}
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
                                {!! Form::number('cash', 0, ['class' => 'form-control', 'min' => 0, 'step' => '.01']) !!}

                                <span class="help-block">
                                    Barbestand in Portfoliowährung.
                                </span>
                            </div>
                        </div><!-- /cash -->

                        <div class="col-md-8 offset-md-3 button-group">
                            {!! Form::submit('Erstellen', ['class' => 'btn theme-btn-color']) !!}
                        </div>

                    </div>

                    {!! Form::close() !!}

                </div>
            </div>
        </div>
    </div>

    <div class="space-70"></div>
    <div class="space-70"></div>

@endsection


