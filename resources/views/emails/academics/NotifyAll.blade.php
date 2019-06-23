@component('mail::message')
# Introduction

{{$academics->name}}
{{$academics->Current_Academic_Standing}}

@component('mail::button', ['url' => ''])
Button Text
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
