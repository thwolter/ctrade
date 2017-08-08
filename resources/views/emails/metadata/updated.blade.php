@component('mail::message')
# Metadata successfully updated

Database {{ $results['provider'] }}/{{ $results['database'] }} was updated.

- {{ $results['total'] }} total items;
- {{ $results['valid'] }} valid items;
- {{ $results['updated'] }} updated items;
- start: {{ $results['started'] }};


<br>
Best,<br>
{{ config('app.name') }}
@endcomponent
