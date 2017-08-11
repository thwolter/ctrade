@component('mail::message')
# Änderung deiner Email Adresse

## Du hast die Änderung deiner Email Adresse angefordert.

Bitte klicke den folgenden Link, um deine neue Email Adresse zu bestätigen.

{{ route('users.verify', [$user->email_token]) }}


Danke,<br>
{{ config('app.name') }}
@endcomponent
