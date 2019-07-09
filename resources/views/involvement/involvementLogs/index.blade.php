@extends('layouts.main')

@section('content')
<section class="card">
    <div class="card-block">
        <header class="card-header" style="border-bottom: 0">
            <div class="row">
                <h2 class="card-title">Involvement Points</h2>
                {{-- <div class="ml-auto" id="headerButtons">
                    This is where buttons should go if we need them
                </div> --}}
            </div>
        </header>
        <table id="table" class="display table table-bordered" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th>Name</th>
                <th>Points</th>
                @if (auth()->user()->canManageInvolvment())
                <th>View BreakDown</th>
                @endif
            </tr>
            </thead>
            <tbody>
                @forelse ($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td> {{ $user->getInvolvementPoints() }} </td>
                        @if (auth()->user()->canManageInvolvment())
                            <td><a href="/user/{{$user->id}}/involvementLogs" class="btn btn-inline">View</a></td>
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
