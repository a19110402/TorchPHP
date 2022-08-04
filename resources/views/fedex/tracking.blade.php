@extends('layouts.base')

@section('content')
    <h1>Encuentra tu paquete</h1>

    <div class="flex flex-col items-center p-20 gap-8">
        @csrf
        <label for="tracking">Número de seguimiento</label>
        <select class="border-2 border-black rounded-xl" name="company" id="company">
            <option value="fedex">FedEx</option>
            <option value="dhl">DHL</option>
            <option value="ups">UPS</option>
        </select>
        <input class="border-2 border-black rounded-xl" placeholder="Ingresa tu número de seguimiento" type="text" name="tracking" id="tracking">
        <input class="border-2 border-black rounded-xl cursor-pointer p-2" id="requestTracking" type="submit" value="Seguimiento">
    </div>

@endsection

@section('scripts')
    <script type="module" src=" {{asset('js/fedex/tracking.js')}} "></script>
@endsection