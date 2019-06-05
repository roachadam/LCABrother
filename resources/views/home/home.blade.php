<!DOCTYPE html>
<html lang='en'>
<head>
	<meta class="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<title>ClubHouse</title>
	<!-- Don't forget to add your metadata here -->
	<link rel='stylesheet' href='css/style.min.css' />
</head>
<body>
    <!-- Hero(extended) navbar -->
    @include('home.partials.navbar')
	<!-- Hero unit -->
	@include('home.partials.hero')
	<!-- Steps -->
	<div class="steps landing__section">
		<div class="container">
			<h2>Who can use Evie?</h2>
			<p>Here's who we can think of, but surely creative people will surprise us.</p>
		</div>
		<div class="container">
			<div class="steps__inner">
				<div class="step">
					<div class="step__media">
						<img src="./img/home/clean.svg" class="step__image">
					</div>
					<h4>Goodbye Google Sheets</h4>
					<p class="step__text">Say goodbye to random google sheets pages attemping to track all your membership data. We will give you the tools you needed to simply track this data with no need to write excel fogmulas!</p>
				</div>
				<div class="step">
					<div class="step__media">
						<img src="./img/home/voting.svg" class="step__image">
					</div>
					<h4>Voting</h4>
					<p class="step__text">A forum that can be seperated into posting categories with polls is included; making it simple for your org to communicate securely.</p>
				</div>
				<div class="step">
					<div class="step__media">
						<img src="./img/home/undraw_creation.svg" class="step__image">
					</div>
					<h4>Makers</h4>
					<p class="step__text">A great starting point for your web application. Focus on your idea and execution.</p>
				</div>
			</div>
		</div>
	</div>
	<!-- Expanded sections -->
	<div class="expanded landing__section">
		<div class="container">
			<div class="expanded__inner">
				<div class="expanded__media">
					<img src="./img/home/undraw_browser.svg" class="expanded__image">
				</div>
				<div class="expanded__content">
					<h2 class="expanded__title">Natural styling with almost nothing to learn</h2>
					<p class="expanded__text">Evie brings you the pages you'll need and the structure to create your own, without a learning curve. It is minimal and mostly styles plain elements. There are only a few classes you'll need to know but nothing to disrupt your preferred coding style.</p>
				</div>
			</div>
		</div>
	</div>
	<div class="expanded landing__section">
		<div class="container">
			<div class="expanded__inner">
				<div class="expanded__media">
					<img src="./img/home/undraw_frameworks.svg" class="expanded__image">
				</div>
				<div class="expanded__content">
					<h2 class="expanded__title">Framework agnostic. Your front-end setup, your choice.</h2>
					<p class="expanded__text">Evie has zero dependencies and uses vanilla JavaScript for a few functions with minimal footprint. You can use React, Vue, Angular, jQuery or whatever you prefer.</p>
				</div>
			</div>
		</div>
	</div>
	<div class="expanded landing__section">
		<div class="container">
			<div class="expanded__inner">
				<div class="expanded__media">
					<img src="./img/home/together.svg" class="expanded__image">
				</div>
				<div class="expanded__content">
					<h2 class="expanded__title">Ready for production or rapid prototyping</h2>
					<p class="expanded__text">Landing, authentication and a few other pages to select from, despite the small size. Tested on production at unDraw with amazing speeds and unopinionated on how to structure your project. We really hope you'll find it awesome and useful!</p>
				</div>
			</div>
		</div>
	</div>
	<!-- Call To Action -->
	<div class="cta cta--reverse">
		<div class="container">
			<div class="cta__inner">
				<h2 class="cta__title">Get started now</h2>
				<p class="cta__sub cta__sub--center">Grab the production version and begin your project instantly.</p>
				<a href="#" class="button button__accent">Download Evie</a>
			</div>
		</div>
	</div>
	<!-- Footer -->
	@include('home.partials.footer')
<script src='js/app.min.js'></script>
</body>
</html>
