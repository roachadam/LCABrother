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
                    <th>Points</th>
                    <th>Manage</th>
                </tr>
                </thead>
                <tbody>

                    @if ($members->count())

                    @foreach ($members as $member)
                    <tr>
                        <th>{{ $member->name }}</th>
                        <th>{{ $member->role->name  }}</th>
                        <th> later </th>
                        <th> later </th>
                        <th> manage </th>
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
