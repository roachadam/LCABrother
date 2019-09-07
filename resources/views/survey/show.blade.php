@extends('layouts.main')
@section('title', 'Answer Survey')
@section('content')


<div class="card col-md-10">
        <div class="card-header"><h3>{{$survey->name}}</h3>
            {{$survey->desc}}
        </div>

        <form action="/surveyAnswers/survey/{{$survey->id}}" method="POST">
            @csrf
            <div class="card-block">
                <div class="col-md-8">
                    {!! $survey->generateForm()  !!}
                </div>
            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Submit Survey</button>
            </div>

        </form>
    </div>
</div>

@endsection
