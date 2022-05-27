<!DOCTYPE html>
<html>
<head>
	<!-- Basic Page Info -->
	<meta charset="utf-8">
	<title>SEDESO | MUJERES Y HOMBRES DE 10</title>

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
	<link rel="stylesheet" type="text/css" href="{{asset('admin/vendors/styles/my-style.css')}}">
	
	@yield('css')

</head>
<body>
	<div id="app">

		<!--<div class="pre-loader">
			<div class="pre-loader-box">
				<div class="loader-logo"><img src="{{asset('admin/vendors/images/deskapp-logo.svg')}}" alt=""></div>
				<div class='loader-progress' id="progress_div">
					<div class='bar' id='bar1'></div>
				</div>
				<div class='percent' id='percent1'>0%</div>
				<div class="loading-text">
					Cargando...
				</div>
			</div>
		</div>-->


		<div class="header no-print">
			<div class="header-left">
				<div class="menu-icon dw dw-menu"></div>
				<div class="search-toggle-icon dw dw-search2" data-toggle="header_search"></div>
				<div class="header-search">
					<form action="{{route('admin.2022.search')}}" method="POST" class="form-inline">
						@csrf
						<div class="form-group mr-sm-2">
							<label class="sr-only" for="inlineFormInputName2">Tipo de convocatoria</label>
							<select name="type-project" id="type-project" class="form-control form-control-sm">
								<option value="">Selecciona la convocatoria</option>
								@foreach ($project_types as $p_type)
									<option value="{{$p_type->id}}">{{ucfirst($p_type->name)}}</option>
								@endforeach
							</select>
						</div>
						<div class="form-group mr-sm-2" style="margin">
							<label class="sr-only" for="inlineFormInputName2">Numero de folio</label>
							<input type="text" name="folio-search" id="folio-search" class="form-control form-control-sm" placeholder="Número de folio">
						</div>
						<button type="submit" class="btn btn-primary btn-sm">Buscar folio</button>
					</form>
				</div>
			</div>
			<div class="header-right">
				<!--div class="user-notification">
					<div class="dropdown">
						<a class="dropdown-toggle no-arrow" href="#" role="button" data-toggle="dropdown">
							<i class="icon-copy dw dw-notification"></i>
							<span class="badge notification-active"></span>
						</a>
						<div class="dropdown-menu dropdown-menu-right">
							<div class="notification-list mx-h-350 customscroll">
								<ul>
									<li>
										<a href="#">
											<img src="{{asset('admin/vendors/images/img.jpg')}}" alt="">
											<h3>John Doe</h3>
											<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed...</p>
										</a>
									</li>
									<li>
										<a href="#">
											<img src="{{asset('admin/vendors/images/photo1.jpg')}}" alt="">
											<h3>Lea R. Frith</h3>
											<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed...</p>
										</a>
									</li>
									<li>
										<a href="#">
											<img src="{{asset('admin/vendors/images/photo2.jpg')}}" alt="">
											<h3>Erik L. Richards</h3>
											<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed...</p>
										</a>
									</li>
									<li>
										<a href="#">
											<img src="{{asset('admin/vendors/images/photo3.jpg')}}" alt="">
											<h3>John Doe</h3>
											<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed...</p>
										</a>
									</li>
									<li>
										<a href="#">
											<img src="{{asset('admin/vendors/images/photo4.jpg')}}" alt="">
											<h3>Renee I. Hansen</h3>
											<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed...</p>
										</a>
									</li>
									<li>
										<a href="#">
											<img src="{{asset('admin/vendors/images/img.jpg')}}" alt="">
											<h3>Vicki M. Coleman</h3>
											<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed...</p>
										</a>
									</li>
								</ul>
							</div>
						</div>
					</div>
				</div-->
				<div class="user-info-dropdown">
					<div class="dropdown">
						<a class="dropdown-toggle" href="#" role="button" data-toggle="dropdown">
							<span class="user-icon">
								<img src="{{asset('admin/vendors/images/photo1.jpg')}}" alt="">
							</span>
							<span class="user-name">{{ auth()->user()->name }}</span>
						</a>
						<div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
							<a class="dropdown-item" href="#"><i class="dw dw-user1"></i> Perfil</a>
							<!--a class="dropdown-item" href="""><i class="dw dw-settings2"></i>  Cambiar contraseña</a-->
							<a class="dropdown-item" href="{{route('admin.logout')}}"><i class="dw dw-logout"></i> Salir</a>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="left-side-bar">
			<div class="brand-logo">
				<a href="index.html">
					<img src="{{asset('admin/vendors/images/deskapp-logo.svg')}}" alt="" class="dark-logo">
					<img src="{{asset('admin/vendors/images/deskapp-logo-white.svg')}}" alt="" class="light-logo">
				</a>
				<div class="close-sidebar" data-toggle="left-sidebar-close">
					<i class="ion-close-round"></i>
				</div>
			</div>
			<div class="menu-years">
				@foreach ($years as $year)
					<a href="{{route('admin.period.change',['year' => $year->year])}}" class="btn btn-outline-light btn-sm period-year @if (session('year') == $year->year) current-period-selected @endif">{{$year->year}}</a>
				@endforeach
			</div>
			<div class="menu-block customscroll">
				<div class="sidebar-menu">
					@include('admin.'.session('year').'.includes.menu')
				</div>
			</div>
		</div>
		<div class="mobile-menu-overlay"></div>

		<div class="main-container">
			<div class="pd-ltr-20 xs-pd-20-10 mb-30">
				<div class="min-height-200px">
					@yield('content')
					<!--<div class="page-header">
						<div class="row">
							<div class="col-md-6 col-sm-12">
								<div class="title">
									<h4>blank</h4>
								</div>
								<nav aria-label="breadcrumb" role="navigation">
									<ol class="breadcrumb">
										<li class="breadcrumb-item"><a href="index.html">Home</a></li>
										<li class="breadcrumb-item active" aria-current="page">blank</li>
									</ol>
								</nav>
							</div>
							<div class="col-md-6 col-sm-12 text-right">
								<div class="dropdown">
									<a class="btn btn-primary dropdown-toggle" href="#" role="button" data-toggle="dropdown">
										January 2018
									</a>
									<div class="dropdown-menu dropdown-menu-right">
										<a class="dropdown-item" href="#">Export List</a>
										<a class="dropdown-item" href="#">Policies</a>
										<a class="dropdown-item" href="#">View Assets</a>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
						
					</div>-->
				</div>
			</div>
		</div>
		<div class="main-footer">
			<div>
				Sistema de administración del Programa de Mujeres y Hombres de 10, de la <a target="_blank" href="http://desarrollosocial.morelos.gob.mx/"><b>Secretaría de Desarrollo Social.</b></a>
			</div>
			<div class="pull-right hidden-xs">
				<span><b>Version</b> 4.0.0</span>
			</div>
		</div>
	</div>
	<!-- js -->
	
	<script src="{{asset('admin/vendors/scripts/core.js')}}"></script>

	<script src="{{asset("js/manifest.js")}}"></script>
	<script src="{{asset("js/vendor.js")}}"></script>
	<script src="{{mix("js/app.js")}}"></script>
	<!--<script src="{{asset("js/app.js")}}"></script>-->
	<script src="{{asset('admin/vendors/scripts/core.js')}}"></script>
	<script src="{{asset('admin/vendors/scripts/script.min.js')}}"></script>
	<script src="{{asset('admin/vendors/scripts/process.js')}}"></script>
	<script src="{{asset('admin/vendors/scripts/layout-settings.js')}}"></script>
	<script src="{{asset('admin/js/app.js')}}"></script>
	<script src="{{asset('admin/js/searh-folio.js')}}"></script>

	@yield('script')

</body>
</html>