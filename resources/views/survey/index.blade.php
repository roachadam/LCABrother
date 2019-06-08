@extends('layouts.main')


@section('content')

    @forelse ($surveys as $survey)
    <a href="/survey/{{$survey->id}}">{{$survey->name}}</a> <a href="/survey/{{$survey->id}}/responses" class="btn btn-inline">View Responses</a>

    @empty
        <p>there are no surveys</p>
    @endforelse

@endsection
