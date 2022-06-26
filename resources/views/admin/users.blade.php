@extends('layouts.base')

@section('content')
<link rel="stylesheet" href="{{url('css/register.css')}}">

@if (\Session::has('success'))
<div class="alert alert-success text-green-500">
    <ul>
        <p>{!! \Session::get('success') !!} {!! \Session::get('user') !!}</p>
    </ul>
</div>
@endif

<div>
    @foreach ($users as $user)
        <div class="flex mb-7">
            <div class="w-1/6">
                <span>{{$user->name}}</span>
            </div>

            <div class="w-1/6">
                <a href="{{route('editUser', ['id' => $user->id])}}" class="hover:text-azul-primario hover:underline">Editar</a>
            </div>

            <div class="w-1/6">
                <form action="{{route('deleteUser', ['id' => $user->id])}}" method="POST">
                    @method('DELETE')
                    @csrf
                    <button class="hover:text-amarillo hover:underline">Eliminar</button>
                </form>
            </div>
        </div>
    @endforeach
</div>

@endsection
