@extends('layouts.main')

@section('title', 'Roles')

@section('content')
<section class="card">
    <div class="card-block">
        <header class="card-header" style="border-bottom: 0">
            <div class="row">
                <h2 class="card-title">Roles</h2>
                <div class="ml-auto" id="headerButtons">
                    <button type="button" class="btn btn-inline btn-primary" data-toggle="modal" data-target="#addRole">Add Role</button>
                </div>
            </div>
        </header>
        @include('partials.errors')
        <table id="table" class="display table table-bordered table-xs" width="100%">
            <thead>
            <tr>
                <th>Name</th>
                <th>View Members In Role </th>
                <th>Manage</th>
            </tr>
            </thead>
            <tbody>

                @if ($roles->count())
                    @foreach ($roles as $role)
                        <tr>
                            <td>{{ $role->name }}</td>
                            <td><a href={{route('role.usersInRole', $role)}} class="btn btn-inline">View</a></td>
                            <td><a href={{route('role.edit', $role)}} class="btn btn-inline {{$role->name == 'Admin' ? 'disabled' : ''}}" > Edit</a></td>
                        </tr>
                    @endforeach
                @endif

            </tbody>

        </table>
    </div>
    <div class="modal fade"
        id="addRole"
        tabindex="-1"
        role="dialog"
        aria-labelledby="myModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="modal-close" data-dismiss="modal" aria-label="Close">
                        <i class="font-icon-close-2"></i>
                    </button>
                    <h4 class="modal-title" id="myModalLabel">Add Role</h4>
                </div>
                <form method="POST" action={{route('role.store')}} class="box" >
                    <div class="modal-body">
                        @csrf
                        <div class="col-md-12">
                            <fieldset class="form-group">
                                <label class="form-label semibold" for="name">Role Name</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="President" required>
                            </fieldset>

                            <label class="form-label semibold" for="exampleInput">Permissions</label>

                            <fieldset>
                                {{-- edit member details --}}
                                @foreach($permissionNames as $permission_name)
                                    <div class="checkbox-toggle form-group">
                                        <input type="checkbox" id={{$permission_name}} name={{$permission_name}} {{$role->permission->$permission_name == 1 ? 'checked' : ''}}>
                                        <label for={{$permission_name}}>{{ucwords(str_replace('_', ' ', $permission_name))}}</label>
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
