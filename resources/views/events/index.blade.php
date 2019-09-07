@extends('layouts.main')
@section('title', 'Events')
@section('content')
    <section class="card">
        <div class="card-block">
            <header class="card-header" style="border-bottom: 0">
                <div class="row">
                    <h2 class="card-title">Events</h2>
                    <div class="ml-auto" id="headerButtons">
                        @if (auth()->user()->canManageEvents())
                            <button type="button" class="btn btn-inline btn-primary-outline" data-toggle="modal" data-target="#addEvent">Add Event</button>
                        @endif
                    </div>
                </div>
            </header>
            <table id="table" class="display table table-bordered" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>Event Name</th>
                        <th>Date</th>
                        <th>Invites per member</th>
                        <th>Your invites remaining</th>
                        <th>Submit Invitation</th>
                        <th>My Invites</th>
                        @if (auth()->user()->canManageEvents())
                            <th>Details</th>
                        @endif

                    </tr>
                </thead>
                <tbody>
                    @if ($events->count())
                        @foreach ($events as $event)
                        <tr>
                            <td>{{ $event->name }}</td>
                            <td> {{$event->date_of_event}} </td>
                            <td> {{$event->num_invites}} </td>
                            <td> {{auth()->user()->getInvitesRemaining($event)}} </td>
                            {{-- <td><a href={{route('invite.create', $event)}} class="btn btn-inline {{ auth()->user()->hasInvitesRemaining($event) ? '' : 'disabled' }} ">Invite</a></td> --}}
                            <td>
                                <button type="button" class="btn btn-inline" data-toggle="modal" data-target="#addInvite{{$event->id}}" {{ auth()->user()->hasInvitesRemaining($event) ? '' : 'disabled' }}>Invite Guest</button>
                            </td>
                            <td><a href={{route('invites.index', $event)}} class="btn btn-inline {{ auth()->user()->getInvitesRemaining($event) === $event->num_invites ? 'disabled' : '' }} ">View</a></td>
                            @if (auth()->user()->canManageEvents())

                                <td><a href="/event/{{$event->id}}" class="btn btn-inline">Show</a></td>
                            @endif

                        </tr>

                        <div class="modal fade" id="addInvite{{$event->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="modal-close" data-dismiss="modal" aria-label="Close">
                                            <i class="font-icon-close-2"></i>
                                        </button>
                                        <h4 class="modal-title" id="myModalLabel">Add Invite</h4>
                                    </div>
                                    <form method="POST" action={{route('invite.store', $event)}}>
                                        @csrf
                                        <div class="modal-body">

                                            <div class="form-group row"> {{-- Name --}}
                                                <label for="guest_name" class="col-md-4 col-form-label text-md-right">Guest Name</label>

                                                <div class="col-md-6">
                                                    <input id="guest_name" type="text" class="form-control " name="guest_name"  required autocomplete="guest_name" autofocus>
                                                </div>
                                            </div>


                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-inline btn-default" data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-inline btn-primary">Submit</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </section>



        <!--.modal for adding Events<-->
        <div class="modal fade" id="addEvent" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="modal-close" data-dismiss="modal" aria-label="Close">
                            <i class="font-icon-close-2"></i>
                        </button>
                        <h4 class="modal-title" id="myModalLabel">Add Event</h4>
                    </div>
                    <form method="POST" action={{route('event.store')}} enctype="multipart/form-data" class="box" >
                        @csrf
                        <div class="modal-body">
                            <div class="col-md-12">

                                <label for="name" class="col-form-label text-md-left">{{ __('Event Name') }}</label>
                                <div class="form-group row">
                                    <div class="col-md-6">
                                        <div class="form-control-wrapper form-control-icon-left offset-1">
                                            <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                                            <i class="fa fa-pencil"></i>
                                        </div>
                                    </div>
                                </div>

                                <label for='date_of_event' class="col-form-label text-md-left">{{ __('Date of Event') }}</label>
                                <div class="form-group row">
                                    <div class="col-md-6">
                                        <div class="form-control-wrapper form-control-icon-left offset-1">
                                            <input id="date_of_event" type="date" class="form-control" name="date_of_event" value="{{ old('name') }}" required autocomplete="date_of_event" autofocus>
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                    </div>
                                </div>

                                <label for='num_invites' class="col-form-label text-md-left">{{ __('# Of Invites Per Member') }}</label>
                                <div class="form-group row">
                                    <div class="col-md-6">
                                        <div class="form-control-wrapper form-control-icon-left offset-1">
                                            <input id="num_invites" type="text" class="form-control " name="num_invites" value="{{ old('num_invites') }}" required autocomplete="num_invites" autofocus>
                                            <i class="fa fa-users"></i>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-inline btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-inline btn-primary">Create</button>
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
                    responsive: true,
                    mobile: true
                });
            });
        </script>
    @endsection

@endsection
