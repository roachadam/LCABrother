@extends('layouts.main')

@section('content')
    <header class="section-header">
                <div class="tbl">
                    <div class="tbl-row">
                        <div class="tbl-cell">
                            <h2>Alumni</h2>
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
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Alumniship Date</th>
                        <th>Manage</th>
                    </tr>
                    </thead>
                    <tbody>

                        @if ($alumni->count())
                            @foreach ($alumni as $alum)
                            <tr>
                                <td>{{ $alum->name }}</td>
                                <td>{{ $alum->phone }}</td>
                                <td>{{ $alum->email  }}</td>
                                <td>{{ $alum->updated_at  }}</td>
                                @if (auth()->user()->canManageMembers())
                                    <form action="/user/{{$alum->id}}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                    <td><button type="submit" class="btn btn-warning" onclick="return confirm('Are you sure?')">Delete</button></td>
                                    </form>
                                @endif
                            </tr>
                            @endforeach
                        @endif

                    </tbody>
                </table>
                <a href="/alumni/contact" class="btn btn-primary">Contact Alumni</a>
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


