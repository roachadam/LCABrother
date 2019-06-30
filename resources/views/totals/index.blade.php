@extends('layouts.main')

@section('content')
    <h3>{{ auth()->user()->organization->getActiveSemester()->semester_name }}</h3>
    <div class="card">
        <div class="card-header">Averages</div>
        <div class="card-body">
            Service Hours: {{$averages['service']}}
            <br>
            Money Donated: {{$averages['money']}}
            <br>
            Involvement Points: {{$averages['points']}}
        </div>
    </div>

    <div class="card">
        <div class="card-header">Totals</div>
        <div class="card-body">
            Service Hours: {{$totals['service']}}  / {{$sumTotals['service']}}
            <br>
            Money Donated: {{$totals['money']}}  /  {{$sumTotals['money']}}
            <br>
            Involvement Points: {{$totals['points']}} / {{$sumTotals['points']}}
        </div>
    </div>
    <button type="button" class="btn btn-warning-outline" data-toggle="modal" data-target="#modal">New Semester</button>



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


