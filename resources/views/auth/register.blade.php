<!DOCTYPE html>
<html lang='en'>
<head>
	<meta class="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<title>Register</title>
    <link rel='stylesheet' href='css/style.min.css'/>
</head>
<body>
    <!-- navbar -->
    @include('home.partials.navbar')
    <!-- Authentication pages -->
	<div class="auth">
		<div class="container">
			<div class="auth__inner">
				<div class="auth__media">
					<img src="./img/home/auth.svg">
				</div>
				<div class="auth__auth">
					<h1 class="auth__title">Create Your Account</h1>
                    @include('partials.errors')

					<form method='POST' action="{{ route('register') }}" autocompelete="new-password" role="presentation" class="form">
                        @csrf
                        {{-- <input name="name" class="fakefield"> --}}
						<label>Name</label>
                        <input type="text" name="name" id='name' placeholder="Johnny Smith" required autocomplete="name" value="{{old('name')}}">

                        {{-- <input name="email" class="fakefield"> --}}
						<label>Email</label>
                        <input type="email" name="email" id='email' placeholder="you@example.com" required autocomplete="email" value="{{old('email')}}">

                        {{-- <input name="phone" class="fakefield"> --}}
						<label>Phone Number</label>
                        <input type="tel" name="phone" id='frmPhoneNumA' placeholder="(337) 999-0909" required autocomplete="tel" value="{{old('phone')}}">

						<label>Password (must include letters, numbers, symbols and be 10 characters min)</label>
                        <input type="password" name="password" id='password' placeholder="&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;" autocomplete="off">

                        <label>Confirm Password</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" placeholder="&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;" autocomplete="off">

                        <p class="row">
                            <input type="checkbox" name="remember" id="remember">
                            <label for="remember">Remember Me</label>
                        </p>
                        <button type='submit' class="button button__primary">Register</button>

                        <p class="text-container">

                            <div class="row">
                                Already have an account? <a href="{{ route('login') }}" class="link">Login</a>
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

    <script src='js/app.min.js'></script>
    {{-- <script src="{{ asset('js/lib/jquery/jquery-3.2.1.min.js') }}"></script>
    <script src="{{ asset('js/lib/input-mask/jquery.mask.min.js') }}"></script>

    <script>
            $('.frmPhoneNumA').mask('(000) 000-0000', {placeholder: "(___) ___-____"});
    </script> --}}
</body>
</html>

