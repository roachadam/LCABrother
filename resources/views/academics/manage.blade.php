@extends('layouts.main')

@section('content')

<div class="card-columns d-flex justify-content-center">
    <div class="card">
        <div class="card-header">Add More Grades</div>

        <div class="row card-body justify-content-center">
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

    <div class="card">
        <div class="card-header">Format Rules</div>

        <div class="row card-body justify-content-left">
            <p class="offset-1">
                All files <b><u>must</u></b> have at least the listed headings and<br/> Student names must use the same convention.<br/>
                <small class="offset-4"><a href="">Example file</a></small><br/>
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

<div class="card">
    <div class="card-header">Email those on bad standing</div>
        <div class="card-body">
            <form action="/academics/notify" method="post">
                @csrf

                <div class="row m-t-md">
                    <label for="subject">Subject</label>
                    <input type="text" class="offset-1 form-control" id="subject" name="subject">
                </div>

                <div class="row m-t-md">
                    <label for="body">Body</label>
                    <textarea class="offset-1 form-control" name="body" id="body" cols="30" rows="10"></textarea>
                </div>

                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
</div>
@endsection
