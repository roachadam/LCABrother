@extends('layouts.main')
@section('title', 'Involvement Points')
@section('content')
    <section class="card">
        <div class="card-block">
            <header class="card-header" style="border-bottom: 0">
                <div class="row">
                    <h2 class="card-title">Involvement Points</h2>
                    <div class="ml-auto" id="headerButtons">
                        <a href="/user/{{auth()->user()->id}}/involvementLogs" class="btn btn-inline {{ $canManageInvolvement ? 'btn-secondary-outline' : 'btn-primary'}}">My Involvement Breakdown</a>
                        @if ($canManageInvolvement)
                            <button type="button" class="btn btn-inline btn-secondary-outline" data-toggle="modal" data-target="#addInvolvementScores">Add Involvement Scores</button>
                            <button type="button" class="btn btn-inline btn-primary" data-toggle="modal" data-target="#uploadInvolvementData">Upload Involvement Data</button>
                        @endif
                    </div>
                </div>
            </header>
            @include('partials.errors')
            <table id="table" class="display table table-bordered" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Points</th>
                        @if ($canManageInvolvement)
                            <th>View</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td> {{ $user->getInvolvementPoints() }} </td>
                        @if ($canManageInvolvement)
                            <td><a href="/user/{{$user->id}}/involvementLogs" class="btn btn-inline">View</a></td>
                        @endif
                    </tr>
                    @empty
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

    @if ($canManageInvolvement)
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

    <!--.modal for adding Involvement Scores<-->
    <div class="modal fade" id="addInvolvementScores" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="modal-close" data-dismiss="modal" aria-label="Close">
                            <i class="font-icon-close-2"></i>
                        </button>
                        <h4 class="modal-title" id="myModalLabel">Add Involvement Scores</h4>
                    </div>
                    <form method="POST" action="/involvementLog" enctype="multipart/form-data" class="box" >
                        @csrf
                        <div class="modal-body">
                            <div class="col-md-12">
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
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-inline btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-inline btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div><!--.modal-->
    @endif
@endsection

@section('js')
    <script type="text/javascript" src="{{ asset('js/lib/datatables-net/datatables.min.js') }}"></script>
    <script>
        $(function() {
            $('#table').DataTable({
                responsive: true
            });
        });
    </script>
@endsection
