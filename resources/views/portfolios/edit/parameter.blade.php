<h2 class="h4 g-font-weight-300">Parameter</h2>

<p class="g-mb-25">
    Lege die Parameter für die Berechnung der Risiken fest.
</p>


{!! Form::open(['route' => ['portfolios.update', $portfolio->slug], 'method' => 'PUT',
    'class' => 'g-brd-gray-light-v4 g-pa-30 g-mb-30']) !!}

<input type="hidden" name="active_tab" value="parameter">
<input type="hidden" name="id" value="{{ $portfolio->id }}">


<!-- Confidence level -->
<div class="form-group row g-mb-25">
    <label class="col-sm-3 col-form-label g-mb-10">Sicherheitsniveau</label>
    <div class="col-sm-9">
        @php
            $keys = $portfolio->settings()->keys('confidence');
            $value = $portfolio->settings()->index()->get('confidence');
        @endphp
        {!! Form::select('confidence', $keys, $value, [
            'class' => 'js-custom-select u-select-v1 g-brd-gray-light-v2 g-color-gray-dark-v5 w-100 g-pt-11 g-pb-10',
            'data-open-icon' => "fa fa-angle-down",
            'data-close-icon' => "fa fa-angle-up"
            ])
         !!}
        <small class="form-text text-muted g-font-size-default g-mt-10">
            Wie risikofreudig bist du? Je höher das Sicherheitsniviau desto sicherer stellt das Risiko
            den maximal möglichen Verluste deines Portfolios dar.
        </small>
    </div>
</div>

<!-- Horizon -->
<div class="form-group row g-mb-25">
    <label class="col-sm-3 col-form-label g-mb-10">Periode</label>
    <div class="col-sm-9">
        @php
            $keys = $portfolio->settings()->keys('period');
            $value = $portfolio->settings()->index()->get('period');
        @endphp
        {!! Form::select('period', $keys, $value, [
            'class' => 'js-custom-select u-select-v1 g-brd-gray-light-v2 g-color-gray-dark-v5 w-100 g-pt-11 g-pb-10',
            'data-open-icon' => "fa fa-angle-down",
            'data-close-icon' => "fa fa-angle-up"
            ])
        !!}
        <small class="form-text text-muted g-font-size-default g-mt-10">
            Wie oft möchtest du Änderungen an deinem Portfolio vornehmen? Der gewählte Zeitraum sollte mit
            dieser Zeit übereinstimmen.
        </small>
    </div>
</div>

<!-- History -->
<div class="form-group row g-mb-25">
    <label class="col-sm-3 col-form-label g-mb-10">Historie</label>
    <div class="col-sm-9">
        @php
            $keys = $portfolio->settings()->keys('history');
            $value = $portfolio->settings()->index()->get('history');
        @endphp
        {!! Form::select('history', $keys, $value, [
            'class' => 'js-custom-select u-select-v1 g-brd-gray-light-v2 g-color-gray-dark-v5 w-100 g-pt-11 g-pb-10',
            'data-open-icon' => "fa fa-angle-down",
            'data-close-icon' => "fa fa-angle-up"
            ])
        !!}
        <small class="form-text text-muted g-font-size-default g-mt-10">
            Welcher historische Zeitraum ist für dein Portfolio relevant? Je kürzer der Zeitraum
            desto stärker werden kurzfristige Ereignisse berücksichtigt. Länger zurückliegende
            Ereignisse werden nicht berücksichtigt.
        </small>
    </div>
</div>

<hr class="g-brd-gray-light-v4 g-my-25">

<!-- Buttons -->
<div class="text-sm-right">
    <button type="submit" class="btn u-btn-darkgray rounded-0 g-py-12 g-px-25 g-mr-10">Speichern</button>
</div>

{!! Form::close() !!}

