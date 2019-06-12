@extends('layouts.main')

@section('content')


    <div class="card">
        <div class="card-header"><h3>New Calendar Event</h3></div>
        <div class="card-body">
            <form method='POST' action="/calendarItem" role="presentation" class="form">
                @csrf
                @include('partials.errors')
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
                    <div class="checkbox-toggle form-group">
                        <input type="checkbox" id=guestList name=guestList>
                        <label for=guestList>Generate GuestList</label>
                    </div>
                </div>
                <div class="row m-t-md">
                    <div class="checkbox-toggle form-group">
                        <input type="checkbox" id="attendance" name="attendance" onclick="showInvolvement()">
                        <label for="attendance">Allow Attendance</label>
                    </div>
                </div>
                <div class="row m-t-md">
                    <div class="checkbox-toggle form-group" id="inv" style="display: none">
                        <label for="involvement">Add involvement points to users who attend (optional)</label>
                        <select name="involvement" id="involvement" class="form-control">
                            <option value="0">Choose Involvement Item</option>
                            @foreach (auth()->user()->organization->involvement as $involvement)
                                <option value="{{$involvement->id}}">{{$involvement->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row">
                    <button type='submit' class="btn btn-primary">Send</button>
                </div>

            </form>
        </div>
    </div>

@section('js')
<script>
    function showInvolvement(){
        if(document.getElementById('attendance').checked){
            var div = document.getElementById('inv');
            inv.style.display = "block";
        }
        else{
            var div = document.getElementById('inv');
            inv.style.display = "none";
        }
    }
</script>
@endsection
@endsection


