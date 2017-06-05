<div class="form-group row">
    {!! Form::label('current', 'Bestand', ['class' => 'col-md-2 offset-md-1 col-form-label']) !!}
    <div class="col-md-2">
        @php($amount = (isset($position) ? $position->amount : 0))
        <div class="form-control-static">{{ $amount }}</div>

    </div>
</div>

@include('partials.errors')

<!-- text field for number of shares -->
<div class="form-group row">
    {!! Form::label('amount', 'Stückzahl', ['class' => 'col-md-2 offset-md-1 col-form-label']) !!}
    <div class="col-md-2">
        {!! Form::number('amount', 0, ['class' => 'form-control input-md']) !!}
    </div>
</div>
