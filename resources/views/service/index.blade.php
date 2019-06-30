@extends('layouts.main')

@section('content')


    <header class="section-header">
            <div class="tbl">
                <div class="tbl-row">
                    <div class="tbl-cell">
                        <div class="row">
                            <h2>Service Events</h2>
                            <a href="/serviceEvents/indexByUser" class="btn btn-primary offset-8">View By Log</a>
                        </div>
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
                            <th>Date</th>
                            <th>Attendance</th>
                            @if (auth()->user()->canManageService())
                                <th>Manage</th>
                            @endif


                        </tr>
                    </thead>
                    <tbody>
                        @if ($serviceEvents->count())
                            @foreach ($serviceEvents as $serviceEvent)
                            <tr>
                                <td>{{ $serviceEvent->name }}</td>
                                <td> {{$serviceEvent->date_of_event}} </td>
                                <td> {{ $serviceEvent->getAttendance() }} </td>
                                @if (auth()->user()->canManageService())
                                    <td><a href="/serviceEvent/{{$serviceEvent->id}}" class="btn btn-primary">Manage</a></td>
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
				responsive: true
			});
		});
    </script>
@endsection
@endsection
