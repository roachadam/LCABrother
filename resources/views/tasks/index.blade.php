@extends('layouts.datatable')
@section('title', 'Tasks')

@section('css')
    <link href="{{ asset('css/separate/vendor/bootstrap-daterangepicker.min.css') }}" rel="stylesheet">
@endsection

@section('cardTitle', 'Tasks')

@section('buttons')
    <!--btn btn-inline-->
    <button type="button" class="btn btn-inline btn-primary" data-toggle="modal" data-target="#createTask">Create Task</button>
@endsection

@section('th')
    <th>Task Name</th>
    <th>Description</th>
    <th>Created By</th>
    <th>Assign Users</th>
    <th>View</th>
@endsection


@section('tb')
    @foreach ($tasks as $task)
        <tr>
            <td>{{$task->name}}</td>
            <td>{{$task->description}}</td>
            <td>{{$task->user->name}}</td>
            {{-- <td>{{$task->Assign}}</td> --}}
            <td>View</td>   <!--button-->
        </tr>
    @endforeach
@endsection

@section('modals')
    <!--.modal for Creating Task<-->
    <div class="modal fade" id="createTask" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="modal-close" data-dismiss="modal" aria-label="Close">
                        <i class="font-icon-close-2"></i>
                    </button>
                    <h4 class="modal-title" id="myModalLabel">Create Task</h4>
                </div>
                <form method="POST" action={{route('tasks.store')}} enctype="multipart/form-data" class="box" >
                    @csrf
                    <div class="modal-body">
                            <div class="col-md-12">
                                    <div class="row col-md-6">
                                        <label for="name" class="col-form-label text-md-right">Task Name</label>

                                        <div class="input-group">
                                            <input id="name" type="text" class="form-control" name="name">
                                        </div>
                                    </div>

                                    <div class="row col-md-6">
                                        <label for="description" class="col-form-label text-md-right">Description</label>

                                        <div class="input-group">
                                            <input id="description" type="text" class="form-control" name="description">
                                        </div>
                                    </div>

                                    <div class="row m-t-md col-md-6">
                                        <label for='deadline'>Deadline</label>

                                        <div class='input-group date'>
                                            <div class="form-control-wrapper form-control-icon-left">
                                                <input id="deadline" type="text" class="form-control" name="deadline">
                                                <i class="fa fa-calendar "></i>
                                            </div>
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
@endsection


@section('js')
    <script type="text/javascript" src="{{ asset('js/lib/datatables-net/datatables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/lib/moment/moment-with-locales.min.js') }}"></script>
    <script src="{{ asset('js/lib/daterangepicker/daterangepicker.js') }}"></script>
    <script>
        $(function() {
            $('#table').DataTable({
                responsive: true
            });

            $('#deadline').daterangepicker({
                singleDatePicker: true,
                showDropdowns: true
            });
        });
    </script>
@endsection
