@extends('layouts.main')

@section('content')
@extends('partials.notifications')

    <header class="section-header">
        <div class="tbl">
            <div class="tbl-row">
                <div class="tbl-cell">
                    <h2>Academics</h2>
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
                    <th>Last Name</th>
                    <th>Cumulative GPA</th>
                    <th>Previous Term GPA</th>
                    <th>Current Term GPA</th>
                    <th>Previous Academic Standing</th>
                    <th>Current Academic Standing</th>
                    <th>Override</th>
                </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)

                        {{-- <td>{{ $user->name }}</td> --}}

                        @if ($user->academics->last() !== null)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->academics->last()->Cumulative_GPA }}</td>
                            <td>{{ $user->academics->last()->Previous_Term_GPA }}</td>
                            <td>{{ $user->academics->last()->Current_Term_GPA }}</td>
                            <td>{{ $user->academics->last()->Previous_Academic_Standing }}</td>
                            <td>{{ $user->academics->last()->Current_Academic_Standing }}</td>
                            <form action="/academics/user_id/{{ $user->academics->last()->id }}/edit" method="POST">
                                @csrf
                                <td><button type="submit" class="btn btn-inline">Override</button></td>
                            </form>
                        </tr>

                        @endif

                    @endforeach

                </tbody>
            </table>
            <form action="/academics/manage" method="GET">
                <button type="submit" class="btn btn-primary align-right">Manage</button>
            </form>
        </div>
    </section>

    @section('js')
    <script type="text/javascript" src="{{ asset('js/lib/datatables-net/datatables.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            // find full name, get surname and add it to table as second column
            $('#table td:first-child').each(function() {
                $('<td>'+$(this).text().split(' ')[1]+'</td>').insertAfter($(this));
            });
            // configure sorting
            $('#table').DataTable({
                'columnDefs': [
                {'orderData':[1], 'targets': [0]},
                {
                    'targets': [1],
                    'visible': false,
                    'searchable': false
                },
                ],
                responsive: true
            })
        });
    </script>
    @endsection
@endsection
