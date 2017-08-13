@component('mail::message')
# Deine Registierung

## Vielen Dank, dass du dich auf unserer Seite registiert hast.

Bitte klicke den folgenden Link, um deine Email Adresse zu bestätigen.

{{ route('subscribe.verify', [$user->email_token]) }}


Danke,<br>
{{ config('app.name') }}
@endcomponent
