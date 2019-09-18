@extends('layouts.main')
@section('title', 'Profile')
@section('content')
<nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/dash">Dash</a></li>
            <li class="breadcrumb-item active" aria-current="page">Your Profile</li>
        </ol>
    </nav>

<div class="card">
    <div class="card-header"><h3>Your Details</h3></div>
    <div class="card-block">
        <div class="row">
            <div class="col-md-6">
                <div class="profile-header-img">
                    <img class="rounded-circle" src="/storage/avatars/{{ $user->avatar }}" height="150" width="150" margin="10px" />
                </div>
                <div class="m-t-md">
                    @if(isset($user->zeta_number))
                        <p><strong>Zeta Number: </strong> ΙΩ {{ $user->zeta_number }}</p>
                    @endif
                    <p><strong>Name: </strong> {{ $user->name }}</p>
                    <p><strong>Email: </strong> {{ $user->email }}</p>
                    <p><strong>Phone: </strong> {{ $user->phone }}</p>
                    <p><strong>Major: </strong> {{ $user->major }}</p>
                </div>

                <a href="/users/edit" class="btn btn-inline">Edit Account</a>
                <button type="button" class="btn btn-inline btn-danger-outline" data-toggle="modal" data-target="#deleteAccountModal">Delete Account</button>
            </div>

            <div class="col-md-3">
                    <strong>Your Service Info</strong>
                    <p>Hours Logged: {{ $user->getServiceHours() }} </p>
                    <p>Money Donated: {{ $user->getMoneyDonated() }} </p>

                    <strong>Involvement Info</strong>
                    <p>Points Logged: {{ $user->getInvolvementPoints() }} </p>
            </div>

        </div>
    </div>
</div>



<!--.modal for confirming deletion-->
<div class="modal fade" id="deleteAccountModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="modal-close" data-dismiss="modal" aria-label="Close">
                        <i class="font-icon-close-2"></i>
                    </button>
                    <h4 class="modal-title" id="myModalLabel">Delete Account</h4>
                </div>
                <form action="/user/{{ auth()->user()->id }}" method="POST" class="box" >
                    <div class="modal-body">
                        @csrf
                        @method('DELETE')
                        <div class="col-md-12">
                            <p>Are you sure you want to delete your account?</p>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-inline btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-inline btn-danger">Delete</button>
                    </div>
                </form>
            </div>
        </div>
    </div><!--.modal-->

{{-- <div class="container">
    <div class="row justify-content-left">
        <div class="col-md-5">
            <div class="card">
                <div class="card-header">{{ __('Your Service Info') }}</div>

                <div class="card-body">
                    <p>Hours Logged: {{ $user->getServiceHours() }} </p>
                    <p>Money Donated: {{ $user->getMoneyDonated() }} </p>
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
</div> --}}


@endsection
