@component('mail::message')
#Dear {{ $user->name }} , 
Congrats you have been accepted into '{{ $user->organization->name}}'!! Follow the link below to visit your dashboard!

@component('mail::button', ['url' => '/dash'])
Visit Dash
@endcomponent

Thanks,<br>
Adam & Dawson
@endcomponent
