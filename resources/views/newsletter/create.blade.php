@extends('layouts.main')

@section('content')

<form action="/newsletter" method="POST">
    @csrf
    <div class="row m-t-md">
        <label>Newletter Campaign Name</label>
        <input class="offset-1 form-control" type="text" name="name" id='name' placeholder="Meeting Minutes">
    </div>


    <label>Members To Add</label>
    <div class="offset-1">
        <div class="checkbox-toggle form-group">
                <input type="checkbox" value="-2" id="all" name="all">
                <label for="all">
                    All Users
                </label>
            </div>
        <div class="checkbox-toggle form-group">
            <input type="checkbox" value="-1" id="allUsers" name="allUsers">
            <label for="allUsers">
                All Active Members
            </label>
        </div>
        <div class="checkbox-toggle form-group">
                <input type="checkbox" value="0" id="allAlumni" name="allAlumni">
                <label for="allAlumni">
                    All Alumni
                </label>
            </div>
        @foreach ($users as $user)
            <div class="checkbox-toggle form-group">
                <input type="checkbox" value="{{$user->id}}" id="subscribers[]" name="subscribers[]">
                <label for="subscribers[]">
                    {{$user->name}}
                </label>
            </div>
        @endforeach
    </div>

    <button type="submit" class="btn btn-primary">Add</button>

</form>


@endsection
