@extends('layouts.main')
@section('title', 'Answer Survey')
@section('content')

<h3>{{$survey->name}}</h3>
<form action="/surveyAnswers/survey/{{$survey->id}}" method="POST">
    @csrf
    {!! $survey->generateForm()  !!}

    <button type="submit" class="btn btn-primary">Submit Survey</button>
</form>
@endsection
