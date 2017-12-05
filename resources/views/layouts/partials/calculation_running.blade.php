@isset($portfolio)
    <status-calculation
            current-route="{{ url()->current() }}"
            :portfolio-id="{{ $portfolio->id }}"
            :status="{{ \App\Jobs\Calculations\CalculationObject::getStatus($portfolio, ['risk', 'value']) }}">
    </status-calculation>
@endisset