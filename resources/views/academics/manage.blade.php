@extends('layouts.main')
@section('title', 'Manage Academics')
@section('css')
<style>
    /* Float four columns side by side */
    .column {
        float: left;
        width: 50%;
        padding: 0 10px;
    }

    /* Remove extra left and right margins, due to padding in columns */
    .row {margin: 0 -5px;}

    /* Clear floats after the columns */
    .row:after {
        content: "";
        display: table;
        clear: both;
    }

    /* Style the counter cards */
    .card {
        padding: 16px;
    }

    /* Responsive columns - one column layout (vertical) on small screens */
    @media screen and (max-width: 700px) {
        .column {
            width: 100%;
            display: block;
            margin-bottom: 20px;
        }
    }
</style>
@endsection

@section('content')

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/academics">Academics</a></li>
        <li class="breadcrumb-item active" aria-current="page">Academics Manage</li>
    </ol>
</nav>
    <div class="row">
        <section class="card column m-t-md">
            <div class="card-header">Add More Grades</div>
            @include('partials.errors')

            <div class="card-body justify-content-center m-t-md">
                <form action="/academics" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        {{-- <div class="file-upload-wrapper">
                            <input type="file" id="grades" class="file-upload" name="grades" />
                        </div> --}}
                        {{-- <input type="file" class="offset-1 form-control-file" name="grades" id="gradeFile" aria-describedby="fileHelp"> --}}

                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="customFile" name="grades" aria-describedby="fileHelp">
                            <label class="custom-file-label" for="customFile">Choose file</label>
                        </div>
                        <small id="fileHelp" class="offset-1 form-text text-muted">**Please be sure to check the Format Rules**</small>
                    </div>

                    <div >
                        <button type="submit" class="offset-1 btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </section>

        <section class="card column m-t-md">
            <div class="card-header">Format Rules</div>

            <div class="card-body justify-content-left m-t-md">
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
        </section>
    </div>

    @if (collect($newAcademicStandings)->isNotEmpty())
        <section class="card m-t-md">
            <div class="card-header">Notify Members of Academic Standing</div>
                <div class="card-body">
                    <div class="btn-toolbar">
                        <button type="button" class="btn btn-inline btn-primary" data-toggle="modal" data-target="#notifyAll">Notify All</button>
                        <button type="button" class="btn btn-inline btn-primary" data-toggle="modal" data-target="#notifySelectMembers">Notify Select Members</button>
                        <button type="button" class="btn btn-inline btn-primary" data-toggle="modal" data-target="#notifySpecificStanding">Notify Specific Standing</button>
                    </div>
                </div>
            </div>
        </section>

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
                                        @if($user->academics->isNotEmpty())
                                            <div class="checkbox-toggle form-group">
                                                <input type="checkbox" value="{{$user->id}}" name="users[]" id="{{$user->id}}">
                                                <label for="{{$user->id}}">{{$user->name}}</label>
                                            </div>
                                        @endif
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
@endsection
@section('js')
<script>
    // $( document ).ready(function() {
    //     // $('.file-upload').file_upload();
    // });

    $(".custom-file-input").on("change", function() {
        var fileName = $(this).val().split("\\").pop();
        $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
    });
</script>
@endsection
