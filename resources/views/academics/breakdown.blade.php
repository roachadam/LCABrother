@extends('layouts.main')
@section('title', 'Academic Breakdown')
@section('content')
    <section class="card">
        <div class="card-block">
            <header class="card-header" style="border-bottom: 0">
                <div class="row">
                    <h2 class="card-title">{{$user->name}}'s Academic Breakdown</h2>
                </div>
            </header>
            <table id="table" class="display table table-bordered" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>Cumulative GPA</th>
                            <th>Previous Term GPA</th>
                            <th>Current Term GPA</th>
                            <th>Previous Academic Standing</th>
                            <th>Current Academic Standing</th>
                            <th>Upload Date</th>
                        </tr>
                    </thead>

                    <tbody>
                        @if ($academics->isNotEmpty())
                            @foreach ($academics as $academic)
                                <tr>
                                    <td>{{$academic->Cumulative_GPA}}</td>
                                    <td>{{$academic->Previous_Term_GPA}}</td>
                                    <td>{{$academic->Current_Term_GPA}}</td>
                                    <td>{{$academic->Previous_Academic_Standing}}</td>
                                    <td>{{$academic->Current_Academic_Standing}}</td>
                                    <td>{{$academic->created_at}}</td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
            </table>
        </div>
    </section>
@endsection

@section('js')
    <script type="text/javascript" src="{{ asset('js/lib/datatables-net/datatables.min.js') }}"></script>
    <script>
            $(function() {
                $('#table').DataTable({
                    'order': [[ 5, 'desc' ]],
                    responsive: true
                });
            });
        </script>
@endsection

