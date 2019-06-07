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
            {{-- <div class="checkbox-toggle">
                <input type="checkbox" id={{"check-toggle-2"}} checked="">
                <label for="check-toggle-2">Toggle checked</label>
            </div> --}}
        @endforeach
        {{-- <div class="checkbox-toggle">
            <input type="checkbox" id={{"check-toggle-2"}} checked="">
            <label for="check-toggle-2">Toggle checked</label>
        </div> --}}

        <button type="submit" class="btn btn-inline btn-primary">Edit</button>

</form>

@endsection
