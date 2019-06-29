@extends('layouts.main')


@section('content')

<header class="section-header">
    <div class="tbl">
        <div class="tbl-row">
            <div class="tbl-cell">
                <h2>Service Breakdown</h2>
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
                <th>View BreakDown</th>
                @endif
            </tr>
        @endif

        </thead>
        <tbody>

            @forelse ($serviceLogs as $serviceLog)
                <tr>
                    <td>{{ $serviceLog->serviceEvent->name }}</td>
                    <td> {{ $serviceLog->hours_served }} </td>
                    <td> {{ $serviceLog->money_donated }} </td>
                    @if (auth()->user()->canManageService())
                    <td>
                        <form action="/serviceLog/{{$serviceLog->id}}"  method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-warning" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
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
