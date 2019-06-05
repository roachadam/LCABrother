<!DOCTYPE html>
<html lang='en'>
<head>
	<meta class="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<title>Page | Evie by unDraw</title>
	<link rel='stylesheet' href='css/style.min.css' />
</head>
<body>
	<!-- navbar -->
	@include('home.partials.navbar')
	<!-- Hero unit -->
	<div class="page__header">
		<div class="hero__overlay hero__overlay--gradient"></div>
		<div class="hero__mask"></div>
		<div class="page__header__inner">
			<div class="container">
				<div class="page__header__content">
					<div class="page__header__content__inner" id='navConverter'>
						<h1 class="page__header__title">Multi-purpose page</h1>
						<p class="page__header__text">This is mostly a simple layout, rather than a complete page unlike the others. However this is a really useful starting point for anything you want to create.</p>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- Page content -->
	<div class="page">
		<div class="container">
			<div class="page__inner">
                @include('home.partials.sidebar')

				<div class="page__main">
					<div class="text-container">
						<h3 class="page__main__title">This is the main area</h3>
						<p>Write or do whatever you want here!</p>
					</div>
				</div>
			</div>
		</div>
	</div>

<script src='js/app.min.js'></script>
</body>
</html>
