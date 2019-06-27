@extends('layouts.main')

@section('content')
    <header class="section-header">
            <div class="tbl">
                <div class="tbl-row">
                    <div class="tbl-cell">
                        <h2>Involvement Logs</h2>
                        {{-- <div class="subtitle">Welcome to Ultimate Dashboard</div> --}}
                    </div>
                </div>
            </div>
        </header>
        <section class="card">
		<div class="card-block">
            <table id="table" class="display table table-bordered" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>Event Name</th>
                        <th>Points</th>
                        <th>Date</th>
                        @if (auth()->user()->canManageInvolvment())
                        <th>View BreakDown</th>
                        @endif
                    </tr>
                </thead>

                <tbody>
                    @if ($logs->count())
                        @foreach ($logs as $log)
                            <tr>
                                <td>{{ $log->involvement->name }}</td>
                                <td> {{ $log->involvement->points  }} </td>
                                <td> {{ $log->date_of_event  }} </td>
                                @if (auth()->user()->canManageInvolvment())
                                    <td><button type="button" class="btn btn-inline btn-outline-danger" data-toggle="modal" data-target="#{{$log->id}}">Remove</button></td>
                                @endif
                            </tr>

                            <!--.modal for confirming deletion-->
                            <div class="modal fade" id="{{$log->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="modal-close" data-dismiss="modal" aria-label="Close">
                                                    <i class="font-icon-close-2"></i>
                                                </button>
                                                <h4 class="modal-title" id="myModalLabel">Delete Involvement Log</h4>
                                            </div>
                                            <form action="/involvementLog/{{$log->id}}" method="POST" class="box" >
                                                <div class="modal-body">
                                                    @csrf
                                                    @method('DELETE')
                                                    <div class="col-md-12">
                                                        <p>Are you sure you want to remove this log?</p>
                                                    </div>
                                                </div>

                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-inline btn-default" data-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-inline btn-danger">Delete</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div><!--.modal-->

                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </section>
@endsection

