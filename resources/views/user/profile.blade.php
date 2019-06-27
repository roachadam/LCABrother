@extends('layouts.main')


@section('content')


<div class="container">
    <div class="row justify-content-left">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">{{ __('Your Details') }}</div>

                <div class="card-body">
                    <div class="profile-header-img">
                        <img class="rounded-circle" src="/storage/avatars/{{ $user->avatar }}" height="150" width="150" margin="10px" />
                    </div>
                    <p>{{ $user->name }}</p>
                    <p>{{ $user->email }}</p>
                    <p>{{ $user->phone }}</p>

                    <div class="row justify-content-center">
                        <div class="btn-toolbar">
                            <a href="/users/edit" class="btn btn-inline">Edit Account</a>
                            <button type="button" class="btn btn-inline btn-danger" data-toggle="modal" data-target="#deleteAccountModal">Delete Account</button>
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
                                        <button type="submit" class="btn btn-inline btn-primary">Delete</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div><!--.modal-->
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
</div>


@endsection
