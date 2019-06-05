
<!DOCTYPE html>
<html lang='en'>
<head>
	<meta class="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<title>ClubHouse Login</title>
	<link rel='stylesheet' href='css/style.min.css' />
</head>
<body>
    <!-- navbar -->
    @include('home.partials.navbar')
    <!-- Authentication pages -->
	<div class="auth">
		<div class="container">
            @include('partials.errors')
			<div class="auth__inner">
				<div class="auth__media">
					<img src="./img/home/undraw_selfie.svg">
				</div>
				<div class="auth__auth">
					<h1 class="auth__title">Access your dashboard</h1>
                    <p>Fill in your email and password to proceed</p>

					<form method='POST' action="{{ route('login') }}" autocompelete="new-password" role="presentation" class="form">
                        @csrf
                        <input name="email" class="fakefield">
						<label>Email</label>
						<input type="text" name="email" id='email' placeholder="you@example.com">
						<label>Password</label>
                        <input type="password" name="password" id='password' placeholder="&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;" autocomplete="off">
                        <p class="row">
                                <input type="checkbox" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }} />
                                <label for="check">Remember Me</label>
                              </p>
                        <button type='submit' class="button button__primary">Log in</button>
						<a href=""><h6 class="left-align" >Forgot your password?</h6></a>
					</form>
				</div>
			</div>
		</div>
    </div>

<script src='js/app.min.js'></script>
</body>
</html>
