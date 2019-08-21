@extends('layouts.main')
<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.1.0/fullcalendar.min.css' />
<link rel="stylesheet" href="css/lib/flatpickr/flatpickr.min.css">
<link rel="stylesheet" href="css/lib/flatpickr/flatpickr.min.css">

@section('title', 'Calendar')

@section('content')


<div id="calendar" class="fc fc-unthemed fc-ltr"></div>

<div class="modal" tabindex="-1" role="dialog" id="myModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Create Event</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
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
                        <input class=" offset-1 form-control flatpickr flatpickr-input active" data-enable-time="true" name="start_datetime" id="start_datetime">
                    </div>

                    <div class="row m-t-md">
                        <label for='end_date'>End Date</label>
                        {{-- <input class="offset-1 form-control" type="date" name="end_date" id="end_date"> --}}
                        <input class=" offset-1 form-control flatpickr flatpickr-input active" data-enable-time="true" name="end_datetime" id="end_datetime">

                    </div>

                    <div class="row m-t-md">
                        <div class="checkbox-toggle form-group">
                            <input type="checkbox" id=guestList name=guestList>
                            <label for=guestList>Generate GuestList</label>
                        </div>
                    </div>
                    <div class="row m-t-md">
                        <div class="checkbox-toggle form-group">
                            <input type="checkbox" id="attendance" name="attendance" onclick="showInvolvement()" >
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
                        <button type='submit' class="btn btn-primary">Create</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>





@section('js')
    <script src='https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.17.1/moment.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.1.0/fullcalendar.min.js'></script>
    <script src="js/lib/flatpickr/flatpickr.min.js"></script>

    <script>
        $(document).ready(function() {
            // page is now ready, initialize the calendar...

            $('.flatpickr').flatpickr();
            $('#calendar').fullCalendar({
                // put your options and callbacks here
                selectable: true,
                header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay',
                },
                events : [
                    @if(isset($calendarItems))
                        @foreach($calendarItems as $calendarItem)
                        {
                            title : '{{ $calendarItem->name }}',
                            start : '{{ $calendarItem->start_datetime }}',
                            end : '{{ $calendarItem->end_datetime }}',
                            url : '/calendarItem/'+{{$calendarItem->id}},
                        },
                        @endforeach
                    @endif
                ],
                dayClick: function(date) {
                    $("#start_datetime").val(date.format('YYYY-MM-DD hh:mm'));
                    $('#myModal').modal('show');
                },
                select: function(startDate, endDate) {
                    var correctEndDate = moment(endDate).add(-12, 'h').format('YYYY-MM-DD hh:mm a');

                    $("#start_datetime").val(startDate.format('YYYY-MM-DD hh:mm a'));
                    $("#end_datetime").val(correctEndDate);
                    $('#myModal').modal('show');
                }
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


