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
        {{-- <link href="{{ asset('css/lib/bootstrap/bootstrap.min.css') }}" rel="stylesheet"> --}}
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

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
            .breadcrumb {
                background-color: #ECEFF4 !important;
            }
        </style>

        <link href="{{ asset('css/main.css') }}" rel="stylesheet">
        <!-- End Global Styles -->


    </head>

    <body class="with-side-menu dark-theme mozilla-browser">
        @include('layouts.headbar')

        @if (isset(auth()->user()->organization))
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
        {{-- <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script> --}}
        <script src="{{ asset('js/plugins.js') }}"></script>
        <script src="https://kit.fontawesome.com/a076d05399.js"></script>
        <script type="text/javascript" src="{{ asset('js/lib/jqueryui/jquery-ui.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset("https://cdnjs.cloudflare.com/ajax/libs/bootstrap-notify/0.2.0/js/bootstrap-notify.js") }}"></script>
        <script src="{{ asset('js/bootstrap-combobox.js') }}"></script>

        @yield('js')
        <script>
            $(document).ready(function () {
                window.setTimeout(function() {
                    $(".alert").fadeOut("slow");
                    // .fadeTo(500, 0).slideUp(1000, function(){
                    //     $(this).remove();
                    // });
                }, 5000);

                $('#bugReport').click(function(){
                    $("#ReportBugModal").modal("toggle");
                });
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
