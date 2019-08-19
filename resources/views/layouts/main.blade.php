<!DOCTYPE html>
<html>
    <head lang="{{ str_replace('_', '-', app()->getLocale()) }}">
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>
            @hasSection('title')
                @yield('title') - {{ config('app.name', 'Laravel') }}
            @else
                {{ config('app.name', 'Laravel') }}
            @endif
        </title>

        <!-- Global Styles -->
        <link href="{{ asset('css/lib/datatables-net/datatables.min.css') }}" rel="stylesheet">
        <link href="{{ asset('css/separate/vendor/datatables-net.min.css') }}" rel="stylesheet">
        <link href="{{ asset('css/lib/jqueryui/jquery-ui.min.css') }}" rel="stylesheet">
        <link href="{{ asset('css/lib/font-awesome/font-awesome.min.css') }}" rel="stylesheet">
        <link href="{{ asset('css/lib/bootstrap/bootstrap.min.css') }}" rel="stylesheet">

        <link type="text/css" href="{{ asset("https://cdnjs.cloudflare.com/ajax/libs/bootstrap-notify/0.2.0/css/bootstrap-notify.css") }}" rel="stylesheet">


        @yield('css')

        <style>
            @media (max-width: 560px) {
                #headerButtons .btn {
                    width:100%;
                }
            }

            @media (min-width: 540px) and (max-width: 768px) {
                #headerButtons {
                    margin-top: 10px;
                    margin-left:auto;
                    margin-right:auto;
                }
            }
        </style>

        <link href="{{ asset('css/main.css') }}" rel="stylesheet">
        <!-- End Global Styles -->


    </head>

    <body class="with-side-menu dark-theme mozilla-browser">
        @include('layouts.headbar')

        @if (isset(Auth::user()->organization))
            <div class="mobile-menu-left-overlay"></div>
            @if (auth()->user()->isVerified() && auth()->user()->emailVerified())
                @include('layouts.sidebar')
            @endif
        @endif
        @include('partials.notifications')

        <div class="page-content">
            <div class="container-fluid">
                @yield('content')
            </div>
        </div>

        <!-- Scripts All Pages-->
        <script src="{{ asset('js/lib/jquery/jquery-3.2.1.min.js') }}"></script>
        <script src="{{ asset('js/lib/popper/popper.min.js') }}"></script>
        <script src="{{ asset('js/lib/bootstrap/bootstrap.min.js') }}"></script>
        <script src="{{ asset('js/plugins.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/lib/jqueryui/jquery-ui.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset("https://cdnjs.cloudflare.com/ajax/libs/bootstrap-notify/0.2.0/js/bootstrap-notify.js") }}"></script>
        <script src="{{ asset('js/bootstrap-combobox.js') }}"></script>

        @yield('js')
        <script>
            $(document).ready(function () {

                window.setTimeout(function() {
                    $(".alert").fadeTo(500, 0).slideUp(1000, function(){
                        $(this).remove();
                    });
                }, 5000);
            });
            if (!("ontouchstart" in document.documentElement)) {

                document.documentElement.className += " no-touch";

                var jScrollOptions = {
                    autoReinitialise: true,
                    autoReinitialiseDelay: 100,
                    contentWidth: '0px'
                };

                $('.scrollable .box-typical-body').jScrollPane(jScrollOptions);
                $('.side-menu').jScrollPane(jScrollOptions);
                $('.side-menu-addl').jScrollPane(jScrollOptions);
                $('.scrollable-block').jScrollPane(jScrollOptions);
            }
            // Left mobile menu
            $('.hamburger').click(function(){
                if ($('body').hasClass('menu-left-opened')) {
                    $(this).removeClass('is-active');
                    $('body').removeClass('menu-left-opened');
                    $('html').css('overflow','auto');

                } else {
                    $(this).addClass('is-active');
                    $('body').addClass('menu-left-opened');
                    $('html').css('overflow','hidden');
                }
            });
            $('.mobile-menu-left-overlay').click(function(){
                console.log('two')
                $('.hamburger').removeClass('is-active');
                $('body').removeClass('menu-left-opened');
                $('html').css('overflow','auto');
            });
        </script>
    </body>
</html>
