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
                    <button type="button" class="btn btn-inline btn-danger-outline" data-toggle="modal" data-target="#deleteEvent">Delete</button>
                </div>
            </div>
        </header>

        <p>Description: {{$task->description}}</p>
        <p>Deadline : {{$task->deadline}}</p>


            <header class="card-header" style="border-bottom: 0">
                <div class="row">
                    <h3 class="card-title">Assigned Users</h3>
                    <div class="ml-auto" id="headerButtons">
                        <button type="button" class="btn btn-inline btn-primary-outline" data-toggle="modal" data-target="#editTask">Edit Users</button>
                    </div>
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
    </div>
</section>

    <!--.modal for Creating Task<-->
<div class="modal fade" id="deleteEvent" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="modal-close" data-dismiss="modal" aria-label="Close">
                    <i class="font-icon-close-2"></i>
                </button>
                <h4 class="modal-title" id="myModalLabel">Delete</h4>
            </div>
            <form action="/tasks/{{$task->id}}" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-body">
                    <div class="col-md-12">
                        <p>Are you sure you want to delete {{$task->name}}?</p>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-inline btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-inline btn-danger">Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>


<div class="modal fade" id="editTask" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="modal-close" data-dismiss="modal" aria-label="Close">
                    <i class="font-icon-close-2"></i>
                </button>
                <h4 class="modal-title" id="myModalLabel">Delete</h4>
            </div>
            <form action="/tasks/{{$task->id}}" method="post">
                @csrf
                @method('PATCH')
                <div class="modal-body">
                    <div class="row col-md-6">
                        <label for="assignedUsers" class="col-form-label text-md-right">Edit Assigned Members</label>
                        <div class="input-group">
                            @foreach (auth()->user()->organization->users as $user)
                            <div class="checkbox-toggle form-group">
                                    <input type="checkbox" value="{{$user->id}}" name="users[]" id="{{$user->id}}" {{$task->getAllUsersAssigned()->contains('id',$user->id) ? 'checked' : ''}}>
                                    <label for="{{$user->id}}">{{$user->name}}</label>
                            </div>
                            @endforeach
                        </div>
                    </div>


            </div>
            <div class="modal-footer">
                    <button type="button" class="btn btn-inline btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-inline btn-primary">Submit</button>
                </div>
            </form>

        </div>
    </div>
</div>

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
