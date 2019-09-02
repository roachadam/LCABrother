@extends('layouts.main')

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/calendarItem">Calendar</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{$calendarItem->name}}</li>
    </ol>
</nav>
<div class="card">
    <div class="card-header">{{$calendarItem->name}}</div>
    <div class="card-body">
        <div class="offset-1">
            <p>Category: <span style='background:{{$calendarItem->calendarCatagory->color}}'>&nbsp;{{ $calendarItem->calendarCatagory->name }}&nbsp;</span></p>
            <p> Description : {{$calendarItem->description}} </p>
            @if ($calendarItem->end_datetime != $calendarItem->start_datetime)
                <p id="startDate">Start Date : {{ \Carbon\Carbon::parse($calendarItem->start_datetime)->format('m/d/Y h:i a') }}</p>
                <p id="endDate">End Date : {{ \Carbon\Carbon::parse($calendarItem->end_datetime)->format('m/d/Y h:i a') }}</p>
            @else
                <p>Date : {{\Carbon\Carbon::parse($calendarItem->start_datetime)->toDayDateTimeString()}}</p>
            @endif

            @if (auth()->user()->canManageEvents())
                <div class="row m-t-md">
                    <td><button type="button" class="btn btn-inline btn-danger-outline" data-toggle="modal" data-target="#{{$calendarItem->id}}">Delete</button></td>
                </div>
            @endif

            @if ($attendanceEvent !== null)
                <div class="row m-t-md">
                    <a href="/attendanceEvent/{{$attendanceEvent->id}}/attendance" class="btn btn-primary">Take Attendance</a>
                </div>
            @endif
        </div>

        @if ($calendarItem->hasEvent() && auth()->user()->canManageEvents())
            <header class="section-header">
                <div class="tbl m-t-md">
                    <div class="tbl-row">
                        <div class="tbl-cell">
                            <h4>Guest List</h4>
                        </div>
                    </div>
                </div>
            </header>

            <section class="card">
                <div class="card-block">
                    <table id="table" class="display table table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>Brother Name</th>
                                <th>Guest Name</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($invites->count())
                                @foreach ($invites as $invite)
                                    <tr>
                                        <td>{{ $invite->user->name }}</td>
                                        <td> {{$invite->guest_name}} </td>
                                        <td><button type="button" class="btn btn-inline btn-danger-outline" data-toggle="modal" data-target="#{{$invite->id}}">Delete</button></td>
                                    </tr>

                                    <!--.modal for confirming deletion-->
                                    <div class="modal fade" id="{{$invite->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="modal-close" data-dismiss="modal" aria-label="Close">
                                                        <i class="font-icon-close-2"></i>
                                                    </button>
                                                    <h4 class="modal-title" id="myModalLabel">Delete</h4>
                                                </div>
                                                <form action="/invite/{{ $invite->id }}" method="POST" class="box" >
                                                    <div class="modal-body">
                                                        @csrf
                                                        @method('DELETE')
                                                        <div class="col-md-12">
                                                            <p>Are you sure you want to delete guest?</p>
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
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </section>
            <div class="row">
                <a href="/event/{{ $event->id }}/edit" class="btn btn-inline ">Edit</a>
            </div>
        @endif

        @if ($attendanceEvent !== null)
            <header class="section-header">
                    <div class="tbl">
                        <div class="tbl-row">
                            <div class="tbl-cell">
                                <h2>{{$attendanceEvent->calendarItem->name}} Attendance</h2>
                            </div>
                        </div>
                    </div>
                </header>
                <section class="card">
                <div class="card-block">
                    <table id="table" class="display table table-bordered" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th>Event Name</th>
                            <th>Manage</th>
                        </tr>
                        </thead>
                        <tbody>
                            @if ($attendanceEvent->attendance->count())
                                @foreach ($attendanceEvent->attendance as $att)
                                    <tr>
                                        <td>{{ $att->user->name }}</td>
                                        <td><button type="button" class="btn btn-inline btn-danger-outline" data-toggle="modal" data-target="#{{$att->id}}">Delete</button></td>
                                    </tr>

                                    <!--.modal for confirming deletion-->
                                    <div class="modal fade" id="{{$att->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="modal-close" data-dismiss="modal" aria-label="Close">
                                                        <i class="font-icon-close-2"></i>
                                                    </button>
                                                    <h4 class="modal-title" id="myModalLabel">Delete</h4>
                                                </div>
                                                <form action="/attendance/{{$att->id}}" method="POST" class="box" >
                                                    <div class="modal-body">
                                                        @csrf
                                                        @method('DELETE')
                                                        <div class="col-md-12">
                                                            <p>Are you sure you want to delete this user's attendance?</p>
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
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </section>
        @endif
    </div>
</div>

    <!--.modal for confirming deletion-->
    <div class="modal fade" id="{{$calendarItem->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="modal-close" data-dismiss="modal" aria-label="Close">
                        <i class="font-icon-close-2"></i>
                    </button>
                    <h4 class="modal-title" id="myModalLabel">Delete Calendar Entry</h4>
                </div>
                <form action="/calendarItem/{{ $calendarItem->id }}" method="POST" class="box" >
                    <div class="modal-body">
                        @csrf
                        @method('DELETE')
                        <div class="col-md-12">
                            <p>Are you sure you want to delete this calendar entry?</p>
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

    @section('js')
    <script type="text/javascript" src="{{ asset('js/lib/datatables-net/datatables.min.js') }}"></script>
    <script>

            $(function() {
                $('#table').DataTable({
                    responsive: true
                });
            });
        </script>
    @endsection
@endsection
