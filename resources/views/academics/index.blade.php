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
                        @if ($user->latestAcademics() !== null)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->latestAcademics()->Cumulative_GPA }}</td>
                            <td>{{ $user->latestAcademics()->Previous_Term_GPA }}</td>
                            <td>{{ $user->latestAcademics()->Current_Term_GPA }}</td>
                            <td>{{ $user->latestAcademics()->Previous_Academic_Standing }}</td>
                            <td>{{ $user->latestAcademics()->Current_Academic_Standing }}</td>
                            <form action="/academics/user_id/{{ $user->latestAcademics()->id }}/edit" method="POST">
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
            $(function() {
                $('#table').DataTable({
                    responsive: true
                });
            });
    </script>
    @endsection
@endsection
