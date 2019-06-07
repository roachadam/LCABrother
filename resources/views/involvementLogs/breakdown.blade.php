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
                                    <form action="/involvementLog/{{$log->id}}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <td><button type="submit" class="btn btn-inline">Remove</button>    </td>
                                    </form>
                                @endif
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </section>
@endsection

