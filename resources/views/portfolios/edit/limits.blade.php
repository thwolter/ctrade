<h2 class="h4 g-font-weight-300">Limits</h2>

<p class="g-mb-25">
    Lege Limite für dein Portfolio fest. Bei Überschreitung der Limite wirst du automatisch per Mail
    informiert.
</p>

<div id="form">
    {!! Form::open(['route' => 'limits.set', 'method' => 'POST',
        'class' => 'g-brd-gray-light-v4 g-pa-30 g-mb-30']) !!}

    <input type="hidden" name="active_tab" value="limits">
    <input type="hidden" name="id" value="{{ $portfolio->id }}">


    <!-- Absolute limit -->
    <div class="g-brd-around g-brd-gray-light-v4 g-pa-30 g-mb-30">
        @php
            $checked = ($limit->active('absolute')) ? "checked" : "";
            $value = (string)optional($limit->get('absolute'))->value;
        @endphp

        <h4 class="h6 g-font-weight-700 g-mb-20">Absolutes Limit</h4>
        @includeWhen(Session::has('limit_absolute'), 'portfolios.status.limit_'.Session::get('limit_absolute'))


        <div class="form-group">
            <label class="d-flex align-items-center">
                <div class="u-check">
                    <input class="g-hidden-xs-up g-pos-abs g-top-0 g-right-0" name="absolute" value="absolute"
                           type="checkbox" {{ $checked }}>
                    <div class="u-check-icon-radio-v7">
                        <i class="fa" data-check-icon=""></i>
                    </div>
                </div>
                <span class="g-pl-20">aktivieren</span>
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
    <div class="g-brd-around g-brd-gray-light-v4 g-pa-30 g-mb-30">
        @php
            $checked = ($limit->active('relative')) ? "checked" : "";
            $value = (string)optional($limit->get('relative'))->value;
        @endphp

        <h4 class="h6 g-font-weight-700 g-mb-20">Relatives Limit</h4>
        @includeWhen(Session::has('limit_relative'), 'portfolios.status.limit_'.Session::get('limit_relative'))

        <div class="form-group">
            <label class="d-flex align-items-center">
                <div class="u-check">
                    <input type="checkbox" class="g-hidden-xs-up g-pos-abs g-top-0 g-right-0"
                           name="relative" value="relative" {{ $checked }}>
                    <div class="u-check-icon-radio-v7">
                        <i class="fa" data-check-icon=""></i>
                    </div>
                </div>
                <span class="g-pl-20">aktivieren</span>
            </label>
        </div>

        <div class="form-group row g-mb-25">
            <div class="col-sm-9 g-mt-10">
                <div class="input-group g-brd-primary--focus">
                    <div class="input-group-addon d-flex align-items-center g-bg-white g-color-gray-light-v1 rounded-0">
                        {{ $portfolio->currency->code }}</div>
                    <input type="text" name="relative_value" placeholder="0,00"
                           class="form-control form-control-md rounded-0" value="{{ $value }}">
                </div>
            </div>
        </div>
        <small class="form-text text-muted g-font-size-default g-mt-10">
            Der maximal akzeptierte Verlust in Prozent vom Portfoliowert innerhalb
            eines Zeitraumes von {{ $portfolio->settings()->human()->get('period') }}. Der Zeitraum
            kann unter <i>Parameter</i> angepasst werden.
        </small>
    </div>


    <!-- Floor limit -->
    <div class="g-brd-around g-brd-gray-light-v4 g-pa-30 g-mb-30">
        @php
            $checked = ($limit->active('floor')) ? "checked" : "";
            $value = (string)optional($limit->get('floor'))->value;
        @endphp

        <h4 class="h6 g-font-weight-700 g-mb-20">Mindestwert</h4>
        @includeWhen(Session::has('limit_floor'), 'portfolios.status.limit_'.Session::get('limit_floor'))

        <div class="form-group">
            <label class="d-flex align-items-center">
                <div class="u-check">
                    <input type="checkbox" class="g-hidden-xs-up g-pos-abs g-top-0 g-right-0"
                           name="floor" value="floor" {{ $checked }}>
                    <div class="u-check-icon-radio-v7">
                        <i class="fa" data-check-icon=""></i>
                    </div>
                </div>
                <span class="g-pl-20">aktivieren</span>
            </label>
        </div>

        <div class="form-group row g-mb-25">
            <div class="col-sm-9 g-mt-10">
                <div class="input-group g-brd-primary--focus">
                    <div class="input-group-addon d-flex align-items-center g-bg-white g-color-gray-light-v1 rounded-0">
                        {{ $portfolio->currency->code }}</div>
                    <input type="text" name="floor_value" placeholder="0,00"
                           class="form-control form-control-md rounded-0" value="{{ $value }}">
                </div>
            </div>
        </div>
        <small class="form-text text-muted g-font-size-default g-mt-10">
            Der Mindestwert, den das Portfolio jederzeit aufweisen soll.
            Bei dieser Limitart wird angenommen, dass das Portfolio am Ende
            eines Zeitraumes von {{ $portfolio->settings()->human()->get('period') }} angepasst werden
            kann sofern um Risiken weiter zu senken.
            Der Zeitraum kann unter <i>Parameter</i> angepasst werden.
        </small>
    </div>


    <!-- Target limit -->
    <div class="g-brd-around g-brd-gray-light-v4 g-pa-30 g-mb-30">
        @php
            $checked = ($limit->active('target')) ? "checked" : "";
            $value = (string)optional($limit->get('target'))->value;
            $date = optional($limit->get('target'))->date;
        @endphp

        <h4 class="h6 g-font-weight-700 g-mb-20">Ziel Limit</h4>
        @includeWhen(Session::has('limit_target'), 'portfolios.status.limit_'.Session::get('limit_target'))

        <div class="form-group">
            <label class="d-flex align-items-center">
                <div class="u-check">
                    <input type="checkbox" class="g-hidden-xs-up g-pos-abs g-top-0 g-right-0"
                           name="target" value="target" {{ $checked }}>
                    <div class="u-check-icon-radio-v7">
                        <i class="fa" data-check-icon=""></i>
                    </div>
                </div>
                <span class="g-pl-20">aktivieren</span>
            </label>
        </div>

        <!-- Limit amount -->
        <div class="form-group row g-mb-25">
            <div class="col-sm-9 g-mt-10">
                <div class="input-group g-brd-primary--focus">
                    <div class="input-group-addon d-flex align-items-center g-bg-white g-color-gray-light-v1 rounded-0">
                        {{ $portfolio->currency->code }}</div>
                    <input type="text" name="target_value" placeholder="0,00"
                           class="form-control form-control-md rounded-0" value="{{ $value }}">
                </div>
            </div>
        </div>

        <!-- Limit target date -->
        <div class="form-group row g-mb-25">
            <div class="col-sm-9 g-mt-10">
                <div class="input-group g-brd-primary--focus">
                    <input id="datepickerDefault" type="text" name="target_date" value="{{ $date }}"
                           class="form-control form-control-md u-datepicker-v1 g-brd-right-none rounded-0">
                    <div class="input-group-addon d-flex align-items-center g-bg-white g-color-gray-dark-v5 rounded-0">
                        <i class="icon-calendar"></i>
                    </div>
                </div>
            </div>
        </div>

        <small class="form-text text-muted g-font-size-default g-mt-10">
            Der Mindestwert, den das Portfolio am Ende einer festgelegten
            Periode ausweisen soll. Bei dieser Limitart wird davon ausgegangen, dass keine
            Anpassung des Portfolio bis zum Ende der gewählten Period erfolgen soll.
        </small>
    </div>


    <!-- Buttons -->
    <div class="text-sm-right">
        <button type="submit" class="btn u-btn-darkgray rounded-0 g-py-12 g-px-25 g-mr-10">Speichern</button>
    </div>

    {!! Form::close() !!}
</div>


@section('scripts.footer')

@endsection