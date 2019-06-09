<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>

	<script src="{{ asset('js/lib/jquery/jquery-3.2.1.min.js') }}"></script>
	<script src="{{ asset('js/lib/popper/popper.min.js') }}"></script>
    <script src="{{ asset('js/lib/bootstrap/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/lib/tether/tether.min.js') }}"></script>
	<script src="{{ asset('js/plugins.js') }}"></script>

	<script type="text/javascript" src="{{ asset('js/lib/jqueryui/jquery-ui.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('js/lib/lobipanel/lobipanel.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('js/lib/match-height/jquery.matchHeight.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('https://www.gstatic.com/charts/loader.js') }}"></script>

    <script type="text/javascript" src="{{ asset('js/lib/flatpickr/flatpickr.min.js') }}"></script>
    <script src="{{ asset('js/lib/daterangepicker/daterangepicker.js') }}"></script>
    <script src="http://demo.itsolutionstuff.com/plugin/jquery.js"></script>
    <script type="text/javascript" src="{{ asset("https://cdnjs.cloudflare.com/ajax/libs/bootstrap-notify/0.2.0/js/bootstrap-notify.js") }}"></script>

    <!-- Styles -->
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/lib/datatables-net/datatables.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/separate/vendor/datatables-net.min.css') }}" rel="stylesheet">

    {{-- Move these to appropriate page blades --}}
    <link rel="stylesheet" href="{{ asset('css/separate/vendor/bootstrap-daterangepicker.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/lib/lobipanel/lobipanel.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/separate/vendor/lobipanel.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/lib/jqueryui/jquery-ui.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/separate/pages/widgets.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/lib/font-awesome/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/lib/bootstrap/bootstrap.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/lib/flatpickr/flatpickr.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/separate/vendor/flatpickr.min.css') }}" rel="stylesheet">
    {{-- <link rel="stylesheet" href="http://demo.itsolutionstuff.com/plugin/bootstrap-3.min.css"> --}}

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset("https://cdnjs.cloudflare.com/ajax/libs/bootstrap-notify/0.2.0/css/bootstrap-notify.css") }}">
    @yield('css')
</head>
<body class="with-side-menu control-panel control-panel-compact">
    @include('partials.notifications')
	<header class="site-header">
	    <div class="container-fluid">
	        <a href="#" class="site-logo">
                <img class="hidden-md-down" src="/img/logo-2.png" alt="">
	        </a>

	        <button id="show-hide-sidebar-toggle" class="show-hide-sidebar">
	            <span>toggle menu</span>
	        </button>

	        <button class="hamburger hamburger--htla" class="show-hide-sidebar">
	            <span>toggle menu</span>
	        </button>
	        <div class="site-header-content">
	            <div class="site-header-content-in">
	                <div class="site-header-shown">
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
                                <img src="/storage/avatars/{{ auth()->user()->avatar }}" alt="">

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

	                    <button type="button" class="burger-right">
	                        <i class="font-icon-menu-addl"></i>
	                    </button>
	                </div><!--.site-header-shown-->

	            </div><!--site-header-content-in-->
	        </div><!--.site-header-content-->
	    </div><!--.container-fluid-->
	</header><!--.site-header-->

	<div class="mobile-menu-left-overlay"></div>
	@if (auth()->user()->isVerified())
        @include('layouts.sidebar')
    @endif

	<div class="page-content">
	    <div class="container-fluid">

                @yield('content')

	    </div><!--.container-fluid-->
    </div><!--.page-content-->
    @yield('js')
</body>
</html>
