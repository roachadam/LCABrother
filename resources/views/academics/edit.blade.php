@extends('layouts.main')

@section('content')

<div class="card">
    <div class="row justify-content-center ">
        <form action="/academics" method="post" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <h3>Add More Grades</h3>
                <input type="file" class="form-control-file" name="grades" id="gradeFile" aria-describedby="fileHelp">
                <small id="fileHelp" class="form-text text-muted">Please upload a valid image file. Size of image should not be more than 2MB.</small>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</div>

@endsection
