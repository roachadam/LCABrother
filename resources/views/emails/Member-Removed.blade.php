@component('mail::message')
# Introduction

{{$user->name}}, you have been removed from {{$org->name}}. Sorry.

@component('mail::button', ['url' => ''])
Button Text
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
