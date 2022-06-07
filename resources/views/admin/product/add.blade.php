@extends('layouts.base')

@section('content')
<link rel="stylesheet" href="{{url('css/index.css')}}">
    <main>
        <div class="card">
            <div class="card-header">
                <h4>Add Product</h4>
            </div>
            <div class="card-body">
                <form enctype="multipart/form-data" action="{{ url('insert-product') }}" method="POST">
                @csrf
                    <div class="flex">
                        <div class="flex">
                            <label for="">Name</label>
                            <input type="text" class="form-control" name="name">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="">Description</label>
                            <input type="text" class="form-control" name="description">
                        </div>
                        <div class="col-md-12">
                            <input type="file" name="image" class="form-control">
                            <input type="text" name="hidden_image">
                        </div>
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </main>
</link>
@endsection

@section('footer')
    <div>
        <p class="no-margin">Las mejores empresas que ya utilizan nuestra plataforma:</p>
    </div>

    <div class="contenedor">
        <div class="flecha-contenedor flecha-formato">
            <p><</p>
        </div>
        <div class="flecha-contenedor flecha-formato">
            <p>></p>
        </div>
    </div>
@endsection
