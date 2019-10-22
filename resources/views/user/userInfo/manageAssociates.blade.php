@extends('layouts.main')
@section('title', 'Members')
@section('content')
<section class="card">
    <div class="card-block">
        <header class="card-header" style="border-bottom: 0">
            <div class="row">
                <h2 class="card-title">Manage Associates</h2>
                <div class="ml-auto" id="headerButtons">
                    <button type="button" class="btn btn-inline btn-primary-outline" data-toggle="modal" data-target="#allActive">Mark all as Active</button>
                </div>
            </div>
        </header>
        <table id="table" class="display table table-bordered" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th>Name</th>
                <th>Role</th>
                <th>Service Hours</th>
                <th>Money Donated</th>
                <th>Make Active</th>
                <th>Manage</th>
            </tr>
            </thead>
            <tbody>

                @if ($associates->isNotEmpty())
                    @foreach ($associates as $associate)
                    <tr>
                        <td>{{ $associate->name }}</td>
                        <td>Associate</td>
                        <td> {{ $associate->getserviceHours() }} </td>
                        <td>$ {{ $associate->getMoneyDonated() }} </td>
                        <td><button type="button" class="btn btn-inline btn-primary-outline" data-toggle="modal" data-target="#active">Mark as Active</button></td>
                        <td><a href="/users/{{$associate->id}}/adminView" class="btn btn-inline">Manage</a></td>
                    </tr>

                    <div class="modal fade" id="active" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="modal-close" data-dismiss="modal" aria-label="Close">
                                        <i class="font-icon-close-2"></i>
                                    </button>
                                    <h4 class="modal-title" id="myModalLabel">Mark Associate as Active</h4>
                                </div>
                                <form action={{route('markAssociateAsActive', $associate)}} method="POST" class="box" >
                                    <div class="modal-body">
                                        @csrf
                                        <div class="col-md-12">
                                            <p>Are you sure you want to mark {{$associate->name}} as an active?</p>
                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-inline btn-default" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-inline btn-danger">Yes</button>
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


<div class="modal fade" id="allActive" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="modal-close" data-dismiss="modal" aria-label="Close">
                    <i class="font-icon-close-2"></i>
                </button>
                <h4 class="modal-title" id="myModalLabel">Mark all Associates as Active</h4>
            </div>
            <form action={{route('markAllAssociatesAsActives')}} method="POST" class="box" >
                <div class="modal-body">
                    @csrf
                    <div class="col-md-12">
                        <p>Are you sure you want to mark all Associates as Actives?</p>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-inline btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-inline btn-danger">Yes</button>
                </div>
            </form>
        </div>
    </div>
</div><!--.modal-->


    @section('js')
        <script type="text/javascript" src="{{ asset('js/lib/datatables-net/datatables.min.js') }}"></script>
        <script>
            $(function() {
                $('#table').DataTable({
                    responsive: true,
                    pageLength: 25
                });
            });
        </script>
    @endsection
@endsection
