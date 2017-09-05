@component('partials.icon-stat')
    @slot('label', 'Entwicklung ('.$portfolio->settings()->human()->get('returnPeriod').')')
    @slot('value', $portfolio->present()->profit())
    @slot('date', $portfolio->present()->updatedValue());
    @slot('icon', 'fa-line-chart');
    @slot('iconColor', 'bg-primary')
@endcomponent