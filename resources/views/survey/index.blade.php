@extends('layouts.main')


@section('content')
<header class="section-header">
        <div class="tbl">
            <div class="tbl-row">
                <div class="tbl-cell">
                    <h2>Surveys</h2>
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
                    <th>Survey Name</th>
                    <th>Description</th>
                    <th>Date Posted</th>
                    <th>Answer</th>
                    @if (auth()->user()->canManageSurveys())
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
                        <td><a href="/survey/{{$survey->id}}" class="btn btn-inline {{auth()->user()->hasResponded($survey) ? 'disabled' : ''}}" >Submit Response</a></td>
                        @if (auth()->user()->canManageSurveys())
                            <td><a href="/survey/{{$survey->id}}/responses" class="btn btn-inline">View Responses</a></td>

                            <form action="/survey/{{$survey->id}}/notify" method="POST">
                                @csrf
                               <td><button type="submit" class="btn btn-primary">Notify</button></td>
                            </form>
                            <td><button type="button" class="btn btn-inline btn-danger-outline" data-toggle="modal" data-target="#{{$survey->id}}">Delete</button></td>

                            <!--.modal for confirming deletion-->
                            <div class="modal fade" id="{{$survey->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="modal-close" data-dismiss="modal" aria-label="Close">
                                                <i class="font-icon-close-2"></i>
                                            </button>
                                            <h4 class="modal-title" id="myModalLabel">Delete Survey</h4>
                                        </div>
                                        <form action="/survey/{{$survey->id}}" method="POST" class="box" >
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
