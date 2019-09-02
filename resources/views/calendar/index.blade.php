@extends('layouts.main')
@section('css')
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.1.0/fullcalendar.min.css' />
    <link rel="stylesheet" href="css/lib/flatpickr/flatpickr.min.css">
    <link rel="stylesheet" href="css/lib/flatpickr/flatpickr.min.css">
    <link rel="stylesheet" href="css/color_picker.min.css">
@endsection
@section('title', 'Calendar')

@section('content')

@include('partials.errors')
<div id="calendar" class="fc fc-unthemed fc-ltr align-center"></div>

{{-- {{-- <button type="button" class="btn btn-inline btn-primary m-t-md" data-toggle="modal" data-target="#legendModal">Legend</button> --}}
{{-- @if (auth()->user()->canManageCalendar())
    <button type="button" class="btn btn-inline btn-primary m-t-md" data-toggle="modal" data-target="#myModal">Add Event</button>
@endif --}}

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
                                <input id="start_datetime" type="date" class="form-control" name="start_datetime"  required autocomplete="start_datetime" autofocus>
                                <i class="fa fa-calendar"></i>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="row col-md-12">
                            <label for='end_datetime' class="col-form-label text-md-left">End Date*</label>
                            <div class="form-control-wrapper form-control-icon-left input-group offset-1">
                                <input id="end_datetime" type="date" class="form-control" name="end_datetime"  required autocomplete="end_datetime" autofocus>
                                <i class="fa fa-calendar"></i>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="row col-md-12">
                                <label for="color" class="col-form-label text-md-right" required>Category*</label>
                            <div class="input-group offset-1">
                                <select name="color" id="color" class="form-control">
                                    <option value="0">Choose Category</option>
                                    @foreach (auth()->user()->organization->calendarCatagories as $category)
                                        <option value="{{$category->color}}">{{$category->name}}</option>
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
                <div class="modal-body mx-auto col-md-12">

                    <div  class="col-md-6">
                        <div class="row m-t-md">
                            <label class="form-label semibold" for="name">Category Name</label>
                            <input type="text" class="form-control" id="name" name="name">
                        </div>

                        <div class="row m-t-md">
                            <label class="form-label semibold" for="colorPicker">Choose Color</label>
                            <input type="text" class="form-control inp" id="colorPicker" name="color">
                            <div class="palette" id="colorPalette"></div>
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


@section('js')
    <script src='https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.17.1/moment.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.1.0/fullcalendar.min.js'></script>
    <script src="js/lib/flatpickr/flatpickr.min.js"></script>
    <script src="js/color_picker.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.flatpickr').flatpickr();

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
                            color : '{{ $calendarItem->color }}'
                        },
                        @endforeach
                    @endif
                ],
                // color : '#FFFFFF',

                dayClick: function(date) {
                    if ({{auth()->user()->canManageCalendar()}})
                    {
                        // $("#start_datetime").val(date.format('YYYY-MM-DD hh:mm'));
                        console.log(date.format('MM/DD/YY'));
                        $("#start_datetime").val(date.format('dd-mm-yy'));
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
@endsection


