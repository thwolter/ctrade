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

    @include('partials.errors')

    <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula
        eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient
        montes.</p>

    <br><br>

    <div id="form">
        {!! Form::open(['route' => ['portfolios.update', $portfolio->id], 'method' => 'PUT',
            'class' => 'form form-horizontal']) !!}

        <input type="hidden" name="active" value="limits">
        <input type="hidden" name="id" value="{{ $portfolio->id }}">


        <!-- Absolute limit -->
        <div class="form-group">
            <label class="col-md-3 control-label">Absolutes Limit</label>
            <div class="col-md-7">
                <div class="checkbox">
                    <label><input type="checkbox" name="limit" value="absolute">aktivieren</label>
                </div>
                <span class="help-block">Der maximal akzeptierte Verlust in der Portfoliowährung innerhalb
                    eines Zeitraumes von {{ $portfolio->settings()->human()->get('period') }}. Der Zeitraum
                    kann unter <i>Parameter</i> angepasst werden.
                </span>
            </div>
        </div>

        <div id="absolute" class="form-group" style="display: none">
            <label class="col-md-3 control-label">Betrag</label>
            <div class="col-md-7">
                <div class="input-group">
                    <span class="input-group-addon">{{ $portfolio->currencyCode() }}</span>
                    <input name="absolute" placeholder="Betrag" class="form-control">
                </div>
            </div>
            <div class="space-10"></div>
        </div>


        <!-- Relative limit -->
        <div class="form-group">
            <label class="col-md-3 control-label">Relatives Limit</label>
            <div class="col-md-7">
                <div class="checkbox">
                    <label><input type="checkbox" name="limit" value="relative">aktivieren</label>
                </div>
                <span class="help-block">Der maximal akzeptierte Verlust in Prozent vom Portfoliowert innerhalb
                    eines Zeitraumes von {{ $portfolio->settings()->human()->get('period') }}. Der Zeitraum
                    kann unter <i>Parameter</i> angepasst werden.
                </span>
            </div>
        </div>

        <div id="relative" class="form-group" style="display: none">
            <label class="col-md-3 control-label">Prozent</label>
            <div class="col-md-7">
                <div class="input-group">
                    <span class="input-group-addon">%</span>
                    <input name="relative" placeholder="Betrag" class="form-control">
                </div>
            </div>
        </div>


        <!-- Floor limit -->
        <div class="form-group">
            <label class="col-md-3 control-label">Mindestwert</label>
            <div class="col-md-7">
                <div class="checkbox">
                    <label><input type="checkbox" name="limit" value="floor">aktivieren</label>
                </div>
                <span class="help-block">Der Mindestwert, den das Portfolio jederzeit aufweisen soll.
                    Bei dieser Limitart wird angenommen, dass das Portfolio am Ende
                    eines Zeitraumes von {{ $portfolio->settings()->human()->get('period') }} angepasst werden
                    kann sofern um Risiken weiter zu senken.
                    Der Zeitraum kann unter <i>Parameter</i> angepasst werden.
                </span>
            </div>
        </div>

        <div id="floor" class="form-group" style="display: none">
            <label class="col-md-3 control-label">Betrag</label>
            <div class="col-md-7">
                <div class="input-group">
                    <span class="input-group-addon">{{ $portfolio->currencyCode() }}</span>
                    <input name="floor" placeholder="Betrag" class="form-control">
                </div>
            </div>
        </div>


        <!-- Target limit -->
        <div class="form-group">
            <label class="col-md-3 control-label">Zielwert</label>
            <div class="col-md-7">
                <div class="checkbox">
                    <label><input type="checkbox" name="limit" value="target">aktivieren</label>
                </div>
                <span class="help-block">Der Mindestwert, den das Portfolio am Ende einer festgelegten
                    Periode ausweisen soll. Bei dieser Limitart wird davon ausgegangen, dass keine
                    Anpassung des Portfolio bis zum Ende der gewählten Period erfolgen soll.
                </span>
            </div>
        </div>

        <div id="target" class="form-group" style="display: none">
            <label class="col-md-3 control-label">Betrag</label>
            <div class="col-md-7">
                <div class="input-group">
                    <span class="input-group-addon">{{ $portfolio->currencyCode() }}</span>
                    <input name="target" placeholder="Betrag" class="form-control">
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