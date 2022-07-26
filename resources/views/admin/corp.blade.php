@extends('layouts.base')

@section('content')
<link rel="stylesheet" href="{{url('css/register.css')}}">

<div class="primer-cont">
    <div class="contenedor">
        
        <div class="centrado estilo-titulo">Datos de la empresa</div>
        
        <div>
            <form method="POST" action="{{ route('upgradeAccount')}}" class="cont-form">
                @csrf

                <div class="row mb-3">

                    <div class="col-md-6">
                        <input id="corporation" type="text" class="form-control @error('corporation') is-invalid @enderror formato-entrada-nombre" name="corporation" required autofocus placeholder="Empresa">

                        @error('corporation')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-0">
                    <div class="col-md-6 offset-md-4">
                        <button type="submit" class="btn btn-primary cont-botones">
                            Actualizar cuenta
                        </button>
                    </div>
                </div>
            </form>
        </div>

    </div>
</div>
@endsection
