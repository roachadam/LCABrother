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
                            <div class="form-group" style=" padding-top: 12px;">
                                <input type="file" class="form-control-file" name="avatar" id="avatarFile" aria-describedby="fileHelp">
                            </div>

                            {{-- <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="inputGroupFileAddon01">Upload</span>
                                </div>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="avatarFile" name="avatar"
                                    aria-describedby="inputGroupFileAddon01">
                                    <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                                </div>
                            </div> --}}


                            <div style=" padding-top: 25px;">
                                <button type="submit" class="button button__primary ">Submit</button>
                                <a href="/organization" class="button">Skip</a>
                            </div>

                        </form>
                    </div>
                </div>
        </div>
        <div class="auth__media">
            <img src="/img/home/camera.svg">
        </div>
    </div>

@endsection
