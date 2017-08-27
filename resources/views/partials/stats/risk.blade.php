@component('partials.icon-stat')
    @slot('label', 'Risiko ('.$portfolio->settings()->human()->get('period').')')
    @slot('value', $portfolio->present()->risk())
    @slot('date', $portfolio->present()->updatedRisk());
    @slot('icon', 'fa-tachometer');
    @slot('iconColor', 'bg-primary')
@endcomponent