@extends('layouts.main')
@section('title', 'Survey Responses')
@section('content')

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('survey.index')}}">Surveys</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{$survey->name}}</li>
    </ol>
</nav>

<section class="card">
    <div class="card-block">
        <header class="card-header" style="border-bottom: 0">
            <div class="row">
                <h2 class="card-title">{{$survey->name}}</h2>
            </div>
        </header>
        @include('partials.errors')

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
                @foreach ($survey->surveyAnswers as $surveyAnswer)
                    <tr>
                        <td>{{$surveyAnswer->user->name}}</td>
                        @foreach($surveyAnswer->field_answers as $answer)
                            <td>
                                @if(is_array($answer))
                                    @if(count($answer) === 0)
                                        {{$answer[0]}}
                                    @else
                                        @foreach ($answer as $key=>$subAnswer)
                                            {{$subAnswer}}{{($key === (count($answer)-1) ? '' : ',')}}
                                        @endforeach
                                    @endif
                                @else
                                    {{$answer}}
                                @endif
                            </td>
                        @endforeach
                        <td>{{$surveyAnswer->created_at}}</td>
                        <td><button type="button" class="btn btn-inline btn-danger-outline" data-toggle="modal" data-target="#{{$surveyAnswer->id}}">Delete</button></td>
                    </tr>

                    <!--.modal for confirming deletion-->
                    <div class="modal fade" id="{{$surveyAnswer->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="modal-close" data-dismiss="modal" aria-label="Close">
                                        <i class="font-icon-close-2"></i>
                                    </button>
                                    <h4 class="modal-title" id="myModalLabel">Delete Entry</h4>
                                </div>
                                <form action={{route('surveyAnswers.destroy', $surveyAnswer)}} method="POST" class="box" >
                                    <div class="modal-body">
                                        @csrf
                                        @method('DELETE')
                                        <div class="col-md-12">
                                            <p>Are you sure you want to delete {{$surveyAnswer->user->name}}'s entry?</p>
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

@section('js')
    <script type="text/javascript" src="{{ asset('js/lib/datatables-net/datatables.min.js') }}"></script>
    <script>
        $(function() {
            $('#table').DataTable({
                responsive: true
            });
        });
    </script>
@endsection
