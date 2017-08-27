@component('partials.icon-stat')
    @slot('label', 'Barbestand')
    @slot('value', $portfolio->present()->cash())
    @slot('date', $portfolio->present()->updatedToday());
    @slot('icon', 'fa-university');
    @slot('iconColor', 'bg-primary')
@endcomponent