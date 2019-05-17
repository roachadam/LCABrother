@extends('layouts.app')

@section('content')

<h1>Add Roles to {{ $org->name }}</h1>


{{--Displays a list of the selected roles--}}
@if ($org->roles->count())
    <div class="box-panel">
        <h2>Current Roles</h2>
        @foreach ($org->roles as $role)
            <div>
            <a href="/role/{{ $role->id }}/edit"> {{$role->name}} </a>
            </div>
        @endforeach
    </div>
@endif

<form method="POST" action="/organizations/{{ $org->id }}/roles" class="box" >
    @csrf
    <label class="label" for="name">New Role</label>

    <div class="control">
        <input type="text" class="input-lg" name="name" placeholder="New Role" required>
    </div>

    <div class="field">
        <div class="control">
            <button type="submit" class="button is-link">Add Role</button>
        </div>
    </div>

</form>


@endsection
