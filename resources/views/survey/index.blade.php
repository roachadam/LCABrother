@extends('layouts.main')
@section('title', 'Surveys')

@section('content')
<section class="card">
    <div class="card-block">
        <header class="card-header" style="border-bottom: 0">
            <div class="row">
                <h2 class="card-title">Surveys</h2>
            </div>
        </header>
        <table id="table" class="display table table-bordered" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>Survey Name</th>
                    <th>Description</th>
                    <th>Date Posted</th>
                    <th>Answer</th>
                    @if ($user->canManageSurveys())
                        <th>View Responses</th>
                        <th>Notify Members Who Havent Answered</th>
                        <th>Manage</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach ($surveys as $survey)
                    <tr>
                        <td>{{$survey->name}}</td>
                        <td>{{$survey->desc}}</td>
                        <td>{{$survey->created_at}}</td>

                        {{-- Uncomment this to have the fillout form not be a modal and it just goes to a seperate page --}}
                        {{-- <td><a href={{route('survey.show', $survey)}} class="btn btn-inline {{$user->hasResponded($survey) ? 'disabled' : ''}}" >Submit Response</a></td> --}}
                        <td><button type="button" class="btn btn-inline btn-primary" data-toggle="modal" data-target="#submit{{$survey->id}}" {{!$user->hasResponded($survey) ? '' : 'disabled'}}>Submit Response</button></td>

                        @if(!$user->hasResponded($survey))
                            <!--.modal for filling out survey-->
                            <div class="modal fade" id="submit{{$survey->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="modal-close" data-dismiss="modal" aria-label="Close">
                                                <i class="font-icon-close-2"></i>
                                            </button>
                                            <h4 class="modal-title" id="myModalLabel">{{$survey->name}}</h4>
                                        </div>
                                        <form action={{route('survey.submit', $survey)}} method="post" class="box" >
                                            <div class="modal-body">
                                                @csrf
                                                <div class="col-md-12">
                                                    {!! $survey->generateForm()  !!}
                                                </div>
                                            </div>

                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-inline btn-default" data-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-inline btn-primary">Submit</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div><!--.modal-->
                        @endif

                        @if ($user->canManageSurveys())
                            <td><a href={{route('survey.responses', $survey)}} class="btn btn-inline btn-primary">View Responses</a></td>
                            <td><button type="button" class="btn btn-inline btn-primary" data-toggle="modal" data-target="#notify{{$survey->id}}">Notify</button></td>
                            <td><button type="button" class="btn btn-inline btn-danger-outline" data-toggle="modal" data-target="#delete{{$survey->id}}">Delete</button></td>


                            <!--.modal for notifying members who have not completed a survey-->
                            <div class="modal fade" id="notify{{$survey->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="modal-close" data-dismiss="modal" aria-label="Close">
                                                <i class="font-icon-close-2"></i>
                                            </button>
                                            <h4 class="modal-title" id="myModalLabel">Notify Memebers</h4>
                                        </div>
                                        <form action={{route('survey.notify', $survey)}} method="post" class="box" >
                                            <div class="modal-body">
                                                @csrf
                                                <div class="col-md-12">
                                                    <p>This will send an email to every member in the organization that that has not submitted a response to this survey</p>
                                                </div>
                                            </div>

                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-inline btn-default" data-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-inline btn-primary">Notify</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div><!--.modal-->

                            <!--.modal for confirming deletion-->
                            <div class="modal fade" id="delete{{$survey->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="modal-close" data-dismiss="modal" aria-label="Close">
                                                <i class="font-icon-close-2"></i>
                                            </button>
                                            <h4 class="modal-title" id="myModalLabel">Delete Survey</h4>
                                        </div>
                                        <form action={{route('survey.destroy', $survey)}} method="POST" class="box" >
                                            <div class="modal-body">
                                                @csrf
                                                @method('DELETE')
                                                <div class="col-md-12">
                                                    <p>Are you sure you want to delete this survey?</p>
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
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</section>
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
@endsection
