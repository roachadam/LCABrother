@extends('layouts.theme')
@section('title', 'Set Goals')
@section('content')
    <div class="auth__media">
        <img src="/img/home/ordinary.svg">
    </div>
    <div class="auth__auth">
        <h1 class="auth__title">Join Organization</h1>
        @include('partials.errors')
        <form method="POST" action="/goals/store">
            @csrf
            <label>Service Hours Goal</label>
            <input id="service_hours_goal" type="text" class="form-control " name="service_hours_goal" value="{{ old('service_hours_goal') }}" required autocomplete="service_hours_goal" autofocus>

            <label>Money Donated Goal</label>
            <input id="service_money_goal" type="text" class="form-control" name="service_money_goal" value="{{ old('service_money_goal') }}" required autocomplete="service_money_goal" autofocus>

            <label>Study Hours Goal</label>
            <input id="study_goal" type="text" class="form-control " name="study_goal" value="{{ old('study_goal') }}" required autocomplete="study_goal" autofocus>

            <label>Involvement Points Goal</label>
            <input id="points_goal" type="text" class="form-control " name="points_goal" value="{{ old('points_goal') }}" required autocomplete="points_goal" autofocus>

            <button type="submit" class="btn btn-primary">Set Goals</button>
        </form>
    </div>
@endsection


