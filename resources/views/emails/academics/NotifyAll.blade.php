@component('mail::message')
# Introduction

{{$academics->name}}
{{$academics->Current_Academic_Standing}}

@component('mail::button', ['url' => ''])
Button Text
@endcomponent

Thanks,<br>
Your Academics Chair

@endcomponent
