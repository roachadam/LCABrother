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
                                <td><button type="button" class="btn btn-inline btn-outline-danger" data-toggle="modal" data-target="#{{$attendance->id}}">Delete</button></td>
                            </tr>

                            <!--.modal for confirming deletion-->
                            <div class="modal fade" id="{{$attendance->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="modal-close" data-dismiss="modal" aria-label="Close">
                                                <i class="font-icon-close-2"></i>
                                            </button>
                                            <h4 class="modal-title" id="myModalLabel">Delete Attendance</h4>
                                        </div>
                                        <form action="/attendance/{{$attendance->id}}" method="POST" class="box" >
                                            <div class="modal-body">
                                                @csrf
                                                @method('DELETE')
                                                <div class="col-md-12">
                                                    <p>Are you sure you want to delete this {{$attendance->user->name}}'s attendance?</p>
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
