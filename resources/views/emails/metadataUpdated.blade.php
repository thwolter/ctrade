@component('mail::message')
# Metadata successfully updated

Database {{ $results['provider'] }}/{{ $results['database'] }} was updated with

- {{ $results['created'] }} create items;
- {{ $results['updated'] }} updated items;
- {{ $results['validated'] }} validated items;
- {{ $results['invalidated'] }} invalidated items.

{{ $results['provider'] }}/{{ $results['database'] }} has

- {{ $results['total'] }} total items; 
- with {{ $results['valid'] }} valid.

<br>
Best,<br>
{{ config('app.name') }}
@endcomponent
