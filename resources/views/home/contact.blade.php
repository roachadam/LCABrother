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
						<h1 class="page__header__title">Contact Us</h1>
						<p class="page__header__text">Sunt qui aliquip aliqua aliqua culpa.</p>
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
						<h3 class="page__main__title"></h3>
						<form method='POST' action="/home/contactUs" role="presentation" class="form">
                            @csrf
                            <input name="name" class="fakefield">
                            <label>Name</label>
                            <input type="text" name="name" id='name' placeholder="Johnny Smith">

                            <input name="email" class="fakefield">
                            <label>Email</label>
                            <input type="text" name="email" id='email' placeholder="you@example.com">

                            <input name="subject" class="fakefield">
                            <label>Subject</label>
                            <input type="text" name="subject" id='subject' placeholder="Great Site">

                            <label for='body'>Body</label>
                            <textarea placeholder="Thanks for all the hard work!" id='body'></textarea>

                            <button type='submit' class="button button__primary">Send</button>

                        </form>
					</div>
				</div>
			</div>
		</div>
	</div>

<script src='js/app.min.js'></script>
</body>
</html>
