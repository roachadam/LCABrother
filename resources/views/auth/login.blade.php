
<!DOCTYPE html>
<html lang='en'>
<head>
	<meta class="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<title>Login</title>
	<link rel='stylesheet' href='css/style.min.css' />
</head>
<body>
    <!-- navbar -->
    @include('home.partials.navbar')
    <!-- Authentication pages -->
	<div class="auth">
		<div class="container">

			<div class="auth__inner">
				<div class="auth__media">
                    <img src="./img/login.png">
				</div>
				<div class="auth__auth">
					<h1 class="auth__title">Access your dashboard</h1>
                    <p>Fill in your email and password to proceed</p>
                    @include('partials.errors')
					<form method='POST' action="{{ route('login') }}" role="presentation" class="form">
                        @csrf
                        <input name="email" class="fakefield">
						<label>Email</label>
						<input type="text" name="email" id='email' placeholder="you@example.com" autocomplete="email">
						<label>Password</label>
                        <input type="password" name="password" id='password' placeholder="&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;" autocomplete="off">
                        <p class="row">
                            <input type="checkbox" name="remember" id="remember">
                            <label for="remember">Remember Me</label>
                        </p>
                        <button type='submit' class="button button__primary">Log in</button>

                        <p class="text-container">

                                <div class="row">
                                    Don't have an account? <a href="{{ route('register') }}" class="link">Register here</a>
                                </div>

                                <div class="row">
                                    <a href="{{ route('password.request') }}" class="link">Forgot your password?</a>
                                </div>

                            </p>
					</form>
				</div>
			</div>
		</div>
    </div>

<script src='/js/app.min.js'></script>
</body>
</html>
