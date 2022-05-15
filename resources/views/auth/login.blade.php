@extends('layouts.base')

@section('content')
<link rel="stylesheet" href="{{url('css/login.css')}}">
<div class="primer-cont">
    <div class="contenedor">
        <div class="centrado">
            <p class="estilo-titulo">Iniciar Sesión</p>
        </div>

        <div class="">
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="cont-form">
                    <label for="email" class="">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user" width="44" height="44" viewBox="0 0 24 24" stroke-width="1.5" stroke="#FFF" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                            <circle cx="12" cy="7" r="4" />
                            <path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                        </svg>
                    </label>

                    <div class="col-md-6">
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror formato-entrada" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="correo@ejemplo.com" autofocus>

                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="cont-form">
                    <label for="password" class="col-md-4 col-form-label text-md-end">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-lock" width="44" height="44" viewBox="0 0 24 24" stroke-width="1.5" stroke="#FFF" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <rect x="5" y="11" width="14" height="10" rx="2" />
                        <circle cx="12" cy="16" r="1" />
                        <path d="M8 11v-4a4 4 0 0 1 8 0v4" />
                    </svg>
                    </label>

                    <div class="col-md-6">
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror formato-entrada" name="password" required autocomplete="current-password" placeholder="Contraseña">

                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <!-- <div class="row mb-3">
                    <div class="col-md-6 offset-md-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                            <label class="form-check-label" for="remember">
                                {{ __('Remember Me') }}
                            </label>
                        </div>
                    </div>
                </div> -->

                <div class="row mb-0">
                    <div class="col-md-8 offset-md-4 cont-botones">
                        <div>
                            <button type="submit" class="btn btn-primary texto-botones">
                                Iniciar Sesión
                            </button>
                        </div>

                        <div>
                            @if (Route::has('password.request'))
                                <a class="btn btn-link texto-botones" href="{{ route('password.request') }}">
                                    Recuperar contraseña
                                </a>
                            @endif
                        </div>

                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
    

@endsection
