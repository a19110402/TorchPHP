@extends('layouts.app')

@section('content')
@section('scripts')
    <script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
    {{-- <script type="text/javascript" src="{{ asset('js/fedex/authProduction.js') }}"></script> --}}
@endsection
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">¿Qué deseas hacer?</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @csrf
                    <li><a href="openShip/">Enviar un paquete</a></li>
                    <li><a href="#">Rastrear un paquete</a></li>
                    <li><a href="{{ route('rateAndTransitTimes') }}">Cotizar un envío</a></li>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


