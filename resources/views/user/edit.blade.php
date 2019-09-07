@extends('layouts.main')
@section('title', 'Edit Profile')
@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/dash">Dash</a></li>
        <li class="breadcrumb-item"><a href="/users/profile">Your Profile</a></li>
        <li class="breadcrumb-item active" aria-current="page">Edit Profile</li>
    </ol>
</nav>
<div class="container">
    @include('partials.errors')
    <div class="row ">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    {{ __('Edit Your Details') }}

                </div>
                <form method="POST" action="/users/update">
                    <div class="card-body">
                        @csrf
                        <div class="form-group">
                            <div class="row">
                                <label for="email" class="col-md-4 col-form-label">{{ __('Email') }}</label>

                                <div class="col-md-8">
                                    <input id="email" type="text" class="form-control" name="email" value="{{ $user->email }}" required autocomplete="email" autofocus>
                                </div>
                            </div>

                            <div class="row m-t-md">
                                <label for="phone" class="col-md-4 col-form-label">{{ __('Phone Number') }}</label>

                                <div class="col-md-8">
                                    <input id="phone" type="text" class="form-control" name="phone" value="{{ $user->phone }}" required autocomplete="phone" autofocus>
                                </div>
                            </div>

                            {{-- need to center this according to the input boxes on the edit profile page @adam --}}

                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-inline btn-primary-outline">{{ __('Update Infromation') }}</button>

                    </div>
                </form>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card d-flex">
                <div class="card-header">{{ __('Edit Your Avatar') }}</div>
                <div class="card-body align-items-center justify-content-center">
                    <div class="profile-header-container">
                        <div class="profile-header-img">
                            <img class="rounded-circle" src="/storage/avatars/{{ $user->avatar }}" height="150" width="150" />
                        </div>
                    </div>

                    <form id="form1" action="/avatar/create" method="post" enctype="multipart/form-data">@csrf</form>
                    <form id="form2" method="POST" action="/avatar/default">@csrf</form>

                    <div class="form-group">
                        <div class="custom-file col-md-8 m-t-md">
                            <input type="file" class="custom-file-input" id="customFile" name="avatar" aria-describedby="fileHelp" form="form1">
                            <label class="custom-file-label" for="customFile">Choose avatar</label>
                        </div>
                        <small id="fileHelp" class="form-text text-muted">Please upload a valid image file. Size of image should not be more than 2MB.</small>
                    </div>

                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary-outline" form="form1">Submit</button>

                    <button type="submit" class="btn btn-default-outline" form="form2">Reset to Default</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    $(".custom-file-input").on("change", function() {
        var fileName = $(this).val().split("\\").pop();
        $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
    });

</script>
@endsection

