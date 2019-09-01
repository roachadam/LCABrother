@component('mail::message')

A user named '{{ $user->name}}' has requested to join your organization : {{ $org->name }}. Click the button below to pass judgement upon thy peer.

@component('mail::button', ['url' => 'dash.lcabrother.org/orgpending/' . $user->id ])
View Member
@endcomponent

Thanks,<br>
Adam & Dawson
@endcomponent
