<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Scripts -->
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

        <link rel="stylesheet" type="text/css" href="{{ asset("https://cdnjs.cloudflare.com/ajax/libs/bootstrap-notify/0.2.0/css/bootstrap-notify.css") }}">
        @yield('css')
            <style>
                #header {
                    position: fixed;
                    z-index: 100;
                    width: 100%;
                    background-color: #6C63FF;
                    transition: 0.7s;
                }
                .navbar--nofixed {
                    position: relative;
                    z-index: 3;
                }
                #logoId {
                    font-size: 1.325rem;
                    transition: 0;
                    color: #fff;
                    text-decoration: none;
                }
                html body {
                    font-family: "Lato", sans-serif;
                }
                #sidebarId {
                    background-color: rgb(51,60,68);
                }
                #sidebarId .lbl {
                    color: azure;
                }
            </style>
    </head>

    <body class="with-side-menu ">
        @include('partials.notifications')
        @include('layouts.headbar')

        <div class="mobile-menu-left-overlay"></div>
        @if (auth()->user()->isVerified())
            @include('layouts.sidebar')
        @endif

        <div class="page-content">
            <div class="container-fluid">
                    @yield('content')
            </div>
        </div>
        @yield('js')
    </body>
</html>
