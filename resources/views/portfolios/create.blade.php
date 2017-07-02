@extends('layouts.master')

@section('content')

    @php ($focus = 'Portfolio erstellen')

    <div class="content">
        <div class="container">

            @if (count(Auth::user()->portfolios) == 0)
                <div class="row">
                    <div class="alert alert-success">
                        <a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
                        <strong>Willkommen!</strong> Du bist dabei, dein erstes Portfolio anzulegen.
                    </div> <!-- /.alert -->
                </div>
            @endif


            <div class="row">
                <portlet title="Portfolio erstellen">
                    <div class="input-form">

                    {!! Form::open(['route' => 'portfolios.store']) !!}

                    @include('partials.errors')

                    <!-- portfolio name -->
                    <div class="form-group row">
                        {!! Form::label('name', 'Bezeichnung', ['class' => 'col-md-2 col-md-offset-1 col-form-label']) !!}
                        <div class="col-md-3">
                            {!! Form::text('name', null,
                            ['class' => 'form-control', 'placeholder' => 'z.B. Deutsche Standardwerte']) !!}
                        </div>
                    </div><!-- /portfolio name -->

                    <!-- currency -->
                    <div class="form-group row">
                        {!! Form::label('currency', 'Währung', ['class' => 'col-md-2 col-md-offset-1 col-form-label']) !!}
                        <div class="col-md-3">
                            {!! Form::select('currency', $currencies, null, ['class' => 'form-control']) !!}
                        </div>
                    </div><!-- /currecny -->

                    <!-- cash -->
                    <div class="form-group row">
                        {!! Form::label('cash', 'Barbestand', ['class' => 'col-xs-2 col-xs-offset-1 col-form-label']) !!}
                        <div class="col-xs-3">
                            <input-price id="cash" name="cash" class="form-control" symbol="EUR"></input-price>
                            <span class="help-block">
                                Barbestand in Portfoliowährung.
                            </span>
                        </div>
                    </div><!-- /cash -->

                    <div class="col-xs-3 col-xs-push-3">
                        {!! Form::submit('Erstellen', ['class' => 'btn btn-primary']) !!}
                        <button type="reset" class="btn btn-default">Abbrechen</button>
                    </div>

                    {!! Form::close() !!}
                    </div>
                </portlet> <!-- /portlet -->
            </div> <!-- /.row -->

            <!-- help section -->
            <div class="row">
                <portlet title="Hinweise">
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
                    </portlet>
                </div> <!-- /.row -->

        </div> <!-- /.container -->
    </div> <!-- /.content -->
    

@endsection
