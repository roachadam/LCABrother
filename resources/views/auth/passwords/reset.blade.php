<!DOCTYPE html>
<html lang='en'>
<head>
	<meta class="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<title>Reset Password</title>
	<link rel='stylesheet' href='/css/style.min.css' />
</head>
<body>
    <!-- navbar -->
    @include('home.partials.navbar')
    <!-- Authentication pages -->
	<div class="auth">
		<div class="container">

			<div class="auth__inner">
				<div class="auth__media">
                    <img src="/img/home/forgot.svg">
				</div>
				<div class="auth__auth">
					<h1 class="auth__title">Reset Your Password</h1>

                    @include('partials.errors')
					<form method='POST' action="{{ route('password.update') }}" role="presentation" class="form">
                        @csrf
                        <input type="hidden" name="token" value="{{ $token }}">

                        <input name="email" class="fakefield">
						<label>Email Address</label>
                        <input type="text" name="email" id='email' placeholder="you@example.com" autocomplete="email" value="{{old('email')}}">

                        <label>Password (must include letters, numbers, symbols and be 10 characters min)</label>
                        <input type="password" name="password" id='password' placeholder="&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;" autocomplete="off">

                        <label>Confirm Password</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" placeholder="&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;" autocomplete="off">

                        <button type='submit' class="button button__primary">Reset Password</button>

                    </form>

				</div>
			</div>
		</div>
    </div>

<script src='/js/app.min.js'></script>
</body>
</html>
