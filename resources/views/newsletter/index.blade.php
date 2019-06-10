@extends('layouts.main')

@section('content')
<header class="section-header">
        <div class="tbl">
            <div class="tbl-row">
                <div class="tbl-cell">
                    <h2>Newsletters</h2>
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
                <th>Last Contacted</th>
                <th>View Subscribers</th>
                <th>Manage</th>
            </tr>
            </thead>
            <tbody>

                @if ($newsletters->count())
                    @foreach ($newsletters as $newsletter)
                    <tr>
                        <td>{{ $newsletter->name }}</td>
                        <td>{{ $newsletter->last_email_sent  }}</td>
                        <td><a href="/newsletter/{{$newsletter->id}}/subscribers" class="btn btn-inline">View</a></td>
                        <td><a href="/newsletter/{{$newsletter->id}}/edit" class="btn btn-inline">Manage</a></td>
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

