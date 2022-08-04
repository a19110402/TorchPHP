@extends('layouts.base')

@section('content')
<link rel="stylesheet" href="{{url('css/register.css')}}">

<div class="primer-cont">
    <div class="contenedor">
        
        <div class="centrado estilo-titulo">Editar cuenta</div>

        <div>
            <form method="POST" action="{{ route('update.account', ['id' => $user->id]) }}" class="cont-form">
                @method('PATCH')
                @csrf

                <div class="cont-nombre">
                    <div class="row mb-3">

                        <div class="col-md-6">
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror formato-entrada-nombre" name="name" value="{{ $user->name }}" required autocomplete="name" autofocus placeholder="Nombre">

                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <input id="createdBy" type="text" class="formato-entrada" name="createdBy" placeholder="Creador" value="{{ $user->createdBy }}">
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">

                        <select name="status" id="status" class="form-control formato-entrada bg-white" required  placeholder="Tipo de usuario">
                              <option selected hidden>{{$user->status}}</option>
                              <option value="activo">active</option>
                              <option value="inactivo">inactive</option>
                              <option value="eliminado">deleted</option>
                        </select>
                        
                        @error('status')
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
