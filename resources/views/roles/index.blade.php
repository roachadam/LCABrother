@extends('main.dash')

@section('content')

<header class="section-header">
        <div class="tbl">
            <div class="tbl-row">
                <div class="tbl-cell">
                    <h2>Roles</h2>
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
                <th>View Members In Role </th>
                <th>Manage</th>
            </tr>
            </thead>
            <tbody>

                @if ($roles->count())
                    @foreach ($roles as $role)
                        <tr>
                            <td>{{ $role->name }}</td>
                            <td><a href="/role/{{$role->id}}/users" class="btn btn-inline">View</a></td>
                            <td><a href="/role/{{$role->id}}/edit" class="btn btn-inline">Edit</a></td>
                        </tr>
                    @endforeach
                @endif

            </tbody>

        </table>
        {{-- todo: fix alignment --}}
        <button type="button" class="btn btn-inline btn-primary" data-toggle="modal" data-target="#addRole">
                Add Role
        </button>
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
                <form method="POST" action="/organizations/{{ $org->id }}/roles" class="box" >
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
                                        <input type="checkbox" id={{$permission_name}} name={{$permission_name}} {{$role->permission->$permission_name ==1 ? 'checked' : ''}}>
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
