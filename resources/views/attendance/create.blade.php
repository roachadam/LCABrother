@extends('layouts.main')


@section('content')

    <div class="card">

        <div class="card-header">{{$attendanceEvent->name}} Attendance</div>
        <div class="card-body">
                @include('partials.errors')
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

                <button type="submit" class="btn btn-inline btn-primary">Submit Attendance</button>
            </form>

            <h3>Members in attendance</h3>
            @foreach ($attendanceEvent->getUsersInAttendance() as $user)
                <ul>
                    <li>{{$user->name}}</li>
                </ul>

            @endforeach
        </div>
    </div>
@endsection
