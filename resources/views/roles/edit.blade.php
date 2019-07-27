@extends('layouts.main')

@section('title', 'Edit Role Permissions')

@section('content')
    <div class="container">
        @include('partials.errors')
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <h5 class="card-title">{{ __('Edit ' . $role->name . ' Permissions') }}</h5>
                            <div class="ml-auto" id="headerButtons">
                                @if(!($role->name == 'Admin' || $role->name == 'Basic'))
                                    <button type="button" class="btn btn-inline btn-danger-outline" data-toggle="modal" data-target="#deleteRoleModal">Delete</button>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="post" action={{route('role.update', $role)}}>
                            @method('PATCH')
                            @csrf

                            <div class="form-body row offset-3">
                                <fieldset class="">
                                    @foreach($permissionNames as $permission_name)
                                        <div class="checkbox-toggle form-group">
                                            <input type="checkbox" id={{$permission_name}} name={{$permission_name}} {{$role->permission->$permission_name == 1 ? 'checked' : ''}}>
                                            <label for={{$permission_name}}>{{ucwords(str_replace('_', ' ', $permission_name))}}</label>
                                        </div>
                                    @endforeach
                                </fieldset>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="btn-group col-md-6 offset-md-7">
                                    <a href="/role" class="btn btn-inline btn-primary">Cancel</a>
                                    <button type="submit" class="btn btn-inline btn-primary">{{ __('Update') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--.modal for confirming delete-->
    <div class="modal fade" id="deleteRoleModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="modal-close" data-dismiss="modal" aria-label="Close">
                        <i class="font-icon-close-2"></i>
                    </button>
                    <h4 class="modal-title" id="myModalLabel">Delete Role</h4>
                </div>
                <form action={{route('role.destroy', $role)}} method="post" class="box" >
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
