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
        <tr>
            <th>Name</th>
            <th>Service Hours</th>
            <th>Money Donated</th>
            @if (auth()->user()->canManageService())
            <th>View BreakDown</th>
            @endif


        </tr>
        </thead>
        <tbody>
            @forelse ($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td> {{ $user->getserviceHours() }} </td>
                    <td>$ {{ $user->getMoneyDonated() }} </td>
                    @if (auth()->user()->canManageService())
                        <td><a href="/users/{{$user->id}}/service" class="btn btn-inline">View</a></td>
                    @endif
                </tr>
            @empty

            @endforelse

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


