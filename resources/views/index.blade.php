@extends('layouts.base')

@section('content')
<link rel="stylesheet" href="{{url('css/index.css')}}">

    <main>
        <div class="principal">
            <h1>
                <span class="color-texto">Envía tus productos</span>
                en un mismo lugar y visualiza tus guías
                <span class="color-texto">desde un mismo lugar</span>
            </h1>
    
            <p class="no-margin">
                Genera los envíos de tu tienda en línea, empresa o negocio,compara precios, tiempos de entrega de tus envíos y aprovecha nuestras promociones con tan solo un click.
            </p>
            
            <p class="no-margin">
                ¡Somos la Plataforma logística que hará crecer tu negocio!
            </p>

            <div class="cont-botones">
                <div class="cont-boton"> <a href="{{url('/login')}}" class="boton-inicia">Iniciar Sesión</a> </div>

                <div class="cont-boton-reg"> <a href="{{url('/register')}}" class="boton-registro">Regístrate</a> </div>
            </div>
            
        </div>
    
        <div class="imagen-formato"></div>
    </main>
@endsection
