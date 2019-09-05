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
                    @if (session('status'))
                        <div class="stress" role="alert" style="color:#06d19c">
                            {{ session('status') }}
                        </div>
                    @endif
					<h1 class="auth__title">Reset Your Password</h1>

                    @include('partials.errors')
					<form method='POST' action="{{ route('password.email') }}" role="presentation" class="form">
                        @csrf
                        <input name="email" class="fakefield">
						<label>Email Address</label>
                        <input type="text" name="email" id='email' placeholder="you@example.com" autocomplete="email" value="{{old('email')}}">

                        <button type='submit' class="button button__primary">Send Password Reset Link</button>

                    </form>

				</div>
			</div>
		</div>
    </div>

<script src='/js/app.min.js'></script>
</body>
</html>
