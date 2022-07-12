@extends('layouts.base')

@section('content')
<div class="container ">
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

                    {{ __('You are logged not admin!') }}
                </div>

                @if (\Session::has('success'))
                    <div class="alert alert-success text-green-500">
                        <ul>
                            <p>{!! \Session::get('success') !!}</p>
                        </ul>
                    </div>
                @endif

                <div class="card-body hover:text-azul-primario hover:underline">
                    <a href="{{route('corpAccount')}}">Cambiar a cuenta corporativa</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
