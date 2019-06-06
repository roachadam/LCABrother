<!DOCTYPE html>
<html lang='en'>
<head>
	<meta class="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<title>Dashboard</title>
    <link rel='stylesheet' href='/css/style.min.css' />
</head>
<body>
	<!-- navbar -->
	@include('home.partials.navbar')
	<!-- Page content -->

    <div class="app">
        <div class="container">
            <div class="app__inner">
                @include('home.partials.sidebar')
                <div class="app__main">
                    <div class="text-container">
                        <h3 class="app__main__title">Thanks for reaching out</h3>
                        <p>Our team will get back to you as soon as thier tiny chinese hands can type!</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

<script src='js/app.min.js'></script>
<script src="{{ asset('js/lib/bootstrap/bootstrap.min.js') }}"></script>
</body>
</html>
