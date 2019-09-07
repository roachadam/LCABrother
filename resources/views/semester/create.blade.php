@extends('layouts.theme')
@section('title', 'Initial Semester')
@section('content')
    <div class="auth__media">
        <img src="/img/home/ordinary.svg">
    </div>
    <div class="auth__auth">
        <h1 class="auth__title">Set Semester Name</h1>
        @include('partials.errors')
        <li>Set a name for your first semester!</li>
        <li>This will allow you to reset membership data without losing their records.</li>
        <form method="POST" action=" {{action('SemesterController@initial')}} ">
            @csrf
            <label>Semester Name</label>
            <input type="text" name="semester_name" class="form-control" placeholder="Fall 2019">
            <button type="submit">Submit</button>
        </form>

    </div>
@endsection
