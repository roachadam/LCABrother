@extends('layouts.main')


@section('content')

<div class="card">
    <div class="card-header">{{ __('Organization Goals') }}</div>
    <div class="card-body">
        <div class="row">
            <label  class="col-md-5 col-form-label text-md-right offset-1">Involvement Points Goal:  {{ $goals->points_goal }}<label>
        </div>
        <div class="row">
            <label  class="col-md-5 col-form-label text-md-right offset-1">Study Hours Goal :  {{ $goals->study_goal }}<label>
        </div>
        <div class="row">
            <label  class="col-md-5 col-form-label text-md-right offset-1">Service Hours Goal :  {{ $goals->service_hours_goal }}<label>
        </div>
        <div class="row">
            <label  class="col-md-5 col-form-label text-md-right offset-1 margin-2">Money Donated Goal :  {{ $goals->service_money_goal }}<label>
        </div>
        <div class="row">
            <a href="/goals/edit" class="btn btn-inline col-md-2 offset-4 ">Edit</a>
        </div>
    </div>


</div>


<div class="box-typical-body card-default">
</div>


@endsection
