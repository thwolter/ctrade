<h2 class="h4 g-font-weight-300">Dashboard</h2>

    @include('partials.errors')

    <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula
        eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient
        montes.</p>


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
        </div>
    </div>

    {!! Form::close() !!}

