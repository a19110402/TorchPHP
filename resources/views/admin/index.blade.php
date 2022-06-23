@extends('layouts.base')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in and you are admin!') }}
                </div>

                {{-- Mensaje de creación de usuario exitoso --}}
                @if (\Session::has('success'))
                    <div class="alert alert-success text-green-500">
                        <ul>
                            <p>{!! \Session::get('success') !!} {!! \Session::get('user') !!}</p>
                        </ul>
                    </div>
                @endif

                {{-- Boton para creación de usuario --}}
                <div class="card-body hover:text-azul-primario hover:underline">
                    <a href="{{url('/registerUser')}}">Creación de usario nuevo</a>
                </div>
                
                <div class="card-body hover:text-azul-primario hover:underline">
                    <a href="{{url('/users')}}">Ver usuarios creados</a>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection

