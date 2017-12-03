@isset($portfolio)
    <status-calculation
            current-route="{{ url()->current() }}"
            :user-id="{{ $portfolio->user->id }}"
            :portfolio-id="{{ $portfolio->id }}"
            :status="{{ \App\Jobs\Calculations\CalculationObject::getStatus($portfolio, ['risk', 'value']) }}">
    </status-calculation>
@endisset