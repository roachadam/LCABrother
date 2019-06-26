@extends('layouts.main')

@section('content')
    <header class="section-header">
        <div class="tbl">
            <div class="tbl-row">
                <div class="tbl-cell">
                    <h2>Academic Standing Rules</h2>
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
                    <th>Term GPA Min</th>
                    <th>Cumulative GPA Min</th>
                    <th>Override</th>
                </tr>
                </thead>
                <tbody>
                    @foreach ($academicStandings as $academicStanding)
                        <tr>
                            <td>{{ $academicStanding->name }}</td>
                            <td>{{ $academicStanding->Term_GPA_Min }}</td>
                            <td>{{ $academicStanding->Cumulative_GPA_Min }}</td>
                            <td><a href="/academicStandings/{{$academicStanding->id}}/edit" class="btn btn-inline">Override</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{-- <p>TODO: fix this add more</p>
            <a href="/academicStandings/create" class="btn btn-primary align-right">Add more</a> --}}
        </div>
    </section>
@endsection
