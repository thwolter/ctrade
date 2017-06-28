@extends('layouts.master')

@section('content')

    @php ($focus = 'Neues Portfolio')

    <div class="content">
        <div class="container">

            <div class="row">
                <canvas id="myChart" width="400" height="400"></canvas>
                <line-chart></line-chart>
            </div>

            <div class="row">
                <section class="demo-section">

                    <div class="portlet portlet-boxed">

                        <div class="portlet-header">
                            <h4 class="portlet-title">
                                Accordion Panel
                            </h4>
                        </div> <!-- /.portlet-header -->

                        <div class="portlet-body">

                            <div class="panel-group accordion-panel" id="accordion-paneled">

                                <div class="panel open">

                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion-paneled" href="#collapseOne">

                                                Collapsible Group Item #1
                                            </a>
                                        </h4>
                                    </div> <!-- /.panel-heading -->

                                    <div id="collapseOne" class="panel-collapse collapse in">
                                        <div class="panel-body">
                                            Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
                                        </div> <!-- /.panel-body -->
                                    </div> <!-- /.panel-collapse -->

                                </div> <!-- /.panel -->

                                <div class="panel ">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion-paneled" href="#collapseTwo">
                                                Collapsible Group Item #2
                                            </a>
                                        </h4>
                                    </div> <!-- /.panel-heading -->

                                    <div id="collapseTwo" class="panel-collapse collapse">
                                        <div class="panel-body">
                                            Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
                                        </div> <!-- /.panel-body -->
                                    </div> <!-- /.panel-collapse -->

                                </div> <!-- /.panel -->

                                <div class="panel ">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion-paneled" href="#collapseThree">
                                                Collapsible Group Item #3
                                            </a>
                                        </h4>
                                    </div> <!-- /.panel-heading -->

                                    <div id="collapseThree" class="panel-collapse collapse">
                                        <div class="panel-body">
                                            Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
                                        </div> <!-- /.panel-body -->
                                    </div> <!-- /.panel-collapse -->

                                </div> <!-- /.panel -->

                                <div class="panel ">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion-paneled" href="#collapseFour">
                                                Collapsible Group Item #4
                                            </a>
                                        </h4>
                                    </div> <!-- /.panel-heading -->

                                    <div id="collapseFour" class="panel-collapse collapse">
                                        <div class="panel-body">
                                            Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
                                        </div> <!-- /.panel-body -->
                                    </div> <!-- /.panel-collapse -->

                                </div> <!-- /.panel -->

                            </div> <!-- /.accordion -->

                        </div> <!-- /.portlet-body -->

                    </div> <!-- /.portlet -->

                </section> <!-- /.demo-section -->
            </div> <!-- /.row -->
        </div> <!-- /.container -->
    </div> <!-- /.content -->



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



@endsection


