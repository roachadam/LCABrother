@extends('layouts.main')

@section('content')


    <header class="section-header">
            <div class="tbl">
                <div class="tbl-row">
                    <div class="tbl-cell">
                        <h2>Academics</h2>
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
                    <th>Cumulative GPA</th>
                    <th>Previous Term GPA</th>
                    <th>Current Term GPA</th>
                    <th>Previous Academic Standing</th>
                    <th>Current Academic Standing</th>
                </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->latestAcademics->first()->Cumulative_GPA }}</td>
                        <td>{{ $user->latestAcademics->first()->Previous_Term_GPA }}</td>
                        <td>{{ $user->latestAcademics->first()->Current_Term_GPA }}</td>
                        <td>{{ $user->latestAcademics->first()->Previous_Academic_Standing }}</td>
                        <td>{{ $user->latestAcademics->first()->Current_Academic_Standing }}</td>
                    </tr>
                @endforeach
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
