<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,300;1,400;1,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{url('css/au.css')}}">
    @yield('extraCSS')@section('extraCSS')
    <title>Torch</title>
</head>
<body>
    <header>
        <div class="logo">
            <a href="/">
                <picture>
                    <img src="{{asset('img/descarga.png')}}" alt="LogoEmpresa">
                </picture>
            </a>
        </div>
        <div class="navegacion-principal">
            <a href="#">Envíos</a>
            <a href="#">Rastreo</a>
            <a href="#">Logística</a>
            <a href="#">Promociones</a>
            <a href="{{url('/register')}}">Crear cuenta</a>
            <a href="{{url('/login')}}">Iniciar sesión</a>
        </div>
    </header>


    @yield('content')@section('content')

    <footer class="footer">
        <div>
            <img src="" alt="Logo de empresa">
        </div><!---->
        <div>
            <p>Recursos de apoyo</p>
            <a href=""></a>
        </div>
        <div>
            <p>Envíos</p>
            <a href=""></a>
        </div>
        <div>
            <p>Paqueterías</p>
            <a href=""></a>
        </div>
        <div>
            <p>Rastreo</p>
            <a href=""></a>
        </div>
        <div>
            <p>Cotizar</p>
            <a href=""></a>
        </div>
        <div>
            <p>Nosotros</p>
            <a href=""></a>
        </div>
        <div>
            <p>Contactanos</p>
            <a href=""></a>
        </div>
    </footer>
    <script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
    @yield('scripts')@section('scripts')
</body>
</html>