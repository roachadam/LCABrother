
@extends('layouts.main')
@section('title', 'Academics')
@section('content')
<section class="card">
    <div class="card-block">
        <header class="card-header" style="border-bottom: 0">
            <div class="row">
                <h2 class="card-title">Academics</h2>
                <div class="ml-auto" id="headerButtons">
                    <a href="/academicStandings" class="btn btn-inline btn-secondary-outline">Academic Standing Rules</a>
                    <a href="/academics/manage" class="btn btn-inline btn-primary-outline">Manage</a>
                </div>
            </div>
        </header>
        @include('partials.errors')


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
                <th>Breakdown</th>
            </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    @if ($user->academics->last() !== null)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->academics->last()->Cumulative_GPA }}</td>
                            <td>{{ $user->academics->last()->Previous_Term_GPA }}</td>
                            <td>{{ $user->academics->last()->Current_Term_GPA }}</td>
                            <td>{{ str_replace('_', ' ', $user->academics->last()->Previous_Academic_Standing) }}</td>
                            <td>{{ str_replace('_', ' ', $user->academics->last()->Current_Academic_Standing) }}</td>
                            <td><a href={{route('academics.edit', $user->academics->last())}} class="btn btn-inline btn-primary">Override</a></td>
                            <td><a href={{route('academics.breakdown', $user)}} class="btn btn-inline btn-primary">Breakdown</a></td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>
</section>
@endsection

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
