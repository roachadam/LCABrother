@component('mail::message')
# Introduction

{{$user->name}}, you have been removed from {{$org->name}}. Sorry.


Thanks,<br>
{{ config('app.name') }}
@endcomponent
