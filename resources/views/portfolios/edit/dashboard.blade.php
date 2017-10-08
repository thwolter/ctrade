<h2 class="h4 g-font-weight-300">Dashboard</h2>

@include('partials.errors')

<p>Hier stellst du die Parameter für das Dashboards deines Portfolios ein.</p>


{!! Form::open(['route' => ['portfolios.update', $portfolio->slug], 'method' => 'PUT',
    'class' => 'g-brd-gray-light-v4 g-pa-30 g-mb-30']) !!}

<input type="hidden" name="active_tab" value="dashboard">
<input type="hidden" name="id" value="{{ $portfolio->id }}">


<!-- Confidence level -->
<div class="form-group row g-mb-25">
    <label class="col-sm-3 col-form-label g-mb-10">Gewinn/Verlust</label>
    <div class="col-sm-9">
        @php
            $keys = $portfolio->settings()->keys('returnPeriod');
            $value = $portfolio->settings()->index()->get('returnPeriod');
        @endphp
        {!! Form::select('returnPeriod', $keys, $value, [
             'class' => 'js-custom-select u-select-v1 g-brd-gray-light-v2 g-color-gray-dark-v5 w-100 g-pt-11 g-pb-10',
            'data-open-icon' => "fa fa-angle-down",
            'data-close-icon' => "fa fa-angle-up"
            ])
        !!}
        <small class="form-text text-muted g-font-size-default g-mt-10">
            Für welchen vergangenen Zeitraum soll der Gewinn/Verlust deines Portfolios angezeigt werden?
        </small>
    </div>
</div>


<!-- Buttons -->
<div class="text-sm-right">
    <button type="submit" class="btn u-btn-darkgray rounded-0 g-py-12 g-px-25 g-mr-10">Speichern</button>
</div>

{!! Form::close() !!}

