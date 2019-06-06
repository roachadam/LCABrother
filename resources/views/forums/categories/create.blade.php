@extends('layouts.theme')
@section('title', 'Create Forum')
@section('content')
    <div class="auth__media">
        <img src="/img/home/forum.svg">
    </div>
    <div class="auth__auth">
        <h1 class="auth__title">Set Forum Topics</h1>

        @if ($category->count())
            <h5>Current Categories:</h5>
            <ul>
                @foreach ($category as $cat)
                <div class="row offset-1">
                    <ol>
                    {{ $cat->name}}
                    </ol>
                </div>
                @endforeach
            </ul>
        @endif

        @include('partials.errors')
        <label>With this app, a forum is included. Please choose the topics that your members should be able to post under.</label>
        <label class="offset-1">Enter the names of the topics your members can post on the forum under.</label>
        <form method="POST" action="/forum/create/categories">
            @csrf

            <label>Name of Category</label>
            <input id="name" type="text" class="form-control " name="name" value="{{ old('name') }}" required autocomplete="service_hours_goal" autofocus>

            <button type="submit" class="button button__primary">Submit Categories </button>

            <a href="/massInvite" class="button">Next</a>

        </form>
    </div>
@endsection
