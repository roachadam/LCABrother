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
						<h1 class="page__header__title">About Us</h1>
						<p class="page__header__text">Learn a little more about our team.</p>
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
						<h3 class="page__main__title">Quis eu culpa ea in ullamco irure in magna.</h3>
						<p>Voluptate ipsum dolor esse non. Reprehenderit fugiat culpa elit sit adipisicing. Culpa ullamco reprehenderit eiusmod tempor duis officia reprehenderit aliquip et qui consequat qui. Excepteur ad labore ad eiusmod. Magna laborum nulla laboris fugiat id anim magna.</p>
					</div>
				</div>
			</div>
		</div>
	</div>

<script src='js/app.min.js'></script>
</body>
</html>
