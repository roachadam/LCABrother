@extends('layouts.main')
<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.1.0/fullcalendar.min.css' />

@section('content')


<div id='calendar'></div>


<div class="card col-md-8 m-t-lg">
    <div class="card-header">Create New Event</div>
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

            <div class="row m-t-md">
                <button type='submit' class="btn btn-primary">Send</button>
            </div>

        </form>

</div>
</div>
@section('js')
    <script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.17.1/moment.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.1.0/fullcalendar.min.js'></script>
    <script>
        $(document).ready(function() {
            // page is now ready, initialize the calendar...
            $('#calendar').fullCalendar({
                // put your options and callbacks here
                events : [
                    @if(isset($calendarItems))
                        @foreach($calendarItems as $calendarItem)
                        {
                            title : '{{ $calendarItem->name }}',
                            start : '{{ $calendarItem->start_date }}',
                            end : '{{ $calendarItem->end_date }}',
                            url : '/calendarItem/'+{{$calendarItem->id}},
                        },
                        @endforeach
                    @endif
                ]
            })
        });
    </script>

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


