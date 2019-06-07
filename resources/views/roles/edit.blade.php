@extends('main.dash')

@section('content')

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
<form action="/role/{{$role->id}}" method="POST">
    @csrf
    @method('DELETE')

    <button type="submit" class="btn btn-inline btn-warning" onclick="return confirm('Are you sure?')" {{($role->name =='Admin' || $role->name =='Basic') ? 'disabled' : ''}}>Delete</button>

</form>

@endsection
