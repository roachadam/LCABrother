@extends('layouts.main')

@section('content')

<h2 >Involvement</h2>

<div class="container">
    <div class="container">
        @include('partials.errors')
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">{{ __('Add New Involvement Scores') }}</div>
                <div class="card-body">
                    @if($involvements->count())
                    <form method="POST" action="/involvementLog">
                        @csrf

                        {{-- @if($involvements->count()) --}}
                        <div class="form-group row">
                            <label for="involvement_id" class="col-form-label text-md-right">{{ __('Involvement Items') }}</label>

                            <div class="col-md-4">
                                <select class="form-control m-bot15" name="involvement_id">
                                    <option value="" selected="selected" disabled >Choose One</option>
                                    @foreach ($involvements as $invovlement)
                                        <option value="{{ $invovlement->id }}">{{ $invovlement->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row m-t-md">
                            <label for='date_of_event'>Date of Event</label>

                            <div class="col-md-4">
                                    <input class="offset-1 form-control" type="date" name="date_of_event" id="date_of_event">

                            </div>
                        </div>
                        @if(isset($verifiedMembers))
                            <div class="form-group row">
                                <label for="usersInvolved[]" class="col-form-label text-md-right">{{ __('Members Involved') }}</label>
                            </div>

                            @foreach ($verifiedMembers as $user)
                                <div class="row offset-1">
                                    <div class="checkbox-toggle form-group">
                                        <input type="checkbox" id="usersInvolved{{$user->id}}" name="usersInvolved[]" value="{{$user->id}}">
                                        <label for="usersInvolved{{$user->id}}">{{ $user->name }}
                                    </div>
                                </div>
                            @endforeach
                        @endif

                        <button type="submit" class="btn btn-inline btn-primary">Submit</button>
                    </form>
                    @else
                    <p>Please create  at least one involvement event to submit scores</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-5">
        <div class="card">
            <div class="card-header">{{ __('Manage Involvement Data') }}</div>
            <div class="btn-toolbar offset-1">
                <form action="/involvement/create">
                    <button type="submit" class="btn btn-inline btn-primary">Create New</button>
                </form>
                <button type="button" class="btn btn-inline btn-secondary-outline" data-toggle="modal" data-target="#uploadInvolvementData">Upload Involvement Data</button>
            </div>
        </div>
    </div>


    <!--.modal for Uploading Involvement Data<-->
    <div class="modal fade" id="uploadInvolvementData" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="modal-close" data-dismiss="modal" aria-label="Close">
                        <i class="font-icon-close-2"></i>
                    </button>
                    <h4 class="modal-title" id="myModalLabel">Upload Involvement Data</h4>
                </div>
                <form method="POST" action="/involvement/import" enctype="multipart/form-data" class="box" >
                    @csrf
                    <div class="modal-body">
                        <div class="col-md-12">
                            <input type="file" class="offset-1 form-control-file" name="InvolvementData" id="InvolvementData" aria-describedby="fileHelp">
                            <small id="fileHelp" class="offset-1 form-text text-muted">**Please be sure to check the Format Rules**</small>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-inline btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-inline btn-primary">Upload</button>
                    </div>
                </form>
            </div>
        </div>
    </div><!--.modal-->
</div>

@endsection
