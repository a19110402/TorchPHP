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
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <link rel="stylesheet" href="{{url('css/normalize.css')}}">
    <link rel="stylesheet" href="{{url('css/au.css')}}">

    @yield('extraCSS')
    <title >Torch</title>
</head>
<body>
    <header>
        <div class="flex-col md:flex md:flex-row md:justify-between">
            <div class="w-full md:w-auto">
                <a href="/">
                    <picture class="flex justify-center ">
                        <img class="w-6/12 md:w-6/12" src="{{asset('img/TORCH-logo.png')}}" alt="LogoEmpresa">
                    </picture>
                </a>
            </div>
            {{-- <div class="navegacion-principal md:flex items-center"> --}}
            <div class="flex flex-col items-center w-full  md:flex md:flex-row md:justify-evenly">
                    <a href="{{url('/products')}}">Productos</a>
                @if (auth()->user() == null)
                    <a href="{{ route('rateAndTransitTimes') }}">Cotización</a>
                    <a href="#">Rastreo</a>
                    <a href="#">Logística</a>
                    <a href="#">Promociones</a>
                    <a href="{{url('/register')}}">Crear cuenta</a>
                    <a href="{{url('/login')}}">Iniciar sesión</a>
                @elseif(auth()->user()->role =='admin')
                    <a>Bienvenido <b>{{ auth()->user()->name }}</b></a>
                    <a href="/fedex/rateAndTransitTimes">Cotización</a>
                    <a href="#">Envío</a>
                    <a href="#">Rastrear</a>
                    <a href="{{url('/register')}}">Crear usuario</a>
                    <a href="{{ route('login.destroy') }}" >Log out</a>
                @endif
                
            </div>
        </div>
    </header>

    @yield('content')

    <footer class="footer">

        @yield('footer')@section('footer')

        <div class="contenedor-baseline">

            <div class="linea-amarilla"></div>

            <div class="logo-conteiner">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-brand-facebook" width="38" height="38" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <path d="M7 10v4h3v7h4v-7h3l1 -4h-4v-2a1 1 0 0 1 1 -1h3v-4h-3a5 5 0 0 0 -5 5v2h-3" />
                </svg>
            </div>

            <div class="logo-conteiner">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-brand-instagram" width="38" height="38" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <rect x="4" y="4" width="16" height="16" rx="4" />
                    <circle cx="12" cy="12" r="3" />
                    <line x1="16.5" y1="7.5" x2="16.5" y2="7.501" />
                </svg>
            </div>

            <div class="logo-conteiner-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-world" width="38" height="38" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <circle cx="12" cy="12" r="9" />
                    <line x1="3.6" y1="9" x2="20.4" y2="9" />
                    <line x1="3.6" y1="15" x2="20.4" y2="15" />
                    <path d="M11.5 3a17 17 0 0 0 0 18" />
                    <path d="M12.5 3a17 17 0 0 1 0 18" />
                </svg>
            </div>

            <div class="linea-amarilla"></div>
        </div>



    </footer>
    <script src="https://code.jquery.com/jquery-1.11.0.min.js"></script>
    @yield('scripts')
</body>
</html>