<!DOCTYPE html>
<html lang='en'>
<head>
	<meta class="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<title>Dashboard</title>
    <link rel='stylesheet' href='css/style.min.css' />
    <link href="{{ asset('css/lib/bootstrap/bootstrap.min.css') }}" rel="stylesheet">

    <script src="{{ asset('js/lib/bootstrap/bootstrap.min.js') }}"></script>
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
                    <div class="text-container">
                        <h3 class="app__main__title">This is the main area</h3>
                        <p>Write or do whatever you want here!</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

<script src='js/app.min.js'></script>
<script src="{{ asset('js/lib/bootstrap/bootstrap.min.js') }}"></script>
</body>
</html>
