@component('mail::message')
# Hello

You are below the points threshhold for the {{$goalName }}.<br>
You need <b>{{$target}}</b> but only have <b>{{$actual}}</b>.

@component('mail::button', ['url' => '/dash'])
Log Points
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
