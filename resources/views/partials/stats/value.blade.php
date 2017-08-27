@component('partials.icon-stat')
    @slot('label', 'Portfoliowert')
    @slot('value', $portfolio->present()->total())
    @slot('date', $portfolio->present()->updatedValue());
    @slot('icon', 'fa-pie-chart');
    @slot('iconColor', 'bg-primary')
@endcomponent