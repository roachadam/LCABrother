@extends('layouts.main')
@section('title', 'Involvement Points')
@section('content')

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/involvement">All Involvement Points</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{$user->name}}'s Breakdown</li>
    </ol>
</nav>

<section class="card">
        <div class="card-block">
            <header class="card-header" style="border-bottom: 0">
                <div class="row">
                <h2 class="card-title">{{$user->name}}'s Involvement Logs: {{$user->getInvolvementPoints()}} Total</h2>
                </div>
            </header>
            <table id="table" class="display table table-bordered" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>Event Name</th>
                        <th>Points</th>
                        <th>Date</th>
                        @if ($user->canManageInvolvement())
                            <th>Delete</th>
                        @endif
                    </tr>
                </thead>

                <tbody>
                    @if ($logs->count())
                        @foreach ($logs as $log)
                            <tr>
                                <td>{{ $log->involvement->name }}</td>
                                <td> {{ $log->involvement->points  }} </td>
                                <td>{{\Carbon\Carbon::parse($log->date_of_event )->toDayDateTimeString()}} </td>
                                @if ($user->canManageInvolvement())
                                    <td><button type="button" class="btn btn-inline btn-danger-outline" data-toggle="modal" data-target="#{{$log->id}}">Delete</button></td>
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
