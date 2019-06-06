@extends('layouts.theme')
@section('title', 'Create Org')
@section('content')

    <div class="auth__media">
        <img src="/img/home/org.svg">
    </div>

    <div class="auth__auth">
        <h1 class="auth__title">Join Organization</h1>
        @include('partials.errors')
        <form method="POST" action="/organization">
            @csrf

            <label>Name</label>
            <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

            <button type="submit" class="btn btn-primary">Create Organization</button>
        </form>
    </div>


@endsection
