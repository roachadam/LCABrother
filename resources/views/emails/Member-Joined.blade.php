@component('mail::message')
# Introduction

A user named '{{ $user->id}}' has requested to join your organization '{{ $org->name }}'.

@component('mail::button', ['url' => '/orgpending/' . $user->id ])
View Member
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
