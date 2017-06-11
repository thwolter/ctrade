<div class="input-form">
    <p class="lead text-center">Portfolio enhält noch keine Positionen.</p>
    <p class="text-center">Füge Positionen hinzu um Auswertungen zu erhalten.</p>
    <!-- Form with method Post -->
    {!! Form::open(['route' => ['positions.create', $portfolio->id], 'method' => 'Get']) !!}
    <div class="text-center buttons-row">
        {!! Form::submit('Neue Position', ['class' => 'btn theme-btn-color']) !!}
    </div>
    {!! Form::close() !!}
</div>
<div class="space-70"></div>