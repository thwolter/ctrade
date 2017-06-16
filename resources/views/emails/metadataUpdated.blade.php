@component('mail::message')
# Metadata successfully update

Database {{ $results['provider'] }}/{{ $results['database'] }} was updated with

- {{ $results['created'] }} create items;
- {{ $results['updated'] }} updated items;
- {{ $results['invalidated'] }} invalidated items.

{{ $results['provider'] }}/{{ $results['database'] }} has

- {{ $results['total'] }} total items; 
- with {{ $results['valid'] }} valid.

<br>
Best,<br>
{{ config('app.name') }}
@endcomponent
