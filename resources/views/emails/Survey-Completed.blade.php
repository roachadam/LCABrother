@component('mail::message')
# Survey Completed

Your survey: {{$survey->name}} has been filled out by every member!

@component('mail::button', ['url' => 'dash.lcabrother.org/survey/'.$survey->id.'/responses'])
View Responses
@endcomponent

Thanks,<br>
Adam & Dawson
@endcomponent
