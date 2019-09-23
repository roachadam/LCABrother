@extends('layouts.main')

@section('title', 'User Profile')

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

                    <div class="row justify-content-center">
                        <div class="btn-toolbar">
                            <button type="button" class="btn btn-inline btn-warning-outline" data-toggle="modal" data-target="#MakeAlumModal">Mark as Alumni</button>
                            @if (auth()->user()->organization->owner->id == auth()->user()->id)
                                <button type="button" class="btn btn-inline btn-warning-outline" data-toggle="modal" data-target="#ownerPassModal">Pass Ownership</button>

                                <div class="modal fade" id="ownerPassModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="modal-close" data-dismiss="modal" aria-label="Close">
                                                    <i class="font-icon-close-2"></i>
                                                </button>
                                                <h4 class="modal-title" id="myModalLabel">Make Owner</h4>
                                            </div>
                                            <form action="{{route('organization.passOwner', [auth()->user()->organization,$user])}}" method="POST" class="box" >
                                                <div class="modal-body">
                                                    @csrf
                                                    <div class="col-md-12">
                                                        <p>Are you sure you want to make {{ $user->name }} the owner  of {{ $user->organization->name }}?</p>
                                                    </div>
                                                </div>

                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-inline btn-default" data-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-inline btn-primary">Yes</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div><!--.modal-->
                            @endif

                            @if ($user->role->name !=='admin' && $user->id !== $user->organization->owner->id && auth()->user()->canManageMembers())
                                <button type="button" class="btn btn-inline btn-danger-outline" data-toggle="modal" data-target="#RemoveFromOrgModal">Remove From Organization</button>

                                <!--.modal for confirming deletion-->
                                <div class="modal fade" id="RemoveFromOrgModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="modal-close" data-dismiss="modal" aria-label="Close">
                                                    <i class="font-icon-close-2"></i>
                                                </button>
                                                <h4 class="modal-title" id="myModalLabel">Remove Member from Organization</h4>
                                            </div>
                                            <form action="/user/{{$user->id}}/organization/remove" method="POST" class="box" >
                                                <div class="modal-body">
                                                    @csrf
                                                    <div class="col-md-12">
                                                    <p>Are you sure you want to remove {{ $user->name }} from {{ $user->organization->name }}?</p>
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
                            @endif

                            @if ($user->id !== $user->organization->owner->id && (auth()->user()->id === 1 || auth()->user()->id === 4))
                                <button type="button" class="btn btn-inline btn-danger-outline" data-toggle="modal" data-target="#deleteUser">Delete User</button>

                                <!--.modal for confirming deletion-->
                                <div class="modal fade" id="deleteUser" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="modal-close" data-dismiss="modal" aria-label="Close">
                                                    <i class="font-icon-close-2"></i>
                                                </button>
                                                <h4 class="modal-title" id="myModalLabel">Delete User from Database</h4>
                                            </div>
                                            <form action={{route('user.destroy', $user)}} method="POST" class="box" >
                                                <div class="modal-body">
                                                    @csrf
                                                    @method('DELETE')
                                                    <div class="col-md-12">
                                                        <p>Are you sure you want to DELETE {{ $user->name }} from the database?</p>
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
                            @endif
                        </div>
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

    <!--.modal for confirming move to alumni-->
<div class="modal fade" id="MakeAlumModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="modal-close" data-dismiss="modal" aria-label="Close">
                    <i class="font-icon-close-2"></i>
                </button>
                <h4 class="modal-title" id="myModalLabel">Make Alumni</h4>
            </div>
            <form action="/user/{{$user->id}}/alumni" method="POST" class="box" >
                <div class="modal-body">
                    @csrf
                    <div class="col-md-12">
                        <p>Are you sure you want to make {{ $user->name }} an Alumni of {{ $user->organization->name }}?</p>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-inline btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-inline btn-primary">Yes</button>
                </div>
            </form>
        </div>
    </div>
</div><!--.modal-->
@endsection

@section('js')
    <script src="js/lib/bootstrap-sweetalert/sweetalert.min.js"></script>
@endsection

