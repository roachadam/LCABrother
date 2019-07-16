@extends('layouts.main')

@section('content')
    <section class="card">
        <div class="card-block">
            <header class="card-header" style="border-bottom: 0">
                <div class="row">
                    <h2 class="card-title">Events</h2>
                    <div class="ml-auto" id="headerButtons">
                        @if (auth()->user()->canManageEvents())
                            <a href="/event/create" class="btn btn-inline btn-primary">Add Event</a>
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
                            <td><a href="/event/{{$event->id}}/invite" class="btn btn-inline {{ auth()->user()->hasInvitesRemaining($event) ? '' : 'disabled' }} ">Invite</a></td>
                            <td><a href="/event/{{$event->id}}/invites" class="btn btn-inline {{ auth()->user()->getInvitesRemaining($event) === $event->num_invites ? 'disabled' : '' }} ">View</a></td>
                            @if (auth()->user()->canManageEvents())

                                <td><a href="/event/{{$event->id}}" class="btn btn-inline">Show</a></td>
                            @endif

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
                    responsive: true,
                    mobile: true
                });
            });
        </script>
    @endsection

@endsection
