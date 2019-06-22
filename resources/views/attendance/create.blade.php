@extends('layouts.main')


@section('content')

    <div class="card">

        <div class="card-header">{{$attendanceEvent->name}} Log Users as Attended</div>
        <div class="card-body">
                @include('partials.errors')

                @if ($attendanceEvent->getUsersNotInAttendance()->count())
                <form method="POST" action="/attendanceEvent/{{$attendanceEvent->id}}/attendance">
                    @csrf
                    <label for="users"><h3>Users</h3></label>
                    @foreach ($attendanceEvent->getUsersNotInAttendance() as $user)
                        <div class="checkbox-toggle form-group" id='users'>
                            <input type="checkbox" value="{{$user->id}}" name="users[]" id="subscribers{{$user->id}}">
                            <label for="subscribers{{$user->id}}">
                                {{$user->name}}
                            </label>
                        </div>
                    @endforeach

                    <div class="row">
                        <button type="submit" class="btn btn-inline btn-primary">Submit Attendance</button>
                        <a href="/attendance/attendanceEvent/{{$attendanceEvent->id}}" class="btn btn-inline btn-outline-primary">View Attendance</a>
                    </div>
                </form>
                @else
                    <p>All your members are in attendance!</p>
                    <a href="/attendance/attendanceEvent/{{$attendanceEvent->id}}" class="btn btn-inline btn-outline-primary">View Attendance</a>

                @endif



        </div>
    </div>
@endsection
