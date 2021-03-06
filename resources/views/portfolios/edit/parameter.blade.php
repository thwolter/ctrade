<div class="tab-pane fade in {{ active_tab('parameter') }}" id="parameter">

    <div class="heading-block">
        <h3>
            Parameter
        </h3>
    </div>

    @include('partials.errors')

    <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula
        eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient
        montes.</p>

    <br><br>

    {!! Form::open(['route' => ['portfolios.update', $portfolio->slug], 'method' => 'PUT',
        'class' => 'form form-horizontal']) !!}

    <input type="hidden" name="active_tab" value="parameter">
    <input type="hidden" name="id" value="{{ $portfolio->id }}">


    <!-- Confidence level -->
    <div class="form-group">
        <label class="col-md-3 control-label">Sicherheitsniveau</label>
        <div class="col-md-7">
            @php
                $keys = $portfolio->settings()->keys('confidence');
                $value = $portfolio->settings()->index()->get('confidence');
            @endphp
            {!! Form::select('confidence', $keys, $value, ['class' => 'form-control']) !!}
            <span class="help-block">Das Sicherheitsniveau ...</span>
        </div>
    </div>

    <!-- Horizon -->
    <div class="form-group">
        <label class="col-md-3 control-label">Periode</label>
        <div class="col-md-7">
            @php
                $keys = $portfolio->settings()->keys('period');
                $value = $portfolio->settings()->index()->get('period');
            @endphp
            {!! Form::select('period', $keys, $value, ['class' => 'form-control']) !!}
            <span class="help-block">Der Betrachtungszeitraum ...</span>
        </div>
    </div>

    <!-- History -->
    <div class="form-group">
        <label class="col-md-3 control-label">Historie</label>
        <div class="col-md-7">
            @php
                $keys = $portfolio->settings()->keys('history');
                $value = $portfolio->settings()->index()->get('history');
            @endphp
            {!! Form::select('history', $keys, $value, ['class' => 'form-control']) !!}
            <span class="help-block">Die Historie ...</span>
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