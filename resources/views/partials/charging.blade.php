<!-- select to deduct from available cash -->
<div class="form-group row">
    {!! Form::label('deduct', 'Hinzufügen', ['class' => 'col-md-3 offset-md-1 col-form-label']) !!}
    <div class="col-md-8">
        <div class="checkbox">
            {!! Form::radio('deduct', 'yes', true) !!}
            <span style="padding-left: 7px">Vom cash abziehen</span>
        </div>
        <div class="checkbox">
            {!! Form::radio('deduct', 'no') !!}
            <span style="padding-left: 7px">Portfolio hinzufügen</span>
        </div>
        <span class="help-block">help</span>
    </div>
</div>
