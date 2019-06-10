@extends('layouts.main')

@section('content')

<div class="card">
    <div class="card-header">Add More Grades</div>
    <div class="row justify-content-center card-body">
        <form action="/academics" method="post" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <input type="file" class="form-control-file" name="grades" id="gradeFile" aria-describedby="fileHelp">
                <small id="fileHelp" class="form-text text-muted">Please upload a valid image file. Size of image should not be more than 2MB.</small>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
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
