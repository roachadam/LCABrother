@extends('layouts.main')

@section('content')
    <div class="card">
        <div class="card-header">{{$calendarItem->name}}</div>
        <div class="card-body">

        <div class="offset-1">
            <p> Description : {{$calendarItem->description}} </p>
            @if ($calendarItem->end_date != $calendarItem->start_date)
                <p>Start Date : {{$calendarItem->start_date}}</p>
                <p>End Date : {{$calendarItem->end_date}}</p>
            @else
                <p>Date : {{$calendarItem->start_date}}</p>
            @endif
        </div>

        @if ($calendarItem->hasEvent() && auth()->user()->canManageEvents())
            <header class="section-header">
                <div class="tbl m-t-md">
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


            </div>
            </section>
            <div class="row">
                    <a href="/event/{{ $event->id }}/edit" class="btn btn-inline ">Edit</a>
                </div>
        @endif
        @if (auth()->user()->canManageEvents())
            <div class="row m-t-md">
                <form method="POST" action="/calendarItem/{{ $calendarItem->id }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-warning">Delete</button>
                </form>
            </div>
        @endif

    </div>
</div>

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