@component('mail::message')
# Bug Report
You have a new bug report! Have fun.
<p>
    <h5>Action Attempted</h5>
    {{$action}}
</p>
<p>
    <h5>Description of Bug</h5>
    {{$description}}
</p>
<p>
    <h5>URL Of Bug</h5>
    {{$url}}
</p>

Thanks,<br>
{{ config('app.name') }}
@endcomponent
