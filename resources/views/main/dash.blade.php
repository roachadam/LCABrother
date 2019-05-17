@extends('layouts.main')



@section('notifications')
    @if (Auth::user()->canManageMembers())
        @foreach (Auth::user()->organization->users()->where('organization_verified',null)->get() as $member)
            <div class="dropdown-menu-notif-item">
                <div class="dot"></div>
                <a href="#">{{$member->name}}</a> is waiting for verification
                <div class="color-blue-grey-lighter">7 hours ago</div>
            </div>
        @endforeach
    @endif
@endsection

@section('content')

<div class="row">
    <div class="col-xl-6">

    </div><!--.col-->

</div><!--.row-->




@endsection
