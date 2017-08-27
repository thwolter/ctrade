<div class="tab-pane fade in {{ active_tab('dashboard') }}" id="dashboard">

    <div class="heading-block">
        <h3>
            Dashboard
        </h3>
    </div>

    @include('partials.errors')

    <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula
        eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient
        montes.</p>

    <br><br>

    {!! Form::open(['route' => ['portfolios.update', $portfolio->slug], 'method' => 'PUT',
        'class' => 'form form-horizontal']) !!}

    <input type="hidden" name="active_tab" value="dashboard">
    <input type="hidden" name="id" value="{{ $portfolio->id }}">


    <!-- Confidence level -->
    <div class="form-group">
        <label class="col-md-3 control-label">Return</label>
        <div class="col-md-7">
            @php
                $keys = $portfolio->settings()->keys('returnPeriod');
                $value = $portfolio->settings()->index()->get('returnPeriod');
            @endphp
            {!! Form::select('returnPeriod', $keys, $value, ['class' => 'form-control']) !!}
            <span class="help-block">Return ...</span>
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