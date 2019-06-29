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
                    <p>Total invites logged: {{ $event->getNumInvites() }}</p>
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
                            <td><button type="button" class="btn btn-inline btn-danger-outline" data-toggle="modal" data-target="#{{$invite->id}}">Delete</button></td>
                        </tr>

                        <!--.modal for confirming deletion-->
                        <div class="modal fade" id="{{$invite->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="modal-close" data-dismiss="modal" aria-label="Close">
                                            <i class="font-icon-close-2"></i>
                                        </button>
                                        <h4 class="modal-title" id="myModalLabel">Delete</h4>
                                    </div>
                                    <form action="/invite/{{ $invite->id }}" method="POST" class="box" >
                                        <div class="modal-body">
                                            @csrf
                                            @method('DELETE')
                                            <div class="col-md-12">
                                                <p>Are you sure you want to delete this guest?</p>
                                            </div>
                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-inline btn-default" data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-inline btn-danger">Delete</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div><!--.modal-->


                    @endforeach
                @endif

            </tbody>
        </table>

        <div class="row">
            <a href="/event" class="btn btn-inline ">Return</a>
            <a href="/event/{{ $event->id }}/edit" class="btn btn-inline ">Edit</a>
            <button type="button" class="btn btn-inline btn-danger-outline" data-toggle="modal" data-target="#deleteEventModal">Delete Event</button>

            <!--.modal for confirming deletion-->
            <div class="modal fade" id="deleteEventModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="modal-close" data-dismiss="modal" aria-label="Close">
                                <i class="font-icon-close-2"></i>
                            </button>
                            <h4 class="modal-title" id="myModalLabel">Delete</h4>
                        </div>
                        <form action="/event/{{ $event->id }}" method="POST" class="box" >
                            <div class="modal-body">
                                @csrf
                                @method('DELETE')
                                <div class="col-md-12">
                                    <p>Are you sure you want to delete this event?</p>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-inline btn-default" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-inline btn-danger">Delete</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div><!--.modal-->

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
