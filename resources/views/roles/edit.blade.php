@extends('layouts.main')

@section('content')

{{-- {{dd(Session()->all())}} --}}
<form method="POST" action="/role/{{$role->id}}" class="box" >
        @csrf
        @method('PATCH')

        <h3>Edit {{$role->name}} Pemissions</h3>

        <label class="form-label semibold" for="exampleInput">Permissions</label>

        @foreach($permissionNames as $permission_name)
            <div class="checkbox-toggle form-group">
                <input type="checkbox" id={{$permission_name}} name={{$permission_name}} {{$role->permission->$permission_name ==1 ? 'checked' : ''}}>
                <label for={{$permission_name}}>{{ucwords(str_replace('_', ' ', $permission_name))}}</label>
            </div>
        @endforeach
        <button type="submit" class="btn btn-inline btn-primary">Edit</button>

</form>
<button type="button" class="btn btn-inline btn-outline-danger" data-toggle="modal" data-target="#deleteRoleModal" {{($role->name =='Admin' || $role->name =='Basic') ? 'disabled' : ''}}>Delete</button>

<!--.modal for notifying all memebrs-->
<div class="modal fade" id="deleteRoleModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="modal-close" data-dismiss="modal" aria-label="Close">
                        <i class="font-icon-close-2"></i>
                    </button>
                    <h4 class="modal-title" id="myModalLabel">Delete Role</h4>
                </div>
                <form action="/role/{{$role->id}}" method="post" class="box" >
                    <div class="modal-body">
                        @csrf
                        @method('delete')
                        <div class="col-md-12">
                            <p>Are you sure you want to delete this role?</p>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-inline btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-inline btn-danger">Delete</button>
                    </div>
                </form>
            </div>
        </div>
    </div><!--.modal-->

@endsection
