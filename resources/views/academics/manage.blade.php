@extends('layouts.main')

@section('content')
    <div class="card-columns d-flex justify-content-center">
        <div class="card m-t-md">
            <div class="card-header">Add More Grades</div>

            <div class="row card-body justify-content-center m-t-md">
                <form action="/academics/store" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">

                        @if ($errors->any())
                        <div class="offset-1 alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                        <input type="file" class="offset-1 form-control-file" name="grades" id="gradeFile" aria-describedby="fileHelp">

                        <small id="fileHelp" class="offset-1 form-text text-muted">**Please be sure to check the Format Rules**</small>

                    </div>

                    <div >
                        <button type="submit" class="offset-1 btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="card m-t-md">
            <div class="card-header">Format Rules</div>

            <div class="row card-body justify-content-left m-t-md">
                <p class="offset-1">
                    All files <b><u>must</u></b> have at least the listed headings (can have others) and<br/> Student names must use the same convention.<br/>
                    <small class="offset-4"><a href="/academics/downloadExampleFile" download="Example File.xlsx">Example file</a></small><br/>
                </p>

                <ul class="offset-1" style="list-style-type:disc;">
                    <li class="heading" style="list-style-type:none;"><h5><u>Headings</u></h5></li>
                    <li>Student Name</li>
                    <li>Cumulative Gpa</li>
                    <li>Term Gpa</li>
                </ul>
            </div>
        </div>
    </div>

    @if (count($newAcademicStandings) > 0)
        <div class="card">
            <div class="card-header">Notify Members of Academic Standing</div>
                <div class="card-body">
                    <div class="btn-toolbar">
                        <button type="button" class="btn btn-inline btn-primary" data-toggle="modal" data-target="#notifyAll">Notify All</button>
                        <button type="button" class="btn btn-inline btn-primary" data-toggle="modal" data-target="#notifySelectMembers">Notify Select Members</button>
                        <button type="button" class="btn btn-inline btn-primary" data-toggle="modal" data-target="#notifySpecificStanding">Notify Specific Standing</button>
                    </div>
                </div>
            </div>
        </div>

        <!--.modal for notifying all memebrs-->
        <div class="modal fade" id="notifyAll" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="modal-close" data-dismiss="modal" aria-label="Close">
                            <i class="font-icon-close-2"></i>
                        </button>
                        <h4 class="modal-title" id="myModalLabel">Notify All</h4>
                    </div>
                    <form action="/academics/notifyAll" method="post" class="box" >
                        <div class="modal-body">
                            @csrf
                            <div class="col-md-12">
                                <p>This will send an email to every member in the organization that will notify them of their current and previous academic standing</p>
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

        <!--.modal for notifying selected memebrs-->
        <div class="modal fade" id="notifySelectMembers" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="modal-close" data-dismiss="modal" aria-label="Close">
                            <i class="font-icon-close-2"></i>
                        </button>
                        <h4 class="modal-title" id="myModalLabel">Notify Select Members</h4>
                    </div>
                    <form method="POST" action="/academics/notify/selected" class="box" >
                        <div class="modal-body">
                            @csrf
                            <div class="col-md-12">
                                <label class="form-label semibold" for="exampleInput">Choose Specific Members to Notify</label>
                                <fieldset>
                                    {{-- edit member details --}}
                                    @foreach (auth()->user()->organization->users as $user)
                                    <div class="checkbox-toggle form-group">
                                            <input type="checkbox" value="{{$user->id}}" name="users[]" id="subscribers{{$user->id}}">
                                            <label for="subscribers{{$user->id}}">
                                                {{$user->name}}
                                            </label>
                                        </div>
                                    @endforeach

                                </fieldset>
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

        <!--.modal for notifying selected standings-->
        <div class="modal fade" id="notifySpecificStanding" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="modal-close" data-dismiss="modal" aria-label="Close">
                            <i class="font-icon-close-2"></i>
                        </button>
                        <h4 class="modal-title" id="myModalLabel">Notify Specific Standing</h4>
                    </div>
                    <form method="POST" action="/academics/notify/specificStanding" class="box" >
                        <div class="modal-body">
                            @csrf
                            <div class="col-md-12">
                                <label class="form-label semibold" for="academicStanding">Choose a Specific Standing to Notify</label>
                                <fieldset>
                                    <select name="academicStanding" id="academicStanding" class="col-md-4 form-control">
                                        @foreach ($newAcademicStandings as $academicStanding)
                                            <option value="{{$academicStanding}}">{{$academicStanding}}</option>
                                        @endforeach
                                    </select>
                                </fieldset>

                                <div class="modal-header">
                                    <h4 class="modal-title" id="myModalLabel">Send a Custom Message</h4>
                                </div>

                                <div class="row m-t-md">
                                    <label class="form-label semibold" for="subject">Subject</label>
                                    <input type="text" class="form-control" id="subject" name="subject">
                                </div>

                                <div class="row m-t-md">
                                    <label class="form-label semibold" for="body">Body</label>
                                    <textarea class="form-control" name="body" id="body" cols="30" rows="10"></textarea>
                                </div>
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
    @endif
    <a href="/academicStandings" class="btn btn-primary align-right">Override Academic Rules</a>
    <a href="/academics" class="btn btn btn-secondary">Back</a>
@endsection
