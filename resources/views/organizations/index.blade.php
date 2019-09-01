@extends('layouts.theme')
@section('title', 'Choose Organization')

@section('content')
    <div class="auth__media">
        <img src="/img/home/ordinary.svg">
    </div>

    <div class="auth__auth">
        <h1 class="auth__title">Join Organization</h1>
        @include('partials.errors')
        <form method="POST" action={{route('user.joinOrg', auth()->user())}}>
            @csrf
            <label for="organization">Choose Your Organization</label>
            <select class="form-control m-bot15" name="organization">
                @foreach ($orgs as $org)
                    <option value="{{ $org->id }}">{{ $org->name }}</option>
                @endforeach
            </select>
            <button type="submit" class="button button__primary">Join Organization</button>
            <a href="/organization/create" class="button">Create a new Organization</a>
        </form>
    </div>
@endsection
