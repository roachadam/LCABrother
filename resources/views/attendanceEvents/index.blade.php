@extends('layouts.main')

@section('content')
    <header class="section-header">
            <div class="tbl">
                <div class="tbl-row">
                    <div class="tbl-cell">
                        <h2>Attendance Record Events</h2>
                        {{-- <div class="subtitle">Welcome to Ultimate Dashboard</div> --}}
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
                    <th>Date</th>
                    <th>View Members Attended</th>
                    <th>Take Attendance</th>
                    <th>Manage</th>

                </tr>
                </thead>
                <tbody>
                    @if ($attendanceEvents->count())
                        @foreach ($attendanceEvents as $attendanceEvent)
                        <tr>
                            <td>{{ $attendanceEvent->calendarItem->name }}</td>
                            <td>{{ $attendanceEvent->calendarItem->start_date }}</td>
                            <td><a href="/attendance/attendanceEvent/{{$attendanceEvent->id}}" class="btn btn-primary">View</a></td>
                            <td><a href="/attendanceEvent/{{$attendanceEvent->id}}/attendance" class="btn btn-primary">Take Attendance</a></td>
                            <form action="/attendanceEvent/{{$attendanceEvent->id}}" method="POST">
                                @csrf
                                @method('DELETE')
                            <td><button type="submit" class="btn btn-warning" onclick="return confirm('Are you sure?')">Delete</button></td>
                            </form>
                        </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
            <a href="/calendarItem/create" class="btn btn-primary">Create New Event</a>
        </div>
    </section>
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
