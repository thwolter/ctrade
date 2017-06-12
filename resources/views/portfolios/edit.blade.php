@extends('layouts.portfolio')

@section('container-content')


    @include('partials.errors')

    <!-- main settings -->
    <div class="row">
        <div class="container">

            <!-- portfolio general -->
            <div class="setup-panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">Einstellungen</h4>
                </div>
                <div class="panel-body">

                    <!-- Form with method PUT -->
                    {!! Form::open(['route' => ['portfolios.update', $portfolio->id], 'method' => 'PUT']) !!}

                        <!-- general-->
                        <div>
                                <div class="sub-heading">
                                    <h4 class="sub-title">Allgemein</h4>
                                </div>

                                <!-- name form input -->
                                <div class="form-group row">
                                    {!! Form::label('name', 'Name', ['class' => 'col-md-2 offset-md-1 col-form-label']) !!}
                                    <div class="col-md-8">
                                        {!! Form::text('name', $portfolio->name, ['class' => 'form-control input-md']) !!}
                                        <span class="help-block">Den Portfolionamen kannst du jederzeit ändern</span>
                                    </div>
                                </div>

                                <!-- currency form input -->
                                <div class="form-group row">
                                    {!! Form::label('currency', 'Währung', ['class' => 'col-md-2 offset-md-1 col-form-label']) !!}
                                    <div class="col-md-8">
                                        <div class="form-control">{{ $portfolio->currencyCode() }}</div>
                                        <span class="help-block">Die Währung kann nachträglich nicht geändert werden</span>
                                    </div>
                                </div>
                            </div> <!-- /general-->

                        <!-- risk parameter-->
                        <div>
                                <div class="sub-heading">
                                    <h4 class="sub-title">Risiko Parameter</h4>
                                </div>

                                <div class="space-10"></div>

                                <div class="form-group row">
                                    {!! Form::label('confidence', 'Sicherheit', ['class' => 'col-md-2 offset-md-1 col-form-label']) !!}
                                    <div class="col-md-8">
                                        @php($level = $portfolio->settings('levelConfidence'))
                                        <div>{!! Form::radio('levelConfidence', 1, ($level == 1),
                                        ['class' => '']) !!} hohe Sicherheit</div>
                                        <div>{!! Form::radio('levelConfidence', 2, ($level == 2),
                                        ['class' => '']) !!} ausgewogenes Sicherheitsnivau</div>
                                        <div>{!! Form::radio('levelConfidence', 3, ($level == 3),
                                        ['class' => '']) !!} risikofreudig</div>
                                        <span class="help-block">Das Sicherheitsniveau ...</span>
                                    </div>
                                </div>

                                <!-- period form input -->
                                <div class="form-group row">
                                {!! Form::label('horizon', 'Periode', ['class' => 'col-md-2 offset-md-1 col-form-label']) !!}
                                <div class="col-md-8">
                                    {!! Form::text('horizon', $portfolio->settings('horizon'), ['class' => 'form-control input-md']) !!}
                                    <span class="help-block">Zeiteinheit</span>
                                </div>
                            </div>
                            </div><!-- /risk parameter-->

                        <!-- email-->
                        <div>
                                <div class="sub-heading">
                                    <h4 class="sub-title">Email</h4>
                                </div>

                                <!-- mailing form input -->
                                <div class="form-group row">
                                    {!! Form::label('mailing', 'Email', ['class' => 'col-md-2 offset-md-1 col-form-label']) !!}
                                    <div class="col-md-8">
                                        {!! Form::text('mailing', $portfolio->mailing, ['class' => 'form-control input-md']) !!}
                                        <span class="help-block">Häufigkeit für Mailversand</span>
                                    </div>
                                </div>

                                <!-- threshold form input -->
                                <div class="form-group row">
                                    {!! Form::label('threshold', 'Threshold', ['class' => 'col-md-2 offset-md-1 col-form-label']) !!}
                                    <div class="col-md-8">
                                        {!! Form::text('threshold', $portfolio->threshold, ['class' => 'form-control input-md']) !!}
                                        <span class="help-block">Grenze, ab der Mail geschickt wird</span>
                                    </div>
                                </div>
                            </div><!-- /email-->

                        <!-- submit button -->
                        <div class="space-40"></div>
                        <div class="offset-md-1">
                            {!! Form::submit('Änderungen speichern', ['class' => 'btn theme-btn-color-outline']) !!}
                        </div>
                        <div class="space-20"></div>

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div><!-- main settings -->

    <!-- delete section -->
    <div class="row">
        <div class="container">
            <!-- delete -->
            <div class="setup-panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">Portfolio löschen</h4>
                    </div>
                    <div class="panel-body">
                        <div class="offset-md-1 remark">
                            Mit dem Portfolio werden alle dazugehörigen Transaktionen und Positionen gelöscht!
                        </div>

                        <div class="space-10"></div>

                        <div class="offset-md-1">
                            {!! Form::open(['route' => ['portfolios.destroy', $portfolio->id], 'method' => 'DELETE']) !!}
                                {!! Form::submit('Portfolio löschen', ['class' => 'btn btn-danger']) !!}
                            {!! Form::close() !!}
                        </div>
                        <div class="space-20"></div>


                    </div>
                </div><!-- /delete -->
        </div>
    </div> <!-- /delete section -->

    <!-- image section -->
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



