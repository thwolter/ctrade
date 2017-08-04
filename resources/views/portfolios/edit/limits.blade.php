<div class="tab-pane fade in {{ active_tab(session('active'), 'limits') }}" id="limits">

    <div class="heading-block">
        <h3>
            Limit Einstellungen
        </h3>
    </div>

    @if (session('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    @include('partials.errors')

    <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula
        eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient
        montes.</p>

    <br><br>

    <div id="form">
        {!! Form::open(['route' => ['limits.set', $portfolio->id], 'method' => 'POST',
            'class' => 'form form-horizontal']) !!}

        <input type="hidden" name="active" value="limits">
        <input type="hidden" name="id" value="{{ $portfolio->id }}">


        <!-- Absolute limit -->
        @php
            $type = 'absolute';
            $checked = ($limit->active($type)) ? "checked" : "";
            $visible = ($checked) ? "inherit" : "none";
            $value = ($checked) ? (string)$limit->get($type)->value : null;
        @endphp

        <div class="form-group">
            <label class="col-md-3 control-label limit-label">Absolutes Limit</label>
            <div class="col-md-7">
                <div class="checkbox">
                    <label><input type="checkbox" name="absolute" value="absolute" {{ $checked }}>Aktivieren</label>
                </div>
                <span class="help-block">Der maximal akzeptierte Verlust in der Portfoliowährung innerhalb
                    eines Zeitraumes von {{ $portfolio->settings()->human()->get('period') }}. Der Zeitraum
                    kann unter <i>Parameter</i> angepasst werden.
                </span>
            </div>
        </div>

        <div id="absolute" class="limit-form" style="display: {{ $visible }}">
            <div class="form-group">
                <label class="col-md-3 control-label">Betrag</label>
                <div class="col-md-7">
                    <div class="input-group">
                        <span class="input-group-addon">{{ $portfolio->currencyCode() }}</span>
                        <input type="number" name="absolute_value" placeholder="Betrag"
                               class="form-control" step="0.01" min="0" value="{{ $value }}">
                    </div>
                </div>
            </div>
        </div>


        <!-- Relative limit -->
        @php
            $type = 'relative';
            $checked = ($limit->active($type)) ? "checked" : "";
            $visible = ($checked) ? "inherit" : "none";
            $value = ($checked) ? (string)$limit->get($type)->value : null;

        @endphp

        <div class="form-group">
            <label class="col-md-3 control-label limit-label">Relatives Limit</label>
            <div class="col-md-7">
                <div class="checkbox">
                    <label><input type="checkbox" name="{{ $type }}" value="{{ $type }}" {{ $checked }}>Aktivieren</label>
                </div>
                <span class="help-block">Der maximal akzeptierte Verlust in Prozent vom Portfoliowert innerhalb
                    eines Zeitraumes von {{ $portfolio->settings()->human()->get('period') }}. Der Zeitraum
                    kann unter <i>Parameter</i> angepasst werden.
                </span>
            </div>
        </div>

        <div id="relative" class="limit-form" style="display: {{ $visible }}">
            <div class="form-group">
                <label class="col-md-3 control-label">Prozent</label>
                <div class="col-md-7">
                    <div class="input-group">
                        <span class="input-group-addon">%</span>
                        <input type="number" name="{{ $type.'_value'}}" placeholder="Betrag"
                               class="form-control" step="0.01" min="0" max="100" value="{{ $value }}">
                    </div>
                </div>
            </div>
        </div>


        <!-- Floor limit -->
        @php
            $type = 'floor';
            $checked = ($limit->active($type)) ? "checked" : "";
            $visible = ($checked) ? "inherit" : "none";
            $value = ($checked) ? (string)$limit->get($type)->value : null;

        @endphp

        <div class="form-group">
            <label class="col-md-3 control-label limit-label">Mindestwert</label>
            <div class="col-md-7">
                <div class="checkbox">
                    <label><input type="checkbox" name="{{ $type }}" value="{{ $type }}" {{ $checked }}>Aktivieren</label>
                </div>
                <span class="help-block">Der Mindestwert, den das Portfolio jederzeit aufweisen soll.
                    Bei dieser Limitart wird angenommen, dass das Portfolio am Ende
                    eines Zeitraumes von {{ $portfolio->settings()->human()->get('period') }} angepasst werden
                    kann sofern um Risiken weiter zu senken.
                    Der Zeitraum kann unter <i>Parameter</i> angepasst werden.
                </span>
            </div>
        </div>

        <div id="floor" class="limit-form" style="display: {{ $visible }}">
            <div class="form-group">
                <label class="col-md-3 control-label">Betrag</label>
                <div class="col-md-7">
                    <div class="input-group">
                        <span class="input-group-addon">{{ $portfolio->currencyCode() }}</span>
                        <input type="number" name="{{ $type.'_value' }}" placeholder="Betrag"
                               class="form-control" step="0.01" min="0" value="{{ $value }}">
                    </div>
                </div>
            </div>
        </div>


        <!-- Target limit -->
        @php
            $type = 'target';
            $checked = ($limit->active($type)) ? "checked" : "";
            $visible = ($checked) ? "inherit" : "none";
            $value = ($checked) ? (string)$limit->get($type)->value : null;
            $date = ($checked) ? $limit->get($type)->date : null;
        @endphp

        <div class="form-group">
            <label class="col-md-3 control-label limit-label">Zielwert</label>
            <div class="col-md-7">
                <div class="checkbox">
                    <label><input type="checkbox" name="{{ $type }}" value="{{ $type }}" {{ $checked }}>Aktivieren</label>
                </div>
                <span class="help-block">Der Mindestwert, den das Portfolio am Ende einer festgelegten
                    Periode ausweisen soll. Bei dieser Limitart wird davon ausgegangen, dass keine
                    Anpassung des Portfolio bis zum Ende der gewählten Period erfolgen soll.
                </span>
            </div>
        </div>

        <div id="target" class="limit-form" style="display: {{ $visible }}">

            <!-- Limit amount -->
            <div class="form-group">
                <label class="col-md-3 control-label">Mindestwert</label>
                <div class="col-md-7">
                    <div class="input-group">
                        <span class="input-group-addon">{{ $portfolio->currencyCode() }}</span>
                        <input type="number" name="{{ $type.'_value' }}" placeholder="Betrag"
                               class="form-control" step="0.01" min="0" value="{{ $value }}">
                    </div>
                </div>
            </div>

            <!-- Limit target date -->
            <div class="form-group">
                <label class="col-md-3 control-label">Datum</label>
                <div class="col-md-7">
                    <div class="input-group">
                        <div id="datepicker" class="input-group date" data-provide="datepicker">
                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                            <input type="date" name="{{ $type.'_date' }}" class="form-control"
                                   placeholder="Datum" value="{{ $date }}">
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- Buttons -->
        <div class="form-group">
            <div class="col-md-7 col-md-push-3">
                <button type="submit" class="btn btn-primary">Speichern</button>
                <button type="reset" class="btn btn-default">Abbrechen</button>
            </div>
        </div>

        {!! Form::close() !!}
    </div>

</div>

@section('scripts.footer')
    <script type="text/javascript">
        $(document).ready(function () {
            $('input[type="checkbox"]').click(function () {
                var inputValue = $(this).attr("value");
                $("#" + inputValue).toggle();
            });
        });
    </script>
@endsection