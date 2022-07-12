@extends('layouts.base')

@section('content')
<link rel="stylesheet" href="{{url('css/index.css')}}">

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Verifica tu cuenta') }}</div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('Hemos enviado un nuevo link de verificación a tu correo.') }}
                        </div>
                    @endif

                    </p>
                        {{ __('Para acceder a este apartado, por favor, verifica tu cuenta.') }}
                    <p>

                    <div>
                        <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                            @csrf
                            <button type="submit" class="boton-inicia btn btn-link p-0 m-0 align-baseline">{{ __('Reenviar correo de verificación') }}</button>
                        </form>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
