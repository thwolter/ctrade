<h2 class="h4 g-font-weight-300">Parameter</h2>

<p class="g-mb-25">Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula
    eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient
    montes.</p>

<div id="form">
    {!! Form::open(['route' => 'limits.set', 'method' => 'POST',
        'class' => 'g-brd-gray-light-v4 g-pa-30 g-mb-30']) !!}

    <input type="hidden" name="active_tab" value="limits">
    <input type="hidden" name="id" value="{{ $portfolio->id }}">


    <!-- Absolute limit -->
    <div class="g-brd-around g-brd-gray-light-v4 g-pa-30 g-mb-30">
        @php
            $type = 'absolute';
            $checked = ($limit->active($type)) ? "checked" : "";
            $value = (string)optional($limit->get($type))->value;
        @endphp

        <div class="form-group">
            <label class="d-flex align-items-center">
                <div class="u-check">
                    <input class="g-hidden-xs-up g-pos-abs g-top-0 g-right-0" name="absolute" value="absolute"
                           type="checkbox" {{ $checked }}>
                    <div class="u-check-icon-radio-v7">
                        <i class="fa" data-check-icon=""></i>
                    </div>
                </div>
                <strong class="g-pl-20">Absolutes Limit</strong>
            </label>
        </div>

        <div class="form-group row g-mb-25">
            <div class="col-sm-9 g-mt-10">
                <div class="input-group g-brd-primary--focus">
                    <div class="input-group-addon d-flex align-items-center g-bg-white g-color-gray-light-v1 rounded-0">
                        {{ $portfolio->currency->code }}</div>
                    <input type="text" name="absolute_value" placeholder="0,00"
                           class="form-control form-control-md rounded-0" value="{{ $value }}">
                </div>
            </div>
        </div>
        <small class="form-text text-muted g-font-size-default g-mt-10">
            Der maximal akzeptierte Verlust in der Portfoliowährung innerhalb
            eines Zeitraumes von {{ $portfolio->settings()->human()->get('period') }}. Der Zeitraum
            kann unter Parameter angepasst werden.
        </small>
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
                    <span class="input-group-addon">{{ $portfolio->currency->code }}</span>
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
                    <span class="input-group-addon">{{ $portfolio->currency->code }}</span>
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


@section('scripts.footer')
    <script type="text/javascript">
        $(document).on('ready', function () {
            console.log('pressed');
            $('input[type="checkbox"]').click(function () {
                let inputValue = $(this).attr("value");
                console.log(inputValue);
                $("#" + inputValue).toggle();
            });
        });
    </script>
@endsection