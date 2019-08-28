@extends('layouts.main')

@section('css')
    <link href="{{ asset('css/separate/vendor/bootstrap-daterangepicker.min.css') }}" rel="stylesheet">
@endsection

@section('content')
<section class="card">
        <div class="card-block">
            <header class="card-header" style="border-bottom: 0">
                <div class="row">
                    <h2 class="card-title">{{$task->name}}</h2>
                        <div class="ml-auto" id="headerButtons">
                            {{-- @section('buttons')
                                <!--btn btn-inline-->
                                <button type="button" class="btn btn-inline btn-primary" data-toggle="modal" data-target="#createTask">Create Task</button>
                            @endsection --}}
                        </div>
                </div>
            </header>

            <p>Description: {{$task->description}}</p>
            <p>Deadline : {{$task->deadline}}</p>
        </div>
    {{-- </section>


    <section class="card">
            <div class="card-block">
                <header class="card-header" style="border-bottom: 0">
                    <div class="row">
                        <h2 class="card-title">Assigned Users</h2>
                    </div>
                </header> --}}

                <header class="card-header" style="border-bottom: 0">
                        <div class="row">
                            <h2 class="card-title">Assigned Users</h2>
                                
                        </div>
                    </header>
                <table id="table" class="display table table-bordered" cellspacing="0" width="100%">
                    <thead>
                            <th>Name</th>
                            <th>Completed</th>
                    </thead>
                    <tbody>
                        @foreach ($taskAssignments as $assignment)
                            <tr>
                                <td>{{$assignment->getMemberAssigned()->name}}</td>
                                @if ($assignment->completed == 1)
                                    <td>{{$assignment->updated_at}}</td>
                                @else
                                    <td>No</td>
                                @endif

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>

@endsection

{{--@section('tb')
    @foreach ($assigneeTasks as $tasks)
        <tr>
            <td>{{$tasks->name}}</td>
            <td>{{$tasks->description}}</td>
            <td>{{$tasks->deadline}}</td>
            <td>
                @foreach ($tasks->getAllUsersAssigned() as $assignedUser)
                    {{$assignedUser->name}}
                @endforeach
            </td>
            <td>{{$tasks->getCompletionRate()}}</td>
            <td>
                <form action="/tasks/{{$tasks->id}}/edit" method="GET">
                    @csrf
                    <button class="btn btn-inline btn-primary" type="submit">Manage Task</button>
                </form>
            </td>
        </tr>
    @endforeach
@endsection --}}


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
