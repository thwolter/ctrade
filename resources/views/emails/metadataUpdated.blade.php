@component('mail::message')
# Metadata update

Database {{ $results['provider'] }}/{{ $results['database'] }} was updated with

- {{ $results['created'] }} create items;
- {{ $results['updated'] }} updated items;
- {{ $results['invalidated'] }} invalidated items.

<br>
Best,<br>
{{ config('app.name') }}
@endcomponent
