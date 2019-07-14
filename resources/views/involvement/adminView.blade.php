@extends('layouts.main')

@section('content')
<section class="card">
    <div class="card-block">
        <header class="card-header" style="border-bottom: 0">
            <div class="row">
                <h2 class="card-title">Involvement Events</h2>
                <div class="ml-auto" id="headerButtons">
                    <button type="button" class="btn btn-inline btn-primary" data-toggle="modal" data-target="#createNewEvent">Create New</button>
                </div>
            </div>
        </header>
        @include('partials.errors')
            <table id="table" class="display table table-bordered" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>Event</th>
                        <th>Point Value</th>
                        <th>Edit</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($events as $event)
                        <tr>
                            <td>{{$event->name}}</td>
                            <td>{{$event->points}}</td>
                            <td><button type="button" class="btn btn-inline btn-primary" data-toggle="modal" data-target="#editEvent{{$event->id}}">Edit</button></td>
                        </tr>

                        <!--.modal for Editing Event-->
                        <div class="modal fade" id="editEvent{{$event->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="modal-close" data-dismiss="modal" aria-label="Close">
                                                <i class="font-icon-close-2"></i>
                                            </button>
                                            <h4 class="modal-title" id="myModalLabel">Edit Event</h4>
                                        </div>
                                        <form method="POST" action="/involvement/{{$event->id}}/update" enctype="multipart/form-data" class="box" >
                                            @csrf
                                            @method('PATCH')
                                            <div class="modal-body">
                                                    <div class="form-group row">
                                                        <label for="name" class="col-md-3 col-form-label text-md-right">{{ __('Name:') }}</label>

                                                        <div class="col-md-9">
                                                            <input id="name" type="text" class="form-control " name="name" value="{{ $event->name }}" required autofocus>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label for="points" class="col-md-3 col-form-label text-md-right">{{ __('Point Value:') }}</label>

                                                        <div class="col-md-9">
                                                            <input id="points" type="text" class="form-control " name="points" value="{{ $event->points }}" required autofocus>
                                                        </div>
                                                    </div>
                                            </div>

                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-inline btn-default" data-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-inline btn-primary">Update</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div><!--.modal-->
                    @endforeach
                </tbody>
            </table>
        </div>

        <!--.modal for Creating New Events<-->
        <div class="modal fade" id="createNewEvent" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="modal-close" data-dismiss="modal" aria-label="Close">
                            <i class="font-icon-close-2"></i>
                        </button>
                        <h4 class="modal-title" id="myModalLabel">Create New Involvement Event</h4>
                    </div>
                    <form method="POST" action="/involvement" enctype="multipart/form-data" class="box" >
                        @csrf
                        <div class="modal-body">
                            <div class="col-md-12">
                                <div class="form-group row">
                                    <label for="name" class="col-md-3 col-form-label text-md-right">{{ __('Name') }}</label>

                                    <div class="col-md-9">
                                        <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="points" class="col-md-3 col-form-label text-md-right">{{ __('Point Value') }}</label>

                                    <div class="col-md-9">
                                        <input id="points" type="text" class="form-control" name="points" value="{{ old('points') }}" required autocomplete="points" autofocus>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-inline btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-inline btn-primary">Create</button>
                        </div>
                    </form>
                </div>
            </div>
        </div><!--.modal-->
    </section>

    @section('js')
    <script type="text/javascript" src="{{ asset('js/lib/datatables-net/datatables.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#table').DataTable({
                responsive: true
            })
        });
    </script>
    @endsection
@endsection
