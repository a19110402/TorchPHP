<!DOCTYPE html>
<html lang="en" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;500&display=swap" rel="stylesheet">
    
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <link rel="stylesheet" href="{{url('css/normalize.css')}}">
    <link rel="stylesheet" href="{{url('css/au.css')}}">

    @yield('extraCSS')
    <title >Torch</title>
</head>

<body>
    <header class="mt-7">
        <div class="md2:flex">
            <div class="md:max-w-sm flex justify-center">
                <a href="/">
                    <picture class="flex justify-center">
                        <img class="w-6/12 md:w-6/12" src="{{asset('img/TORCH-logo.png')}}" alt="LogoEmpresa">
                    </picture>
                </a>
            </div>

            <div class="flex flex-col items-center w-full  md:flex md:flex-row md:justify-evenly links">

                @if(auth()->user() != null && auth()->user()->type =='corp')
                    <a href="{{ route('admin.index') }}">Bienvenido <b>{{ auth()->user()->name }}</b></a>
                    <a href="{{ route('rateAndTransitTimes') }}">Cotización</a>
                    <a href="#">Envío</a>
                    <a href="#">Rastrear</a>
                    <a href="{{ route('login.destroy') }}" >Log out</a>
                @elseif(auth()->user() != null)
                    <a href="{{ route('home') }}">Bienvenido <b>{{ auth()->user()->name }}</b></a>
                    <a href="{{ route('rateAndTransitTimes') }}">Cotización</a>
                    <a href="#">Envío</a>
                    <a href="#">Rastrear</a>
                    <a href="{{ route('login.destroy') }}" >Log out</a>
                @else
                    <a href="{{ route('rateAndTransitTimes') }}">Envíos</a>
                    <a href="#">Consulta api FEDEX</a>
                    <a href="#">Rastreo</a>
                    <a href="#">Logística</a>
                    <a href="#">Promociones</a>
                    <a href="{{url('/register')}}">Crear cuenta</a>
                    <a href="{{url('/login')}}">Iniciar sesión</a>
                @endif

            </div>
        </div>
    </header>

    @yield('content')
    <footer class="footer h-full relative md:fixed">
        <div class="contenedor-baseline">

            <div>
                <p>Derechos Reservados 2022</p>
            </div>

            <div class="flex">
                <div class="logo-conteiner">
                    <a href="/">
                        <picture class="flex justify-center">
                            <img class="" src="{{asset('img/face.svg')}}" alt="LogoFace">
                        </picture>
                    </a>
                </div>

                <div class="logo-conteiner">
                    <a href="/">
                        <picture class="flex justify-center">
                            <img class="" src="{{asset('img/insta.svg')}}" alt="LogoInsta">
                        </picture>
                    </a>
                </div>
            </div>


            <div class="md:w-auto">
                <a href="/">
                    <picture class="flex justify-center">
                        <img class="" alt="Logo TORCH diferente">
                    </picture>
                </a>
            </div>
        </div>
    </footer>

    @yield('scripts')
    <script src="https://code.jquery.com/jquery-1.11.0.min.js"></script>
</body>
</html>