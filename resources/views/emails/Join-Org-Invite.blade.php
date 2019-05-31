@component('mail::message')
# Hello!

You have been invited to join {{ $org->name }}! Click the link below to sign up or register!

@component('mail::button', ['url' => '/organizations/' . $org->id . '/join'])
Register Now
@endcomponent

Thanks,<br>
Adam & Dawson
@endcomponent
