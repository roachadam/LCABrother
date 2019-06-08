@extends('layouts.main')


@section('content')

<header class="section-header">
        <div class="tbl">
            <div class="tbl-row">
                <div class="tbl-cell">
                    <h2>{{$survey->name}}</h2>
                    {{-- <div class="subtitle">Welcome to Ultimate Dashboard</div> --}}
                </div>
            </div>
        </div>
    </header>
    <section class="card">
    <div class="card-block">
        <table id="table" class="display table table-bordered" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>Member Name</th>
                    @foreach($survey->field_names as $fieldName)
                        <th>{{$fieldName}}</th>
                    @endforeach
                    <th>Date Submitted</th>
                    <th>Manage</th>
                </tr>
            </thead>
            <tbody>
                    @foreach ($survey->surveyAnswers as $surveyAnswers)
                        <tr>
                            <td>{{$surveyAnswers->user->name}}</td>
                            @foreach($surveyAnswers->field_answers as $answer)
                                <th>{{$answer}}</th>
                            @endforeach
                            <td>{{$surveyAnswers->created_at}}</td>

                            <form action="/surveyAnswers/{{$surveyAnswers->id}}" method="POST">
                                @csrf
                                @method('DELETE')
                                <td>
                                    <button type="submit" class="btn btn-warning disabled">Delete</button>
                                </td>
                            </form>
                        </tr>
                    @endforeach

            </tbody>
        </table>
    </div>
</section>

@endsection
