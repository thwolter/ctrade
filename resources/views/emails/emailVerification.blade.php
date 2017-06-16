@component('mail::message')
# Emailbestätigung

## Click the Link To Verify Your Email
Click the following link to verify your email 

{{url(‘/verifyemail/’.$email_token)}}

@component('mail::button', ['url' => ''])
Button Text
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
