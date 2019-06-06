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
	@include('home.partials.dashnav')
	<!-- Page content -->

    <div class="app">
        <div class="container">
            <div class="app__inner">
                @include('home.partials.dashside')
                <div class="app__main">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>

<script src='js/app.min.js'></script>
</body>
</html>

