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
                    <th>Name</th>
                    {{-- <th>Event Name</th> --}}
                    <th>Points</th>
                    @if (auth()->user()->canManageInvolvment())
                    <th>View BreakDown</th>
                    @endif


                </tr>
                </thead>
                <tbody>

                    @if ($logs->count())

                        @foreach ($logs as $log)
                            <tr>
                                <td>{{ $log->name }}</td>
                                {{-- <td>{{ $log->event_name  }}</td> --}}
                                <td> {{ $log->points }} </td>
                                @if (auth()->user()->canManageInvolvment())
                                    <td><button type="button" class="btn btn-inline btn-primary btn-sm ladda-button" data-toggle="modal" data-target="#editServiceEvent">View</button></td>
                                @endif
                            </tr>
                        @endforeach

                    @endif

                </tbody>
            </table>
        </div>
    </section>



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
@endsection
