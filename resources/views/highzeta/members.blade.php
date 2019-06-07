@extends('layouts.main')

@section('content')


    <header class="section-header">
            <div class="tbl">
                <div class="tbl-row">
                    <div class="tbl-cell">
                        <h2>Members</h2>
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
                    <th>Role</th>
                    <th>Service Hours</th>
                    <th>Money Donated</th>
                    <th>Points</th>
                    <th>Manage</th>
                </tr>
                </thead>
                <tbody>

                    @if ($members->count())
                        @foreach ($members as $member)
                        <tr>
                            <td>{{ $member->name }}</td>
                            <td>{{ $member->role->name  }}</td>
                            <td> {{ $member->getserviceHours() }} </td>
                            <td>$ {{ $member->getMoneyDonated() }} </td>
                            <td> {{ $member->getInvolvementPoints() }} </td>
                        <td><a href="/users/{{$member->id}}/adminView" class="btn btn-inline">Manage</a></td>
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
