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
                        <td><button type="button" class="btn btn-inline btn-danger" data-toggle="modal" data-target="#{{$newsletter->id}}">Delete</button></td>
                    </tr>
                    <!--.modal for confirming deletion-->
                    <div class="modal fade" id="{{$newsletter->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="modal-close" data-dismiss="modal" aria-label="Close">
                                        <i class="font-icon-close-2"></i>
                                    </button>
                                    <h4 class="modal-title" id="myModalLabel">Delete New Letter</h4>
                                </div>
                                <form action="/newsletter/{{$newsletter->id}}" method="POST" class="box" >
                                    <div class="modal-body">
                                        @csrf
                                        @method('DELETE')
                                        <div class="col-md-12">
                                            <p>Are you sure you want to delete this news letter?</p>
                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-inline btn-default" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-inline btn-primary">Delete</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div><!--.modal-->
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

