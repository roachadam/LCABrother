@extends('layouts.main')

@section('content')


    <header class="section-header">
            <div class="tbl">
                <div class="tbl-row">
                    <div class="tbl-cell">
                    <h2>{{$attendanceEvent->calendarItem->name}} Attendance</h2>
                    <h4>{{$attendanceEvent->calendarItem->start_date}}</h4>
                    </div>
                </div>
            </div>
        </header>
        <section class="card">
		<div class="card-block">
            @include('partials.errors')
            <table id="table" class="display table table-bordered" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>Member Name</th>
                    <th>Manage</th>
                </tr>
                </thead>
                <tbody>
                    @if ($attendances->count())
                        @foreach ($attendances as $attendance)
                        <tr>
                            <td>{{ $attendance->user->name }}</td>
                            <form action="/attendance/{{$attendance->id}}" method="POST">
                                @csrf
                                @method('DELETE')
                            <td><button type="submit" class="btn btn-warning" onclick="return confirm('Are you sure?')">Delete</button></td>
                            </form>
                        </tr>
                        @endforeach
                    @endif

                </tbody>
            </table>
            <a href="/attendanceEvent/{{$attendanceEvent->id}}/attendance" class="btn btn-inline btn-outline-primary">Take Attendance</a>
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
