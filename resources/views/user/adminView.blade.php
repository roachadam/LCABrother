@extends('layouts.main')


@section('content')


<div class="container">
    <div class="row justify-content-left">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">{{$user->name}}'s Details</div>

                <div class="card-body">
                    <div class="profile-header-img">
                        <img class="rounded-circle" src="/storage/avatars/{{ $user->avatar }}" height="150" width="150" margin="10px" />
                    </div>
                    <p>{{ $user->name }}</p>
                    <p>{{ $user->email }}</p>
                    <p>{{ $user->phone }}</p>


                    @if ($user->role->name !=='admin'&& $user->id !== $user->organization->owner->id && auth()->user()->canManageMembers())
                        <div class="row">
                        <form action="/user/{{$user->id}}/organization/remove" method="POST">
                                @csrf
                                <div>
                                    <button class="btn btn-warning offset-4" onclick="return confirm('Are you sure?')" type="submit">Remove From Organization</button>
                                </div>
                            </form>
                        </div>
                    @endif
                    
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="row justify-content-left">
        <div class="col-md-5">
            <div class="card">
                <div class="card-header">Service Info</div>

                <div class="card-body">
                    <p>Hours Logged: {{ $user->getServiceHours() }} </p>
                    <p>Money Donated: {{ $user->getMoneyDonated() }} </p>
                </div>
            </div>
        </div>

        <div class="col-md-5">
            <div class="card">
                <div class="card-header">Involvement Info</div>

                <div class="card-body">
                    <p>Points Logged: {{ $user->getInvolvementPoints() }} </p>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
