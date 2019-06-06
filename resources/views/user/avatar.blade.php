@extends('layouts.theme')
@section('title', 'Avatar')
@section('content')
<div class="auth__inner">
        <div class="auth__auth">
            <h1 class="auth__title">Add Avatar</h1>

            <div class="container">
                    @include('partials.errors')
                    <div class="row justify-content-center">

                        <div class="profile-header-container">
                            <div class="profile-header-img">
                                <img class="rounded-circle" src="/storage/avatars/{{ $user->avatar }}" height="150" width="150" />
                                <!-- badge -->
                                <div class="rank-label-container">
                                    <span class="label label-default rank-label">{{$user->name}}</span>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="row justify-content-center col-md-6">
                        <form action="/avatar/create" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <input type="file" class="form-control-file" name="avatar" id="avatarFile" aria-describedby="fileHelp">
                            </div>
                            <button type="submit" class="button button__primary">Submit</button>
                            <a href="/organization" class="button">Next</a>

                        </form>
                    </div>
                </div>
        </div>
        <div class="auth__media">
                <img src="/img/home/camera.svg">
            </div>
    </div>

@endsection
