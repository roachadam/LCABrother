@extends('layouts.main')

@section('content')

<div class="container">
    @include('partials.errors')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ $event->name }} Details</div>
                <div class="card-body">
                    <p>Date of Event: {{ $event->date_of_event }}</p>
                    <p>Invites per member: {{ $event->num_invites }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

<header class="section-header">
        <div class="tbl">
            <div class="tbl-row">
                <div class="tbl-cell">
                    <h4>Guest List</h4>
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
                    <th>Brother Name</th>
                    <th>Guest Name</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
                @if ($invites->count())
                    @foreach ($invites as $invite)
                    <tr>
                        <td>{{ $invite->user->name }}</td>
                        <td> {{$invite->guest_name}} </td>
                        <td>
                            <form action="/invite/{{ $invite->id }}" method="POST">
                            @csrf
                            @method('DELETE')
                                <div>
                                    <button class="btn btn-inline" type="submit">Delete</button>
                                </div>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                @endif

            </tbody>
        </table>

        <div class="row">
            <a href="/event" class="btn btn-inline ">Return</a>
        </div>
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
