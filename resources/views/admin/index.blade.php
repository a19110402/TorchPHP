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

                @if (\Session::has('success'))
                    <div class="alert alert-success">
                        <ul>
                            <p>{!! \Session::get('success') !!} {!! \Session::get('user') !!}</p>
                        </ul>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
