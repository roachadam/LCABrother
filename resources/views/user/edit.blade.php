@extends('layouts.main')

@section('content')
<div class="container">
    @include('partials.errors')
    <div class="row ">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    {{ __('Edit Your Details') }}

                </div>
                <div class="card-body">
                <form method="POST" action="/users/update">
                        @csrf
                        <div class="form-group">
                            <div class="row">
                                <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Email') }}</label>

                                <div class="col-md-6">
                                    <input id="email" type="text" class="form-control" name="email" value="{{ $user->email }}" required autocomplete="email" autofocus>
                                </div>
                            </div>

                            <div class="row">
                                <label for="phone" class="col-md-4 col-form-label text-md-right">{{ __('Phone Number') }}</label>

                                <div class="col-md-6">
                                    <input id="phone" type="text" class="form-control" name="phone" value="{{ $user->phone }}" required autocomplete="phone" autofocus>
                                </div>
                            </div>

                            {{-- need to center this according to the input boxes on the edit profile page @adam --}}
                            <div class="row">
                                <div class="btn-group">
                                    <button type="submit" class="btn btn-inline btn-primary">{{ __('Update Infromation') }}</button>                                    
                                    <a href="/users/profile" class="btn btn-inline btn-default" id="cancel" name="cancel">Cancel</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card d-flex">
                <div class="card-header">{{ __('Edit Your Avatar') }}</div>
                <div class="card-body align-items-center justify-content-center">
                    <div class="profile-header-container">
                        <div class="profile-header-img">
                            <img class="rounded-circle" src="/storage/avatars/{{ $user->avatar }}" height="150" width="150" />
                        </div>
                    </div>

                    <form action="/avatar/create" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <input type="file" class="form-control-file" name="avatar" id="avatarFile" aria-describedby="fileHelp">
                            <small id="fileHelp" class="form-text text-muted">Please upload a valid image file. Size of image should not be more than 2MB.</small>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>

                    <form method="POST" action="/avatar/default">
                        @csrf
                        <button type="submit" class="btn btn-primary">Reset to Default</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

