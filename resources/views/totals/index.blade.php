@extends('layouts.main')

@section('content')
    <h3>{{ auth()->user()->organization->getActiveSemester()->semester_name }}</h3>

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
            <div class="btn-toolbar">
                <a href="/goals/edit" class="btn btn-inline btn-primary-outline offset-3">Edit</a>
                <a href="/goals/{{$goals->id}}/notify" class="btn btn-inline btn-primary-outline" data-toggle="tooltip" data-placement="top" title="Sends a message to members who do not meet a specified threshold">Notify Memebers</a>
                @if (auth()->user()->isAdmin())
                    <button type="button" class="btn btn-inline btn-warning-outline" data-toggle="modal" data-target="#modal">New Semester</button>
                @endif
            </div>
        </div>
    </div>

    <div class="row">
        <div class="card col-md-5 offset-1 ml-5 mr-5">
            <div class="card-header">Averages</div>
            <div class="card-body">
                Service Hours: {{$averages['service']}}
                <br>
                Money Donated: {{$averages['money']}}
                <br>
                Involvement Points: {{$averages['points']}}
            </div>
        </div>

        <div class="card col-md-5">
            <div class="card-header">Totals</div>
            <div class="card-body">
                Service Hours: {{$totals['service']}}  / {{$sumTotals['service']}}
                <br>
                Money Donated: {{$totals['money']}}  /  {{$sumTotals['money']}}
                <br>
                Involvement Points: {{$totals['points']}} / {{$sumTotals['points']}}
            </div>
        </div>
    </div>



    <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="modal-close" data-dismiss="modal" aria-label="Close">
                        <i class="font-icon-close-2"></i>
                    </button>
                    <h4 class="modal-title" id="myModalLabel">Start New Semester</h4>
                </div>

                <form action="{{ action('SemesterController@store') }}" method="POST">
                    @csrf
                    <div class="row m-t-md offset-1">
                        <div class="col-md-6">
                            <p>
                                <strong>Warning.</strong>
                                <br>
                                This will reset your members goal information.
                            </p>
                            <label for="money_donated">Semester Name</label>
                            <div class="form-control-wrapper form-control-icon-left">
                                <input id="semester_name" type="text" class="form-control" name="semester_name" value="{{ old('semester_name') }}" placeholder="Fall 2019"  autofocus>
                                <i class="fa fa-graduation-cap "></i>
                            </div>
                        </div>
                    </div>



                    <div class="modal-footer m-t-lg">
                        <button type="button" class="btn btn-inline btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-inline btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


@endsection


