<!-- select to deduct from available cash -->
<div class="form-group row">
    {!! Form::label('deduct', 'Verrechnen', ['class' => 'col-md-2 offset-md-1 col-form-label']) !!}
    <div class="col-md-8">
        <div class="checkbox">
            {!! Form::checkbox('deduct', 'yes', true) !!}
            <span style="padding-left: 7px">Mit Cashbestand verrechnen</span>
        </div>
        <div class="space-10"></div>
        <p class="help-block">
            Anklicken, wenn die neue Position den Cashbestand des Portfolios reduzieren
            soll. Oder freilassen, wenn die Position den Portfoliowert erhöhen soll.
        </p>
    </div>
</div>
