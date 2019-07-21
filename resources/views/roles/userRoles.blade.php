@extends('layouts.main')
@section('title', 'Members in Role')
@section('content')
<section class="card">
    <div class="card-block">
        <header class="card-header" style="border-bottom: 0">
            <div class="row">
                <h2 class="card-title">Members in '{{$role->name}}' Role</h2>
                <div class="ml-auto" id="headerButtons">
                    <button type="button" class="btn btn-inline btn-primary" data-toggle="modal" data-target="#assignRoles">Assign Members</button>
                </div>
            </div>
        </header>
        @include('partials.errors')
            <table id="table" class="display table table-bordered" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Remove</th>
                </tr>
                </thead>
                <tbody>

                    @if ($usersWithRole->count())
                        @foreach ($usersWithRole as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td><button type="button" class="btn btn-inline btn-danger-outline" data-toggle="modal" data-target="#removeUserFromRole{{$user->id}}">Remove</button></td>
                            </tr>

                            <!--.modal for confirming removal of user from role-->
                            <div class="modal fade" id="removeUserFromRole{{$user->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="modal-close" data-dismiss="modal" aria-label="Close">
                                                <i class="font-icon-close-2"></i>
                                            </button>
                                            <h4 class="modal-title" id="myModalLabel">Remove User</h4>
                                        </div>
                                        <form action={{route('user.removeRole', $user)}} method="post" class="box" >
                                            <div class="modal-body">
                                                @csrf
                                                @method('PATCH')
                                                <div class="col-md-12">
                                                    <p>Are you sure you want to remove {{$role->name}} permissions from {{$user->name}}?</p>
                                                </div>
                                            </div>

                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-inline btn-default" data-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-inline btn-danger">Remove</button>
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


    <div class="modal fade" id="assignRoles" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="modal-close" data-dismiss="modal" aria-label="Close">
                        <i class="font-icon-close-2"></i>
                    </button>
                <h4 class="modal-title" id="myModalLabel">Assign Members to {{$role->name}}</h4>
                </div>
                <form method="POST" action="/role/{{$role->id}}/massSet" class="box" >
                    <div class="modal-body">
                        @csrf
                        <div class="col-md-12">


                            <fieldset>
                                @foreach ($usersWithoutRole as $otherUsers)
                                    <div class="checkbox-toggle form-group">
                                        <input type="checkbox" id={{$otherUsers->name}} name="users[]" value="{{$otherUsers->id}}">
                                        <label for={{$otherUsers->name}}>{{$otherUsers->name}}</label>
                                    </div>
                                @endforeach

                            </fieldset>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-inline btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-inline btn-primary">Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div><!--.modal-->

    @section('js')
        <script type="text/javascript" src="{{ asset('js/lib/datatables-net/datatables.min.js') }}"></script>
        <script>
            $(document).ready(function() {
                $('#table').DataTable({
                    "columnDefs": [
                        { "width": "94%", "targets": 0 },
                        {
                            "targets": 1,
                            "className": "text-center",
                        }
                    ],
                    responsive: true
                })
            });
        </script>
    @endsection
@endsection
