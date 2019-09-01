@extends('layouts.main')

@section('content')


<div class="container">
    <p>{{ $user->name }}  </p>
    <form method="POST" action="/orgpending/{{$user->id}}/update">
        @csrf

        <div class="checkbox-toggle">
            <input type="checkbox" id="organization_verified" name="organization_verified">
            <label for="organization_verified">Approve Member</label>
        </div>

        <button type="submit" class="btn btn-inline btn-primary">Submit</button>
    </form>
</div>
@endsection
