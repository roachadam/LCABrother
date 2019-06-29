@extends('layouts.main')


@section('content')

<header class="section-header">
    <div class="tbl">
        <div class="tbl-row">
            <div class="tbl-cell">
            <h2>{{$user->name}} Service Breakdown</h2>
                {{-- <div class="subtitle">Welcome to Ultimate Dashboard</div> --}}
            </div>
        </div>
    </div>
</header>
<section class="card">
<div class="card-block">
    <table id="table" class="display table table-bordered" cellspacing="0" width="100%">
        <thead>
        @if ($serviceLogs->count())
            <tr>
                <th>Name</th>
                <th>Service Hours</th>
                <th>Money Donated</th>
                @if (auth()->user()->canManageService())
                    <th>Edit</th>
                @endif
            </tr>
        @endif

        </thead>
        <tbody>

            @forelse ($serviceLogs as $serviceLog)
                <tr>
                    <td>{{ $serviceLog->serviceEvent->name }}</td>
                    <td> {{ $serviceLog->hours_served !== null ? $serviceLog->hours_served : "N/A" }} </td>
                    <td> {{ $serviceLog->money_donated !== null ? $serviceLog->money_donated : "N/A"}} </td>
                    @if (auth()->user()->canManageService())
                        <td> <a href="/serviceLog/{{$serviceLog->id}}/edit" class="btn btn-primary">Edit</a> </td>
                    @endif
                </tr>
            @empty
                This User has no service logs!
            @endforelse

        </tbody>
    </table>
</div>
</section>

@endsection
