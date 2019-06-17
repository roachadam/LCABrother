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
			<h2></h2>
			<p>Here's who we can think of, but surely creative people will surprise us.</p>
		</div>
		<div class="container">
			<div class="steps__inner">
				<div class="step">
					<div class="step__media">
						<img src="./img/home/clean.svg" class="step__image">
					</div>
					<h4>Simplify your record keeping.</h4>
					<p class="step__text">Streamline the way your organization collects and stores involvement data, service hours and more. No more Google Sheets, Forms and lost notebook pages.</p>
				</div>
				<div class="step">
					<div class="step__media">
						<img src="./img/home/voting.svg" class="step__image">
					</div>
					<h4>Easily poll and survey your membership</h4>
					<p class="step__text">In order to operate efficiently, you need to be able to gather opinions from yours members. Find out where you should have formal, where you next meeting should be, or where your Spring trip should be; all without ever mass texting or email blasting.</p>
				</div>
				<div class="step">
					<div class="step__media">
						<img src="./img/home/undraw_creation.svg" class="step__image">
					</div>
					<h4>lorem ipsum</h4>
					<p class="step__text">"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
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
					<h2 class="expanded__title">Enim mollit laboris non in enim anim amet dolor aliqua laboris adipisicing sit reprehenderit.</h2>
					<p class="expanded__text">EAliquip exercitation eu do deserunt dolor ipsum. Mollit in irure incididunt incididunt sint sint consectetur quis officia magna eiusmod sunt nulla do. Consectetur nisi et nostrud tempor dolor elit pariatur deserunt cillum irure qui sint aliqua labore. Reprehenderit velit duis nostrud irure cillum veniam eiusmod cupidatat excepteur esse. Dolore magna exercitation aliqua labore ullamco ea Lorem enim occaecat est consectetur. Aute sint aliqua reprehenderit aute irure et officia consequat proident veniam cupidatat non. Tempor nostrud est sint non est dolor laboris eiusmod do deserunt aliqua anim.</p>
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
					<h2 class="expanded__title">Ea anim minim adipisicing irure.</h2>
					<p class="expanded__text">Duis id fugiat occaecat aliqua et duis duis labore. Consequat enim veniam laboris deserunt ea laboris aliqua ipsum ipsum incididunt. Pariatur proident laborum deserunt nostrud do sit mollit ut culpa voluptate eu. Consectetur eu magna in Lorem sit tempor aute. Non incididunt occaecat sint commodo nisi mollit ullamco aliquip. Consectetur ad id dolore cillum ut ullamco. Incididunt veniam irure id magna.</p>
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
					<h2 class="expanded__title">Qui commodo esse anim laboris est duis deserunt laboris aute ipsum voluptate duis culpa sint.</h2>
					<p class="expanded__text">Duis pariatur laboris labore incididunt sunt elit id labore adipisicing cupidatat. Ut occaecat ea quis esse ea. Incididunt dolor nisi voluptate mollit non duis. Culpa voluptate nostrud magna Lorem. Reprehenderit reprehenderit mollit sunt aliquip ad sit aute amet nostrud. Excepteur adipisicing minim ad nostrud duis Lorem nisi reprehenderit qui eiusmod Lorem incididunt in laborum.</p>
				</div>
			</div>
		</div>
	</div>
	<!-- Call To Action -->
	<div class="cta cta--reverse">
		<div class="container">
			<div class="cta__inner">
				<h2 class="cta__title">Get started now</h2>
				<p class="cta__sub cta__sub--center">Register your organization and begin gathering data today.</p>
				<a href="/register" class="button button__accent">Register</a>
			</div>
		</div>
	</div>
	<!-- Footer -->
	@include('home.partials.footer')
<script src='js/app.min.js'></script>
</body>
</html>
