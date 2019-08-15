@component('mail::message')
# Hello,

Please complete the '{{$survey->name}}' survey as soon as possible.

@component('mail::button', ['url' => '/survey'])
View Survey
@endcomponent

Thanks,<br>
Adam & Dawson
@endcomponent
