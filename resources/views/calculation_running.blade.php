@isset($portfolio)
    <status-calculation
            :user-id="{{ $portfolio->user->id }}"
            :portfolio-id="{{ $portfolio->id }}"
            :status="{{ \App\Jobs\Calculations\CalculationObject::getStatus($portfolio, ['risk', 'value']) }}">
    </status-calculation>
@endisset