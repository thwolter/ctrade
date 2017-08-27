@component('partials.icon-stat')
    @slot('label', 'Rendite ('.$portfolio->settings()->human()->get('returnPeriod').')')
    @slot('value', $portfolio->present()->return())
    @slot('date', $portfolio->present()->updatedReturn());
    @slot('icon', 'fa-line-chart');
    @slot('iconColor', 'bg-primary')
@endcomponent