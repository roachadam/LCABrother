@extends('layouts.main')
@section('css')
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.1.0/fullcalendar.min.css' />
    <link rel="stylesheet" href="css/lib/flatpickr/flatpickr.min.css">
    <link rel="stylesheet" href="css/lib/flatpickr/flatpickr.min.css">
    <style type='text/css'>
        .my-legend .legend-title {
          text-align: left;
          margin-bottom: 5px;
          font-weight: bold;
          font-size: 90%;
          }
        .my-legend .legend-scale ul {
          margin: 0;
          margin-bottom: 5px;
          padding: 0;
          float: left;
          list-style: none;
          }
        .my-legend .legend-scale ul li {
          font-size: 80%;
          list-style: none;
          margin-left: 0;
          line-height: 18px;
          margin-bottom: 2px;
          }
        .my-legend ul.legend-labels li span {
          display: block;
          float: left;
          height: 16px;
          width: 30px;
          margin-right: 5px;
          margin-left: 0;
          border: 1px solid #999;
          }
        .my-legend .legend-source {
          font-size: 70%;
          color: #999;
          clear: both;
          }
        .my-legend a {
          color: #777;
          }
      </style>

@section('title', 'Calendar')

@section('content')

<button type="button" class="btn btn-inline btn-primary" data-toggle="modal" data-target="#legendModal">Legend</button>

<div id="calendar" class="fc fc-unthemed fc-ltr"></div>

<div class="modal fade" tabindex="-1" role="dialog" id="myModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Create Event</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method='POST' action="/calendarItem" role="presentation" class="form">
                <div class="modal-body">
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
                            <label for="color">Category</label>
                            <select name="color" id="color" class="form-control">
                                <option value="0">Choose Category</option>
                                @foreach (auth()->user()->organization->calendarCatagories as $category)
                                    <option value="{{$category->color}}">{{$category->name}}</option>
                                @endforeach
                            </select>
                        </div>
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

                    <div class="modal-footer">
                        <button type="button" class="btn btn-inline btn-default" data-dismiss="modal">Close</button>
                        <button type='submit' class="btn btn-inline btn-primary">Create</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="legendModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Legend</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class='my-legend'>
                        <ul class='legend-labels'>
                            @foreach (auth()->user()->organization->calendarCatagories as $category)
                                <li><span style='background:{{$category->color}}'></span>{{$category->name}}</li>
                            @endforeach
                        </ul>
                    </div>
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
                            color : '{{ $calendarItem->color }}'
                        },
                        @endforeach
                    @endif
                ],
                // color : '#FFFFFF',

                dayClick: function(date) {
                    if ({{auth()->user()->canManageCalendar()}})
                    {
                        $("#start_datetime").val(date.format('YYYY-MM-DD hh:mm'));
                        $('#myModal').modal('show');
                    }
                },
                select: function(startDate, endDate) {
                    if ({{auth()->user()->canManageCalendar()}})
                    {
                        var correctEndDate = moment(endDate).add(-12, 'h').format('YYYY-MM-DD hh:mm a');
                        $("#start_datetime").val(startDate.format('YYYY-MM-DD hh:mm a'));
                        $("#end_datetime").val(correctEndDate);
                        $('#myModal').modal('show');
                    }
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


