@extends('layouts.main')

@section('content')
<div class="container">
    @include('partials.errors')

    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">{{ __('Edit Your Details') }}</div>
                <div class="card-body">
                <form method="POST" action="/users/update">
                        @csrf
                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Email') }}</label>

                            <div class="col-md-4">
                                <input id="email" type="text" class="form-control" name="email" value="{{ $user->email }}" required autocomplete="email" autofocus>
                            </div>

                        </div>

                        <div class="form-group row">
                            <label for="phone" class="col-md-4 col-form-label text-md-right">{{ __('Phone Number') }}</label>

                            <div class="col-md-4">
                                <input id="phone" type="text" class="form-control" name="phone" value="{{ $user->phone }}" required autocomplete="phone" autofocus>
                            </div>
                        </div>

                        <div class="form-group row mb-0">

                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Update Infromation') }}
                                </button>
                            </div>

                            <div class="col-md-6 offset-md-4">
                                <a href="/users/profile" id="cancel" name="cancel" class="btn btn-default">
                                    Cancel
                                </a>
                            </div>
                        </div>


                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

