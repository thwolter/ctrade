@component('mail::message')
# Metadata successfully updated

Database *{{ $results['provider'] }}/{{ $results['database'] }}* was updated.

Summary
- {{ $results['total'] }} total items;
- {{ $results['valid'] }} valid items;

<br>
Best,<br>
{{ config('app.name') }}
@endcomponent
