@extends('layouts.main')
@section('title', 'Service Logs')
@section('content')

<section class="card">
    <div class="card-block">
        <header class="card-header" style="border-bottom: 0">
            <div class="row">
                <h2 class="card-title">{{ auth()->user()->organization->getActiveSemester()->semester_name }}: Service Logs</h2>
                <div class="ml-auto" id="headerButtons">
                    <a href="/users/{{auth()->user()->id}}/service" class="btn btn-inline btn-secondary-outline">View My Service Breakdown</a>
                    <a href="/serviceEvent" class="btn btn-inline btn-primary">View By Event</a>
                </div>
            </div>
        </header>
            <table id="table" class="display table table-bordered" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Service Hours</th>
                    <th>Money Donated</th>
                    @if(auth()->user()->canManageService())
                        <th>View</th>
                    @endif
                </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td> {{ $user->getserviceHours() }} </td>
                            <td>${{ $user->getMoneyDonated() }} </td>
                            @if(auth()->user()->canManageService())
                                <td><a href="/users/{{$user->id}}/service" class="btn btn-inline btn-primary">View</a></td>
                            @endif
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


