@component('mail::message')
#Dear {{ $user->name }} ,
Unfortunately you have been declined access into '{{ $user->organization->name}}' :( .' Follow the link below to try again!

@component('mail::button', ['url' => '/organization'])
Visit Dash
@endcomponent

Thanks,<br>
Adam & Dawson
@endcomponent
