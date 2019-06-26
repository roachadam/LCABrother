<!DOCTYPE html>
<html lang='en'>
    <head>
        <meta class="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <title>@yield('title')</title>

        <link rel='stylesheet' href='/css/style.min.css' />
    </head>
    <body>
        <!-- navbar -->
        @include('home.partials.navbar')
        <!-- Authentication pages -->

        <div class="auth">
            <div class="container">
                @include('partials.errors')
                <div class="auth__inner">
                    @yield('content')
                </div>
            </div>
        </div>

        <script src='/js/app.min.js'></script>
    </body>
</html>

