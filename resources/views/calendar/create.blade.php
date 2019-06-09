@extends('layouts.main')

@section('content')
    <form method='POST' action="/calendar" role="presentation" class="form">
        @csrf

        <div class="row m-t-md">
            <label>Event Name</label>
            <input class="offset-1 form-control" type="text" name="name" id='name' placeholder="Chapter Meeting">
        </div>

        <div class="row m-t-md">
            <label>Description</label>
            <input class="offset-1 form-control" type="text" name="description" id='description' placeholder="Weekly meeting at the Union">
        </div>

        <div class="row m-t-md">
            <label for='start_date'>Start Date</label>
            <input class="offset-1 form-control" type="date" name="start_date" id="start_date">
        </div>

        <div class="row m-t-md">
            <label for='end_date'>End Date</label>
            <input class="offset-1 form-control" type="date" name="end_date" id="end_date" >
        </div>

        <div class="row m-t-md">
            <button type='submit' class="btn btn-primary">Send</button>
        </div>

    </form>
@endsection


