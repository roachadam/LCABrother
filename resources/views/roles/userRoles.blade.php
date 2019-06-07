
@extends('layouts.main')
@section('content')
<div class="card">
<div class="card-header">Users in {{$role->name}}Role</div>
    <div class="card-body">
        <table id="table" class="display table table-bordered" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th>Name</th>
            </tr>
            </thead>
            <tbody>

                @if ($users->count())
                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                        </tr>
                    @endforeach
                @endif

            </tbody>

        </table>
    </div>
</div>


<button type="button" class="btn btn-inline btn-primary" data-toggle="modal" data-target="#assignRoles">
    Assign Users
</button>
</div>
<div class="modal fade"
id="assignRoles"
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
    <h4 class="modal-title" id="myModalLabel">Assign Users to {{$role->name}}</h4>
    </div>
    <form method="POST" action="/role/{{$role->id}}/massSet" class="box" >
        <div class="modal-body">
            @csrf
            <div class="col-md-12">


                <fieldset>
                    @foreach ($others as $other)
                        <div class="checkbox-toggle form-group">
                            <input type="checkbox" id={{$other->name}} name="users[]" value="{{$other->id}}">
                            <label for={{$other->name}}>{{$other->name}}</label>
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
@endsection
