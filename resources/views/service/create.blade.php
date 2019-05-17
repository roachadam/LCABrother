@extends('main.dash')

@section('content')
<h1>Service Events</h1>
@if ($serviceEvents->count())
    @foreach ($serviceEvents as $serviceEvent)
        <p>{{ $serviceEvent->name }}</p>
    @endforeach
@endif





@endsection
