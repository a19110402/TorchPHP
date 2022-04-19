@extends('layouts.base')
@section('content')
    <section>
        <h3>Llamadas a la api de FEDEX</h3>
        <hr>
        <ul>
            <a href="{{url('/fedex/auth')}}"><li>Obtener token de autorizacion</li></a>
            <a href="{{url('/fedex/addresValidationForm')}}"><li>API de validación de direcciones</li></a>
            <a href="{{url('/fedex/findLocationForm')}}"><li>API de búsqueda de ubicaciones de Fedex</li></a>
            <a href="{{url('/fedex/globalTradeForm')}}"><li>API de comercio global</li></a>
            <a href="{{url('/fedex/GroundDayCloseForm')}}"><li>API de cierre de fin de día terrestre</li></a>
            <li>API de envío abierto</li>
            <a href="{{url('/fedex/')}}"><li>API de solicitud de recogida</li></a>
            <a href="{{url('/fedex/')}}"><li>API de validación de código postal</li></a>
            <a href="{{url('/fedex/')}}"><li>API de tarifas y tiempos de tránsito</li></a>
            <a href="{{url('/fedex/')}}"><li>API de disponibilidad del servicio</li></a>
            <a href="{{url('/fedex/')}}"><li>API de envío</li></a>
            <a href="{{url('/fedex/')}}"><li>API de seguimiento</li></a>
            <a href="{{url('/fedex/')}}"><li>API de carga de documentos comerciales</li></a>
        </ul>

    </section>

@endsection
