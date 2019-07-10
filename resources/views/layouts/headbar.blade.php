<header class="site-header" id="header">
	    <div class="container-fluid">
            <a href="#" class="site-logo-text">ClubHouse</a>

	        {{-- <button id="show-hide-sidebar-toggle" class="show-hide-sidebar">
	            <span>toggle menu</span>
	        </button> --}}

	        <button class="hamburger hamburger--htla" class="show-hide-sidebar">
	            <span>toggle menu</span>
	        </button>
	        <div class="site-header-content">
	            <div class="site-header-content-in">
	                <div class="site-header-shown">
                        @if(Auth::user() !== null)
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



