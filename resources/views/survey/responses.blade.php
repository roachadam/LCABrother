@extends('layouts.main')

@section('title', 'Survey Responses')
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
                        <td><button type="button" class="btn btn-inline btn-danger-outline" data-toggle="modal" data-target="#{{$surveyAnswers->id}}">Delete</button></td>
                    </tr>


                    <!--.modal for confirming deletion-->
                    <div class="modal fade" id="{{$surveyAnswers->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="modal-close" data-dismiss="modal" aria-label="Close">
                                        <i class="font-icon-close-2"></i>
                                    </button>
                                    <h4 class="modal-title" id="myModalLabel">Delete Entry</h4>
                                </div>
                                <form action="/surveyAnswers/{{$surveyAnswers->id}}" method="POST" class="box" >
                                    <div class="modal-body">
                                        @csrf
                                        @method('DELETE')
                                        <div class="col-md-12">
                                        <p>Are you sure you want to delete {{$surveyAnswers->user->name}}'s entry?</p>
                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-inline btn-default" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-inline btn-danger">Delete</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div><!--.modal-->
                @endforeach
            </tbody>
        </table>
    </div>
</section>

@endsection
