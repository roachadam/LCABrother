@extends('layouts.main')
@section('title', 'Attendance')
@section('content')
    <header class="section-header">
        <div class="tbl">
            <div class="tbl-row">
                <div class="tbl-cell">
                    <div class="row">
                        <h2 class="card-title">{{$serviceEvent->name}} Attendance</h2>
                        <div class="ml-auto">
                            @if (auth()->user()->canManageService())
                                <button type="button" class="btn btn-inline btn-danger" data-toggle="modal" data-target="#deleteEvent">Delete Event</button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <section class="card">
        <div class="card-block">
            @if ($serviceEvent->ServiceLogs->count())

                <table id="table" class="display table table-bordered" cellspacing="0" width="100%">
                    <thead>
                            <tr>
                                <th>Name</th>
                                <th>Logged At</th>
                                <th>Hours Served</th>
                                <th>Money Donated</th>
                                @if (auth()->user()->canManageInvolvement())
                                <th>Manage</th>
                                @endif
                            </tr>

                    </thead>

                    <tbody>
                        @foreach ($serviceEvent->ServiceLogs as $log)
                            <tr>
                                <td>{{ $log->user->name }}</td>
                                <td> {{ $log->created_at  }} </td>
                                <td> {{ $log->hours_served  }} </td>
                                <td> {{ $log->money_donated  }} </td>
                                @if (auth()->user()->canManageInvolvement())
                                    <td><button type="button" class="btn btn-inline btn-danger-outline" data-toggle="modal" data-target="#deleteLog{{$log->id}}">Delete</button></td>

                                    <div class="modal fade" id="deleteLog{{$log->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="modal-close" data-dismiss="modal" aria-label="Close">
                                                        <i class="font-icon-close-2"></i>
                                                    </button>
                                                    <h4 class="modal-title" id="myModalLabel">Delete</h4>
                                                </div>
                                                <form action={{route('serviceLogs.destroy', $log)}} method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <div class="modal-body">
                                                        <div class="col-md-12">
                                                            <p>Are you sure you want to delete {{$log->user->name}}'s service log?</p>
                                                        </div>
                                                    </div>

                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-inline btn-default" data-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-inline btn-danger">Delete</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </tr>
                            @endforeach
                    </tbody>
                </table>
            @else
                <p>There are no logs for {{$serviceEvent->name}}!</p>
            @endif
        </div>
    </section>
    <div class="modal fade" id="deleteEvent" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="modal-close" data-dismiss="modal" aria-label="Close">
                            <i class="font-icon-close-2"></i>
                        </button>
                        <h4 class="modal-title" id="myModalLabel">Delete</h4>
                    </div>
                    <form action="/serviceEvent/{{$serviceEvent->id}}" method="POST">
                        @csrf
                        @method('DELETE')
                        <div class="modal-body">
                            <div class="col-md-12">
                                <p>Are you sure you want to delete {{$serviceEvent->name}} and all logs associated?</p>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-inline btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-inline btn-danger">Delete</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
@endsection

