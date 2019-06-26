@extends('layouts.main')

@section('content')
    <header class="section-header">
        <div class="tbl">
            <div class="tbl-row">
                <div class="tbl-cell">
                <h2>{{$serviceEvent->name}} Attendance</h2>
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
                    <th>Logged At</th>
                    <th>Hours Served</th>
                    <th>Money Donated</th>
                    @if (auth()->user()->canManageInvolvment())
                    <th>Manage</th>
                    @endif
                </tr>
            </thead>

            <tbody>
                @if ($serviceEvent->ServiceLogs->count())
                    @foreach ($serviceEvent->ServiceLogs as $log)
                        <tr>
                            <td>{{ $log->user->name }}</td>
                            <td> {{ $log->created_at  }} </td>
                            <td> {{ $log->hours_served  }} </td>
                            <td> {{ $log->money_donated  }} </td>
                            @if (auth()->user()->canManageInvolvment())
                                <form action="/serviceLog/{{$log->id}}" method="POST">
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

@if (auth()->user()->canManageService())
    <div class="card">
        <div class="card-header">Edit Details</div>
        <div class="card-body">
            <form action="/serviceEvent/{{$serviceEvent->id}}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-warning">Delete</button>
            </form>

        </div>
    </div>
    @endif
@endsection

