<!DOCTYPE html>
<html lang="en">
<head>
	<title>Password Reset</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link href="{{ asset('css/login/bootstrap.min.css') }}" rel="stylesheet">
<!--===============================================================================================-->

	<!-- Font awesome -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link href="{{ asset('css/login/material-design-iconic-font.min.css') }}" rel="stylesheet">
<!--===============================================================================================-->
	<link href="{{ asset('css/login/animate.css') }}" rel="stylesheet">
<!--===============================================================================================-->	
	<link href="{{ asset('css/login/hamburgers.min.css') }}" rel="stylesheet">
<!--===============================================================================================-->
	<link href="{{ asset('css/login/animsition.min.css') }}" rel="stylesheet">
<!--===============================================================================================-->
	<link href="{{ asset('css/login/select2.min.css') }}" rel="stylesheet">
<!--===============================================================================================-->	
	<link href="{{ asset('css/login/daterangepicker.css') }}" rel="stylesheet">
<!--===============================================================================================-->
	<link href="{{ asset('css/login/util.css') }}" rel="stylesheet">
	<link href="{{ asset('css/login/main.css') }}" rel="stylesheet">
<!--===============================================================================================-->
</head>
<body>
	
	<div class="limiter">
		<div class="container-login100" style="background-image: url({{ asset('images/bg-01.jpg') }});">
			<div class="wrap-login100">
				@if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif
				<form class="login100-form validate-form" method="POST" action="{{ route('password.email') }}">
					@csrf
					<span class="login100-form-logo">
						<i class="zmdi zmdi-landscape"></i>
					</span>

					<span class="login100-form-title p-b-34 p-t-27">
						Password Reset
					</span>

					<div class="wrap-input100 validate-input" data-validate = "Enter Email">
						<input class="input100 {{ $errors->has('email') ? ' is-invalid' : '' }}" type="email" name="email" placeholder="Email" value="{{ old('email') }}" required>
						<span class="focus-input100" data-placeholder="&#xf207;"></span>
						@if ($errors->has('email'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
					</div>

					<div class="container-login100-form-btn">
						<button class="login100-form-btn" type="submit">
							Send Password Reset Link
						</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	

	<div id="dropDownSelect1"></div>
	
<!--===============================================================================================-->
	<script src="{{ asset('js/login/jquery-3.2.1.min.js') }}"></script>
<!--===============================================================================================-->
	<script src="{{ asset('js/login/animsition.min.js') }}"></script>
<!--===============================================================================================-->
	<script src="{{ asset('js/login/popper.js') }}"></script>
	<script src="{{ asset('js/login/bootstrap.min.js') }}"></script>
<!--===============================================================================================-->
	<script src="{{ asset('js/login/select2.min.js') }}"></script>
<!--===============================================================================================-->
	<script src="{{ asset('js/login/moment.min.js') }}"></script>
	<script src="{{ asset('js/login/daterangepicker.js') }}"></script>
<!--===============================================================================================-->
	<script src="{{ asset('js/login/countdowntime.js') }}"></script>
<!--===============================================================================================-->
	<script src="{{ asset('js/login/main.js') }}"></script>

</body>
</html>