@extends('layouts.main')
@section('title', 'Attendance')
@section('content')
    <section class="card">
        <div class="card-block">
            <header class="card-header" style="border-bottom: 0">
                <div class="row">
                    <h2 class="card-title">Attendance Records</h2>
                </div>
            </header>
            <table id="table" class="display table table-bordered" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>Event Name</th>
                    <th>Date</th>
                    <th>View Members Attended</th>
                    @if ($user->canTakeAttendance())
                        <th>Take Attendance</th>
                    @endif

                    @if($user->canManageAttendance())
                        <th>Delete</th>
                    @endif
                </tr>
                </thead>
                <tbody>
                    @if ($attendanceEvents->count())
                        @foreach ($attendanceEvents as $attendanceEvent)
                            <tr>
                                <td>{{ $attendanceEvent->calendarItem->name }}</td>
                                <td>{{ $attendanceEvent->calendarItem->start_date }}</td>
                                <td><a href="/attendance/attendanceEvent/{{$attendanceEvent->id}}" class="btn btn-primary">View</a></td>
                                @if ($user->canTakeAttendance())
                                    <td><a href="/attendanceEvent/{{$attendanceEvent->id}}/attendance" class="btn btn-primary">Take Attendance</a></td>
                                @endif

                                @if($user->canManageAttendance())
                                    <td><button type="button" class="btn btn-inline btn-danger-outline" data-toggle="modal" data-target="#{{$attendanceEvent->id}}">Delete</button></td>

                                    <!--.modal for confirming deletion-->
                                    <div class="modal fade" id="{{$attendanceEvent->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="modal-close" data-dismiss="modal" aria-label="Close">
                                                            <i class="font-icon-close-2"></i>
                                                        </button>
                                                        <h4 class="modal-title" id="myModalLabel">Delete Attendance Log</h4>
                                                    </div>
                                                    <form action={{route('attendanceEvents.destroy', $attendanceEvent)}} method="POST" class="box" >
                                                        <div class="modal-body">
                                                            @csrf
                                                            @method('DELETE')
                                                            <div class="col-md-12">
                                                                <p>Are you sure you want to delete this attendance log?</p>
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
                                @endif
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </section>

    @section('js')
        <script type="text/javascript" src="{{ asset('js/lib/datatables-net/datatables.min.js') }}"></script>
        <script>
            $(function() {
                $('#table').DataTable({
                    responsive: true,
                pageLength: 25
                });
            });
        </script>
    @endsection
@endsection
