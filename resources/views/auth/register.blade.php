@extends('layouts.base')

@section('content')
<link rel="stylesheet" href="{{url('css/register.css')}}">

<div class="primer-cont">
    <div class="contenedor">
        <div class="centrado estilo-titulo">Registrarte</div>

        <div>
            <form method="POST" action="{{ route('register') }}" class="cont-form">
                @csrf

                <div class="cont-nombre">
                    <div class="row mb-3">

                        <div class="col-md-6">
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror formato-entrada-nombre" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="Nombre">

                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <input id="lastname" type="text" class="form-control formato-entrada-nombre" name="lastname" required placeholder="Apellido">
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror formato-entrada" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Correo@ejemplo.com">

                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <input id="number" type="string" class="formato-entrada" name="number" placeholder="Teléfono">
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror formato-entrada" name="password" required autocomplete="new-password" placeholder="Contraseña">

                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <input id="password-confirm" type="password" class="form-control formato-entrada" name="password_confirmation" required autocomplete="new-password" placeholder="Repetir contraseña">
                    </div>
                </div>

                @if (auth()->user() != null and auth()->user()->role == 'admin')
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <input id="role" type="text" class="form-control" name="role" required placeholder="Tipo de usuario">
                        </div>
                    </div>
                @endif

                <div class="row mb-0 contenedor-check">
                    <div class="col-md-6 offset-md-4 center">
                        <input type="checkbox" class="estilo-check" required>
                    </div>
                    <div class="col-md-6 offset-md-4">
                        <p>Aceptar <a href="#">términos y condiciones</a></p>
                    </div>
                </div>

                <div class="row mb-0">
                    <div class="col-md-6 offset-md-4">
                        <button type="submit" class="btn btn-primary cont-botones">
                            Crear cuenta
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
