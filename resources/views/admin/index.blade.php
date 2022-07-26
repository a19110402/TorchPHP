@extends('layouts.base')

@section('content')
@csrf
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

                    {{ __('You are logged in and you are corp!') }}
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
                    <a href="{{route('registerUser')}}">Creación de usario</a>
                </div>
                
                <div class="card-body hover:text-azul-primario hover:underline">
                    <a href="{{url('/users')}}">Ver usuarios</a>
                </div>

                <div class="card-body hover:text-azul-primario hover:underline">
                    <a href="{{route('create.account')}}">Creación de cuenta</a>
                </div>

                <div class="card-body hover:text-azul-primario hover:underline">
                    <a href="{{route('watch.account')}}">Ver cuentas</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

