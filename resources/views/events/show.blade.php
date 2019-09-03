@extends('layouts.main')
@section('title', 'Event Details')
@section('content')

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/event">Events</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{$event->name}} Details</li>
    </ol>
</nav>

<div class="container">
    @include('partials.errors')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ $event->name }} Details</div>
                <div class="card-body">
                    <p>Date of Event: {{ \Carbon\Carbon::parse($event->date_of_event)->toDayDateTimeString() }}</p>
                    <p>Invites per member: {{ $event->num_invites }}</p>
                    <p>Total invites logged: {{ $event->getNumInvites() }}</p>
                </div>
            </div>
        </div>
    </div>

    <section class="card">
        <div class="card-block">
            <header class="card-header" style="border-bottom: 0">
                <div class="row">
                    <h4 class="card-title">Guest List</h4>
                    <div class="ml-auto" id="headerButtons">
                        <button type="button" class="btn btn-inline btn-primary-outline" data-toggle="modal" data-target="#editEventModal">Edit</button>

                        <button type="button" class="btn btn-inline btn-danger-outline" data-toggle="modal" data-target="#deleteEventModal">Delete Event</button>
                    </div>
                </div>
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

                            <!--.modal for confirming deletion of invite-->
                            <div class="modal fade" id="{{$invite->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="modal-close" data-dismiss="modal" aria-label="Close">
                                                <i class="font-icon-close-2"></i>
                                            </button>
                                            <h4 class="modal-title" id="myModalLabel">Delete</h4>
                                        </div>
                                        <form action={{route('invite.destroy', $invite)}} method="POST" class="box" >
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

        </div>
    </section>

<div class="modal fade" id="deleteEventModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="modal-close" data-dismiss="modal" aria-label="Close">
                    <i class="font-icon-close-2"></i>
                </button>
                <h4 class="modal-title" id="myModalLabel">Delete</h4>
            </div>
            <form action={{route('event.destroy', $event)}} method="POST" class="box" >
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

<div class="modal fade" id="editEventModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="modal-close" data-dismiss="modal" aria-label="Close">
                    <i class="font-icon-close-2"></i>
                </button>
                <h4 class="modal-title" id="myModalLabel">Edit {{$event->name}}</h4>
            </div>
            <form method="POST" action="/event/{{$event->id}}">
                <div class="modal-body">
                    @csrf
                    @method('PATCH')

                    <label for="name" class="col-form-label text-md-left">{{ __('Event Name') }}</label>
                    <div class="form-group row">
                        <div class="col-md-6">
                            <div class="form-control-wrapper form-control-icon-left offset-1">
                                <input id="name" type="text" class="form-control" name="name" value="{{ $event->name }}" required autocomplete="name" autofocus>
                                <i class="fa fa-pencil"></i>
                            </div>
                        </div>
                    </div>

                    <label for='date_of_event' class="col-form-label text-md-left">{{ __('Date of Event') }}</label>
                    <div class="form-group row">
                        <div class="col-md-6">
                            <div class="form-control-wrapper form-control-icon-left offset-1">
                                <input id="date_of_event" type="date" class="form-control" name="date_of_event" value="{{ \Carbon\Carbon::parse($event->date_of)->format('Y-m-d') }}" required autocomplete="date_of_event" autofocus>
                                <i class="fa fa-calendar"></i>
                            </div>
                        </div>
                    </div>

                    <label for='num_invites' class="col-form-label text-md-left">{{ __('# Of Invites Per Member') }}</label>
                    <div class="form-group row">
                        <div class="col-md-6">
                            <div class="form-control-wrapper form-control-icon-left offset-1">
                                <input id="num_invites" type="text" class="form-control " name="num_invites" value="{{ $event->num_invites }}" required autocomplete="num_invites" autofocus>
                                <i class="fa fa-users"></i>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="modal-footer">
                    <button type="button" class="btn btn-inline btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-inline btn-primary">Submit Changes</button>
                </div>
            </form>
        </div>
    </div>
</div><!--.modal-->

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
