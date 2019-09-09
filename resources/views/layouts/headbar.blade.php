<header class="site-header" id="header">
    <div class="container-fluid">
        <a href="/dash" class="site-logo-text">LCA</a>

        <button class="hamburger hamburger--htla" class="show-hide-sidebar">
            <span>toggle menu</span>
        </button>
        <div class="site-header-content">
            <div class="site-header-content-in">
                <div class="site-header-shown">
                    @if(!Auth::guest() && Auth::user()->organization)
                        <div class="dropdown dropdown-notification notif">
                            <a href="#"
                            class="header{{ Auth::user()->organization->users()->where('organization_verified',null)->get()->count() > 0 ? '-alarm' : '' }} dropdown-toggle active"
                            id="dd-notification"
                            data-toggle="dropdown"
                            aria-haspopup="true"
                            aria-expanded="false">
                                <i class="font-icon-alarm"></i>
                            </a>
                            {{-- Notifications --}}
                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-notif" aria-labelledby="dd-notification">
                                <div class="dropdown-menu-notif-header">
                                    Notifications
                                    <span class="label label-pill label-danger">{{Auth::user()->organization->users()->where('organization_verified',null)->get()->count()}}</span>
                                </div>
                                <div class="dropdown-menu-notif-list">
                                    @if (Auth::user()->canManageMembers())
                                        @foreach (Auth::user()->organization->users()->where('organization_verified',null)->get() as $member)
                                            <div class="dropdown-menu-notif-item">
                                                <div class="dot"></div>
                                                <a href="/orgpending/{{$member->id}}"> {{ $member->name }} </a> is waiting for verification
                                                <div class="color-blue-grey-lighter"> {{ $member->created_at }}</div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>

                        {{-- Account --}}
                        <div class="dropdown user-menu">
                            <button class="dropdown-toggle text-left" id="dd-user-menu" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
                                <img src="/storage/avatars/{{auth()->user()->avatar}}" alt="">

                            </button>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dd-user-menu">
                                <a class="dropdown-item" href="/users/profile"><span class="font-icon glyphicon glyphicon-user"></span>Profile</a>
                                <div class="dropdown-divider"></div>

                                <button type="button" class="dropdown-item" data-toggle="modal" data-target="#ReportBugModal"><span class="font-icon fas fa-bug"></span>Report a Bug</button>
                                <div class="dropdown-divider"></div>

                                <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                                    document.getElementById('logout-form').submit();">
                                        <span class="font-icon glyphicon glyphicon-log-out"></span>{{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </div>
                    @endif
                </div><!--.site-header-shown-->

            </div><!--site-header-content-in-->
        </div><!--.site-header-content-->
    </div><!--.container-fluid-->
</header><!--.site-header-->

<div class="modal fade" tabindex="-1" role="dialog" id="ReportBugModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Submit Bug Report</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method='POST' action="{{route('reportBug.send')}}" role="presentation" class="form">
                <div class="modal-body">
                    @csrf

                     <div class="col-md-12">
                        <div class="row col-md-12">
                            <label for="description" class="col-form-label text-md-right">What were you trying to do when bug occured</label>
                            <div class="input-group">
                                <textarea name="action" class="offset-1 form-control" id="description" cols="30" rows="5" placeholder="Attemping to submit service hours." required></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="row col-md-12">
                            <label for="description" class="col-form-label text-md-right">Bug Description</label>
                            <div class="input-group">
                                <textarea name="description" class="offset-1 form-control" id="description" cols="30" rows="5" placeholder="I got a 404 error when I clicked the submit button." required></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="row col-md-12">
                            <label for="name" class="col-form-label text-md-right">URL Where Bug Occured</label>
                            <div class="input-group">
                                <input class="offset-1 form-control" type="text" name="url" id='name' value="{{url()->current()}}" required>
                            </div>
                        </div>
                    </div>
                    <input type="text" hidden value="{{auth()->user()->id}}" name="user_id">
                    <input type="text" hidden value="{{auth()->user()->organization->id}}" name="org_id">
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-inline btn-default" data-dismiss="modal">Close</button>
                    <button type='submit' class="btn btn-inline btn-primary">Send Report</button>
                </div>
            </form>
        </div>
    </div>
</div>



