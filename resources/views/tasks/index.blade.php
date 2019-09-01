@extends('layouts.main')


@section('title', 'Tasks')

@section('css')
    <link href="{{ asset('css/separate/vendor/bootstrap-daterangepicker.min.css') }}" rel="stylesheet">
@endsection
@section('content')
@include('partials.errors')

<section class="card">
    <div class="card-block">
        <header class="card-header" style="border-bottom: 0">
            <div class="row">
                <h2 class="card-title">My Incomplete Tasks</h2>
                <div class="ml-auto" id="headerButtons">
                    <button type="button" class="btn btn-inline btn-primary-outline" data-toggle="modal" data-target="#createTask">Create Task</button>
                </div>
            </div>
        </header>

        <table id="table" class="display table table-bordered" cellspacing="0" width="100%">
            <thead>
                <th>Task Name</th>
                <th>Description</th>
                <th>Assigned by</th>
                <th>Completed</th>
            </thead>
            <tbody>
                @foreach ($incompleteTasks as $taskAssignments)
                    <tr>
                        <td>{{$taskAssignments->tasks->name}}</td>
                        <td>{{$taskAssignments->tasks->description}}</td>
                        <td>{{$taskAssignments->getAssignedBy()->name}}</td>
                        <td>
                            <form action={{route('taskAssignments.complete', $taskAssignments)}} method="post">
                                @csrf
                                <button class="btn btn-inline btn-primary-outline" type="submit">Complete Task</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</section>

<section class="card">
    <div class="card-block">
        <header class="card-header" style="border-bottom: 0">
            <div class="row">
                <h2 class="card-title">My Complete Tasks</h2>
                <div class="ml-auto" id="headerButtons">
                </div>
            </div>
        </header>

        <table id="table3" class="display table table-bordered" cellspacing="0" width="100%">
            <thead>
                <th>Task Name</th>
                <th>Description</th>
                <th>Assigned by</th>
                <th>Date Completed</th>
            </thead>
            <tbody>
                @foreach ($completeTasks as $taskAssignments)
                    <tr>
                        <td>{{$taskAssignments->tasks->name}}</td>
                        <td>{{$taskAssignments->tasks->description}}</td>
                        <td>{{$taskAssignments->getAssignedBy()->name}}</td>
                        <td>{{$taskAssignments->updated_at}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</section>

<section class="card">
    <div class="card-block">
        <header class="card-header" style="border-bottom: 0">
            <div class="row">
                <h2 class="card-title">Tasks I assigned</h2>

            </div>
        </header>

        <table id="table2" class="display table table-bordered" cellspacing="0" width="100%">
            <thead>
                    <th>Task Name</th>
                    <th>Description</th>
                    <th>Deadline</th>
                    <th>Members Assigned</th>
                    <th>Completion Rate</th>
                    <th>Manage</th>
            </thead>
            <tbody>
                @foreach ($tasks as $tasks)
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
                        <td><a href={{route('tasks.edit', $tasks)}} class="btn btn-primary-outline">Manage</a></td>

                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</section>

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

                        <div class="row m-t-md col-md-6">
                            <label for="assignedUsers" class="col-form-label text-md-right">Assign Members</label>
                            <div class="input-group">
                                @foreach (auth()->user()->organization->users as $user)
                                <div class="checkbox-toggle form-group">
                                    <input type="checkbox" value="{{$user->id}}" name="users[]" id="{{$user->id}}">
                                    <label for="{{$user->id}}">{{$user->name}}</label>
                                </div>
                                @endforeach
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

            $('#table2').DataTable({
                responsive: true
            });
            $('#table3').DataTable({
                responsive: true
            });
            $('#deadline').daterangepicker({
                singleDatePicker: true,
                showDropdowns: true
            });
        });
    </script>
@endsection
