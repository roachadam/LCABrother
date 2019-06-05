@extends('layouts.main')


@section('content')
@include('partials.errors')
<div class="card">
    <div class="card-header">{{ __('Goals') }}</div>
    <div class="card-body">
        <div class="row">
            <label  class="col-md-5 col-form-label text-md-left offset-1">Involvement Points Goal:  {{ $goals->points_goal }}<label>
        </div>
        <div class="row">
            <label  class="col-md-5 col-form-label text-md-left offset-1">Study Hours Goal :  {{ $goals->study_goal }}<label>
        </div>
        <div class="row">
            <label  class="col-md-5 col-form-label text-md-left offset-1">Service Hours Goal :  {{ $goals->service_hours_goal }}<label>
        </div>
        <div class="row">
            <label  class="col-md-5 col-form-label text-md-left offset-1 margin-2">Money Donated Goal :  {{ $goals->service_money_goal }}<label>
        </div>

    </div>
</div>

<div class="card">
    <div class="card-header">{{ __('Notifcations to Members') }}</div>
    <div class="card-body">
        <form method="POST" action="/goals/{{$goals->id}}/notify/send">
            @csrf

            <div class="form-group row">
                <label for="goal_type" class="col-md-2 col-form-label text-md-right">{{ __('Involvement Items') }}</label>

                <div class="col-md-6">
                    <select class="form-control m-bot15" name="goal_type">
                        <option value="" selected="selected" disabled >Choose One</option>
                        <option value="points_goal">Points Goal</option>
                        <option value="study_goal">Study Goal</option>
                        <option value="service_hours_goal">Service Hours Goal</option>
                        <option value="service_money_goal">Money Donated Goal</option>

                    </select>
                </div>
            </div>

            <div class="form-group row">
                <label for="threshhold" class="col-md-2 col-form-label text-md-right">{{ __('Threshhold') }}</label>

                <div class="col-md-6">
                    <input id="threshhold" type="text" class="form-control" name="threshhold" value="{{ old('threshhold') }}" required autocomplete="threshhold" autofocus>
                </div>
            </div>

            <button type="submit" class="btn btn-inline btn-primary">Submit</button>
        </form>

        <form method="POST" action="/goals/{{$goals->id}}/notify/sendAll">
            @csrf
            <button type="submit" class="btn btn-inline btn-primary">Alert all under goals</button>
        </form>
    </div>
</div>

<div class="box-typical-body card-default">
</div>


@endsection
