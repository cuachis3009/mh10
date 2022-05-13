<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="{{ asset('images/favicon.ico') }}" type="image/vnd.microsoft.icon" />
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('page_title','MUJERES Y HOMBRES DE 10')</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.0.0-alpha/css/bootstrap.min.css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/my-styles.css') }}" rel="stylesheet">

</head>
<body>
    <header>
        <div class="logo-wrapper">
            <div class="container">
                <div class="row">
                    <div class="col-md-4">
                        <img src="{{ asset('images/logos/desarrollosocial.png') }}" alt="">
                    </div>
                    <div class="col-md-8">
                        <h1 class="main-title">MUJERES Y HOMBRES DE 10</h1>
                    </div>
                </div>
            </div>
        </div>
        <div class="menu-wrapper">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="container">
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav">
                            <li class="nav-item active">
                                <a class="nav-link" href="/">Inicio</a>
                            </li>
                            <!--<li class="nav-item">
                                <a class="nav-link" target="_blank" href="{{asset("videos/tutorial.webm")}}">Video tutorial</a>
                            </li>-->
                        </ul>
                    </div>
                    <!--<a class="navbar-brand" href="{{asset('videos/tutorial.webm')}}">Video tutorial</a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>-->
                </div>
            </nav>
        </div>
    </header>
    <main>
        @yield('content')
    </main>
    <footer>
        <div class="footer-top">

        </div>
        <div class="footer-bottom">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <p>Secretaría de Desarrollo Social</p>
                        <p>Plan de Ayala número 825  Plaza Cristal local 26 y 27a 3er nivel <br>
                            Teopanzolco C.P. 62350 Cuernavaca, Morelos<br>
                            Lunes a Viernes de 8:00 a 17:00 horas<br>
                            Teléfono 01 (777) 310-06-40 </p>
                    </div>
                    <div class="col-md-6 footer-bottom-img">
                        <img src="{{ asset('images/logos/morelos-2018-2024.png') }}" alt="">
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha/js/bootstrap.min.js" integrity="sha512-0z9zJIjxQaDVzlysxlaqkZ8L9jh8jZ2d54F3Dn36Y0a8C6eI/RFOME/tLCFJ42hfOxdclfa29lPSNCmX5ekxnw==" crossorigin="anonymous"></script>
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <script src="{{ asset('js/functions.js') }}" defer></script>
    <script src="https://unpkg.com/@popperjs/core@2"></script>

    @yield('js')

</body>
</html>