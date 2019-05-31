@extends('layouts.main')


@section('content')


<div class="container">
    <div class="row justify-content-left">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">{{ __('Your Details') }}</div>

                <div class="card-body">
                        <p>{{ $user->name }}</p>
                        <p>{{ $user->email }}</p>
                        <p>{{ $user->phone }}</p>

                        <div class="row">
                            <a href="/users/edit" class="btn btn-inline col-md-2 offset-4 ">Edit</a>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="row justify-content-left">
        <div class="col-md-5">
            <div class="card">
                <div class="card-header">{{ __('Your Service Info') }}</div>

                <div class="card-body">
                    <p>Hours Logged: {{ $user->getServiceHours() }} </p>
                </div>
            </div>
        </div>

        <div class="col-md-5">
            <div class="card">
                <div class="card-header">{{ __('Your Involvement Info') }}</div>

                <div class="card-body">
                    <p>Points Logged: {{ $user->getInvolvementPoints() }} </p>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
