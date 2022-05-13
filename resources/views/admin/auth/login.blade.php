<!DOCTYPE html>
<html>
<head>
	<!-- Basic Page Info -->
	<meta charset="utf-8">
	<title>DeskApp - Bootstrap Admin Dashboard HTML Template</title>

	<!-- Site favicon -->
	<link rel="apple-touch-icon" sizes="180x180" href="{{asset('admin/vendors/images/apple-touch-icon.png')}}">
	<link rel="icon" type="image/png" sizes="32x32" href="{{asset('admin/vendors/images/favicon-32x32.png')}}">
	<link rel="icon" type="image/png" sizes="16x16" href="{{asset('admin/vendors/images/favicon-16x16.png')}}">

	<!-- Mobile Specific Metas -->
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

	<!-- Google Font -->
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
	<!-- CSS -->
	<link rel="stylesheet" type="text/css" href="{{asset('admin/vendors/styles/core.css')}}">
	<link rel="stylesheet" type="text/css" href="{{asset('admin/vendors/styles/icon-font.min.css')}}">
	<link rel="stylesheet" type="text/css" href="{{asset('admin/vendors/styles/style.css')}}">

	<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-119386393-1"></script>
	<script>
		window.dataLayer = window.dataLayer || [];
		function gtag(){dataLayer.push(arguments);}
		gtag('js', new Date());

		gtag('config', 'UA-119386393-1');
    </script>
    <style>
        .logo-sedeso{
            width: 80%;
            margin: auto;
            margin-bottom: 1em;
        }

        .login-title{
            text-align: center;
        }

        .login-title h2{
            text-align: center;
            color: #666666 !important;
        }

        input.form-control{
            padding-left: 40px !important;
        }

    </style>
</head>
<body class="login-page">
	<div class="login-wrap d-flex align-items-center flex-wrap justify-content-center">
		<div class="container">
			<div class="row align-items-center">
				<div class="col-md-6 col-lg-7">
					<img src="{{asset('images/logos/logo-morelos-tinta.png')}}" alt="Logo abanico morelos">
				</div>
				<div class="col-md-6 col-lg-5">
					<div class="login-box bg-white box-shadow border-radius-10">
						<div class="login-title">
                            <img class="logo-sedeso text-center" src="{{asset('images/logos/desarrollosocial.png')}}" alt="Logo sedeso">
							<h2 class="text-center text-primary">Iniciar de sesión</h2>
						</div>
                        <form method="POST" action="{{ route('admin.login') }}">
                            @csrf
							<div class="input-group custom">
								<input id="email" type="email" class="form-control form-control-lg @error('email') is-invalid @enderror" placeholder="Correo electrónico" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
								<div class="input-group-prepend custom">
									<span class="input-group-text"><i class="icon-copy dw dw-user1"></i></span>
                                </div>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
							</div>
							<div class="input-group custom">
								<input id="password" type="password" class="form-control form-control-lg @error('password') is-invalid @enderror" placeholder="Contraseña" name="password" required autocomplete="current-password">
								<div class="input-group-prepend custom">
									<span class="input-group-text"><i class="dw dw-padlock1"></i></span>
                                </div>
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
							</div>
							<div class="row pb-30">
								<div class="col-6">
									<div class="custom-control custom-checkbox">
                                        <input class="custom-control-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
										<label class="custom-control-label" for="remember">Recordarme</label>
									</div>
								</div>
								<div class="col-6">
									<div class="forgot-password"><a href="#">Olvide mi contraseña</a></div>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-12">
									<div class="input-group mb-0">
										<input class="btn btn-primary btn-lg btn-block" type="submit" value="Entrar">
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- js -->
	<script src="{{asset('admin/vendors/scripts/core.js')}}"></script>
	<script src="{{asset('admin/vendors/scripts/script.min.js')}}"></script>
	<script src="{{asset('admin/vendors/scripts/process.js')}}"></script>
	<script src="{{asset('admin/vendors/scripts/layout-settings.js')}}"></script>
</body>
</html>