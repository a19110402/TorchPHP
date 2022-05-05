@extends('layouts.base')
@section('content')
    <hr>
    <main>
        <div class="promociones">
            <img src="{{asset('/img/9.png')}}" alt="imagen descripcion-promociones">
        </div>
    </main>

    <section class="loQueOfrecemos">

        <h2>Lo que ofrecemos</h2>
        <hr>
        <div class="servicios">
            <div class="presentacionServicios">
                <picture>
                    <source srcset="{{asset('/img/fotoDeTransporte.webp')}}">
                    <img src="" alt="foto de transporte">
                </picture>
            </div>

            <div class="descripcion-servicios">
                <img src="" alt="minilogos">
                <p>Lorem ipsum dolor sit amet, consectetur
                    adipiscing elit. Maecenas ut luctus purus.
                    Suspendisse mollis tempus sem eget elementum.
                    Pellentesque felis justo, venenatis fermentum
                    pellentesque in, malesuada eu tortor. Aenean in tempus nulla. Aenean cursus odio ut eros aliquam, vitae laoreet dolor scelerisque. Donec hendrerit, ligula eget dapibus bibendum, lectus tellus sodales magna, in blandit nisl leo ut nibh. Nam viverra erat elit, nec tempor quam luctus id. Aenean id est a libero ultricies dignissim. Pellentesque at libero non purus venenatis tincidunt.</p>
            </div>

            <div class="descripcion-servicios">
            </div>
                <img src="" alt="minilogos">
                <p>Lorem ipsum dolor sit amet, consectetur
                    adipiscing elit. Maecenas ut luctus purus.
                    Suspendisse mollis tempus sem eget elementum.
                    Pellentesque felis justo, venenatis fermentum
                    pellentesque in, malesuada eu tortor. Aenean in tempus nulla. Aenean cursus odio ut eros aliquam, vitae laoreet dolor scelerisque. Donec hendrerit, ligula eget dapibus bibendum, lectus tellus sodales magna, in blandit nisl leo ut nibh. Nam viverra erat elit, nec tempor quam luctus id. Aenean id est a libero ultricies dignissim. Pellentesque at libero non purus venenatis tincidunt.</p>
            <div class="descripcion-servicios">
                <img src="" alt="minilogos">
                <p>Lorem ipsum dolor sit amet, consectetur
                    adipiscing elit. Maecenas ut luctus purus.
                    Suspendisse mollis tempus sem eget elementum.
                    Pellentesque felis justo, venenatis fermentum
                    pellentesque in, malesuada eu tortor. Aenean in tempus nulla. Aenean cursus odio ut eros aliquam, vitae laoreet dolor scelerisque. Donec hendrerit, ligula eget dapibus bibendum, lectus tellus sodales magna, in blandit nisl leo ut nibh. Nam viverra erat elit, nec tempor quam luctus id. Aenean id est a libero ultricies dignissim. Pellentesque at libero non purus venenatis tincidunt.</p>
            </div>

        </div>
    </section>

    <section>
        <div>
            <h3>Nuestra logística</h3>
            <hr>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas ut luctus purus. Suspendisse mollis tempus sem eget elementum. Pellentesque felis justo, venenatis fermentum pellentesque in, malesuada eu tortor. Aenean in tempus nulla. Aenean cursus odio ut eros aliquam, vitae laoreet dolor scelerisque. Donec hendrerit, ligula eget dapibus bibendum, lectus tellus sodales magna, in blandit nisl leo ut nibh. Nam viverra erat elit, nec tempor quam luctus id. Aenean id est a libero ultricies dignissim. Pellentesque at libero non purus venenatis tincidunt.</p>
        </div>
    </section>

    <section class="beneficios-funciones">
        <div class="beneficios-titulo">
            <h3>Beneficios de TORCH</h3>
        </div>
            <hr>
        <div class="beneficios-img">
            <img src="" alt="imagen descriptiva">
            <img src="" alt="imagen descriptiva">
            <img src="" alt="imagen descriptiva">
        </div>
    </section>

    <section class="Métodos de pago">
        <h3>Nuestros métodos de pago</h3>
        <hr>
        <ul>
            <li>Opciones disponibles consultar con equipo</li>
            <li>Opciones disponibles consultar con equipo</li>
            <li>Opciones disponibles consultar con equipo</li>
        </ul>

    </section>

    <section class="preguntas">
        <div>
            <h3>Preguntas frecuentes</h3>
            <hr>
            <ul>
                <li>Pregunta 1</li>
                <li>Pregunta 2</li>
                <li>Pregunta 3</li>
                <li>Pregunta 4</li>
            </ul>
        </div>
    </section>

    <form class="Contacto">
        <h3>Contactanos</h3>

        <fieldset>
            <legend>Llena la siguiente información</legend>
            <label for="nombre">Nombre</label>
            <input placeholder="Ingresa tu nombre" type="text" id="nombre">
            <label for="Email">Correo electrónico</label>
            <input placeholder="Ingresa tu correo" type="email" id="email">
            <label for="mensaje"></label>
        </fieldset>
    </form>
@endsection
