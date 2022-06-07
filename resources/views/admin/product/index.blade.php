@extends('layouts.base')

@section('content')
<link rel="stylesheet" href="{{url('css/index.css')}}">
    <main>
        <div class="card">
            <h4>Product page</h4>
            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Image</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->description }}</td>
                                <td>
                                    <div class="form-control-icon">
                                        <img src="{{ URL::to('assets/uploads/products/'.$item->image) }}">
                                    </div>
                                </td>
                                <td>{{ $item->id }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
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
