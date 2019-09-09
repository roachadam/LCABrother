@extends('layouts.main')
@section('css')
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.1.0/fullcalendar.min.css' />
    <link rel="stylesheet" href="css/lib/flatpickr/flatpickr.min.css">
    <link rel="stylesheet" href="css/color_picker.min.css">
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


@endsection

@section('title', 'Calendar')

@section('content')

@include('partials.errors')
<div id="calendar" class="fc fc-unthemed fc-ltr align-center"></div>


<div class="modal fade" tabindex="-1" role="dialog" id="myModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Create Calendar Event</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method='POST' action="/calendarItem" role="presentation" class="form">
                <div class="modal-body">
                    @csrf

                    <div class="col-md-12">
                        <div class="row col-md-12">
                            <label for="name" class="col-form-label text-md-right">Event Name*</label>
                            <div class="input-group">
                                <input class="offset-1 form-control" type="text" name="name" id='name' placeholder="Chapter Meeting" required>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="row col-md-12">
                            <label for="description" class="col-form-label text-md-right">Description*</label>
                            <div class="input-group">
                                <textarea name="description" class="offset-1 form-control" id="description" cols="30" rows="5" placeholder="Weekly Meeting in the Union" required></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="row col-md-12">
                            <label for='start_datetime' class="col-form-label text-md-left">Start Date*</label>
                            <div class="form-control-wrapper form-control-icon-left input-group offset-1">
                                <input id="start_datetime" type="datetime-local" class="form-control" name="start_datetime" data-enable-time="true" required autofocus>
                                {{-- <i class="fa fa-calendar"></i> --}}
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="row col-md-12">
                            <label for='end_datetime' class="col-form-label text-md-left">End Date</label>
                            <div class="form-control-wrapper form-control-icon-left input-group offset-1">
                                    <input id="end_datetime" type="datetime-local" class="form-control" name="end_datetime" data-enable-time="true" required autofocus>
                                    {{-- <i class="fa fa-calendar"></i> --}}
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="row col-md-12">
                            <label for="calendar_catagories_id" class="col-form-label text-md-right" required>Category*</label>
                            <div class="input-group offset-1">
                                <select name="calendar_catagories_id" id="color" class="form-control">
                                    <option value="0">Choose Category</option>
                                    @foreach (auth()->user()->organization->calendarCatagories as $category)
                                        <option value="{{$category->id}}">{{$category->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 m-t-md">
                        <div class="row col-md-12">
                            <div class="checkbox-toggle input-group">
                                <input type="checkbox" id=guestList name=guestList>
                                <label for=guestList class="col-form-label text-md-right">Generate GuestList</label>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="row col-md-12">
                            <div class="checkbox-toggle form-group">
                                <input type="checkbox" id="attendance" name="attendance" onclick="showInvolvement()" >
                                <label for="attendance" class="col-form-label text-md-right">Allow Attendance</label>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="row col-md-12">
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
                <button type="submit" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="false">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class='my-legend'>
                    <ul class='legend-labels'>
                        @foreach (auth()->user()->organization->calendarCatagories as $category)
                            <li>
                                <div class="row col-12">
                                    <div class="col-11">
                                        <span style='background:{{$category->color}}'></span> {{$category->name}}
                                    </div>
                                    {{-- @if($category->name !== 'General') --}}
                                        <div class="col-1 align-right">
                                            <button type="submit" class="close" data-toggle="modal" data-target="#deleteCategory{{$category->id}}">
                                            <i class="fas fa-times fa-xs"></i>
                                            {{-- <i class="far fa-times-circle"></i> --}}
                                            </button>
                                        </div>
                                    {{-- @endif --}}
                                </div>

                                <div class="modal fade" id="deleteCategory{{$category->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="modal-close" data-dismiss="modal" aria-label="Close">
                                                    <i class="font-icon-close-2"></i>
                                                </button>
                                                <h4 class="modal-title" id="myModalLabel">Delete Calendar Category</h4>
                                            </div>
                                            <form action={{route('calendarCategory.destroy',$category)}} method="POST" class="box" >
                                                <div class="modal-body">
                                                    @csrf
                                                    <div class="col-md-12">
                                                        <p>Are you sure you want to remove the category: {{$category->name}}?</p>
                                                    </div>
                                                </div>

                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-inline btn-default" data-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-inline btn-danger">Delete</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div><!--.modal-->

                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="addCatModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Calendar Category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="/calendarItem/addCategory" class="box" >
                @csrf
                <div class="modal-body">
                    <div class="col-md-12">
                        <div class="row col-md-12">
                            <label for="name" class="col-form-label text-md-right">Category Name*</label>
                            <div class="input-group">
                                <input class="offset-1 form-control" type="text" name="name" id='name' required>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="row col-md-12">
                            <label for="name" class="col-form-label text-md-right">Choose Color*</label>
                            <div class="input-group">
                                <input type="text" class="form-control inp offset-1" id="colorPicker" name="color">
                                <div class="palette" id="colorPalette"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-inline btn-default" data-dismiss="modal">Close</button>
                    <button type='submit' class="btn btn-inline btn-primary">Create</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('js')
    <script src='https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.17.1/moment.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.1.0/fullcalendar.min.js'></script>
    {{-- <script src="https://use.fontawesome.com/releases/v5.10.2/js/all.js" data-auto-replace-svg="nest"></script> --}}
    {{-- <script src="https://kit.fontawesome.com/a076d05399.js"></script> --}}
    <script src="js/lib/flatpickr/flatpickr.min.js"></script>
    <script src="js/color_picker.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#start_datetime').flatpickr();
            $('#end_datetime').flatpickr();

            calendar = $('#calendar').fullCalendar({
                // put your options and callbacks here
                selectable: true,
                customButtons: {
                    legendButton: {
                        text: 'Legend',
                        click: function()
                        {
                            $('#legendModal').modal('toggle');
                        }
                    },
                    addCategoryButton: {
                        text: 'Add Category',
                        click: function()
                        {
                            if ({{auth()->user()->canManageCalendar()}})
                            {
                                $('#addCatModal').modal('toggle');
                            }
                        }
                    },
                    addEventButton:{
                        text: 'Add Event',
                        click: function()
                        {
                            if ({{auth()->user()->canManageCalendar()}})
                            {
                                $('#myModal').modal('toggle');
                            }
                        }
                    },
                },
                header: {
                    left: 'legendButton',
                    center: 'title',
                    right: 'prev,next today',
                },
                footer: {
                    left: 'addCategoryButton,addEventButton',
                },
                height: $(window).height()*0.83,
                events : [
                    @if(isset($calendarItems))
                        @foreach($calendarItems as $calendarItem)
                        {
                            title : '{{ $calendarItem->name }}',
                            start : '{{ $calendarItem->start_datetime }}',
                            end : '{{ $calendarItem->end_datetime }}',
                            url : '/calendarItem/'+{{$calendarItem->id}},
                            color : '{{ $calendarItem->calendarCatagory->color }}',
                            // id : {{$calendarItem->id}}
                        },
                        @endforeach
                    @endif
                    @if(auth()->user()->getIncompleteTasks())
                        @foreach(auth()->user()->getIncompleteTasks() as $taskAssignments)
                        {
                            title : '{{ $taskAssignments->tasks->name }}',
                            start : '{{$taskAssignments->tasks->deadline}}',
                            url : '/tasks',
                            color : '#3fb06e'
                        }
                        @endforeach

                    @endif
                ],
                // color : '#FFFFFF',

                dayClick: function(date) {
                    if ({{auth()->user()->canManageCalendar()}})
                    {
                        // $("#start_datetime").val(date.format('YYYY-MM-DD hh:mm'));
                        console.log(date.format());
                        $("#start_datetime").val(date.format());
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
                },
                // eventClick:  function(event, jsEvent, view) {
                //     $('#modalTitle').html(event.title);
                //     $('#modalTitle').html(event.title);
                //     $('#modalBody').html(event.description);
                //     $('#eventUrl').attr('href',event.url);
                //     $('#calendarModal').modal();
                // },


            })
        });

        if(calendar) {
            $(window).resize(function()
            {
                var calHeight = $(window).height()*0.83;
                $('#calendar').fullCalendar('option', 'height', calHeight);
            });
        };
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


