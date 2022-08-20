@extends('layouts.base')
@section('content')

    <h1>¡ Envía con nosotros !</h1>
{{-- <div class="flex justify-center m-10 m-"> --}}
<div class="flex flex-row justify-evenly ">
    {{-- <div class=" flex flex-col  border border-black rounded-xl p-10 w-3/12"> --}}
    <div class=" flex w-3/6  border border-black rounded-xl">
        <form class="flex flex-col mx-40" action="javascript:void(0)" data-action="{{ route('shipments') }}" method="POST" id="requestShipments" >
            @csrf
            {{-- Deliveries --}}
            <label for="">Paquetería</label>
            <select class=" h-14 border-2 border-black rounded-lg" name="delivery">
                <option value="fedex">FedEx</option>
                <option value="dhl">DHL</option>
                <option value="ups">UPS</option>
            </select>

            <!-- Shipper -->
            <div class="flex flex-col " id="shipper">
                <label for="">Dirección origen</label>
                <input value="Paseo del Bosque 2428" class=" h-14 border-2 border-black rounded-lg" type="text" name="shipperStreetLines">

                <label for="">Exterior</label>
                <input value="2428" class=" h-14 border-2 border-black rounded-lg" type="text" name="shipperOutlines">
        
                <label for="">Código postal origen</label>
                <input value="45128" class=" h-14 border-2 border-black rounded-lg" type="text" name="shipperPostalCode">

                <label for="">Ciudad origen</label>
                <input value="zapopan" class=" h-14 border-2 border-black rounded-lg" type="text" name="shipperCity">
        
                <label for="">Estado o provincia origen</label>
                <input value="JA" class=" h-14 border-2 border-black rounded-lg" type="text" name="shipperStateOrProvinceCode">
                
                <label for="">País origen</label>
                <select class=" h-14 border-2 border-black rounded-lg" name="shipperCountryCode" >
                    @foreach ($countryCode as $country=>$code)
                    @if ($code == 'MX')
                    <option selected value="{{$code}}">{{ $country }}</option>
                    @else
                    <option value="{{$code}}">{{ $country }}</option>
                    @endif($code == 'MX')
                    @endforeach
                </select>
                
                <label for="shipperPersonName">Nombre de quien envía</label>
                <input value="Adrian Gutierrez" class=" h-14 border-2 border-black rounded-lg" type="tel" name="shipperPersonName">

                <label for="shipperPhoneNumber">Teléfono de quien envía</label>
                <input value="3434343434" class=" h-14 border-2 border-black rounded-lg" type="text" name="shipperPhoneNumber">
                
                <label for="shipperEmail">Email de quien envía</label>
                <input value="test@test.com" class=" h-14 border-2 border-black rounded-lg" type="text" name="shipperEmail">
                
                <label for="shipperCompany">Compañía</label>
                <input value="torch" class=" h-14 border-2 border-black rounded-lg" type="text" name="shipperCompany">

            </div>
            {{-- ship dateStamp    --}}
            <label for="shipDatestamp">Fecha de recolección</label>
            <input class=" h-14 border-2 border-black rounded-lg" type="date" name="shipDatestamp">
            <!-- Recipient -->
            <div class="flex flex-col" id="recipient">
                <label for="">Dirección destino</label>
                <input value="Lopez Cotilla 56" class=" h-14 border-2 border-black rounded-lg" type="text" name="recipientStreetlines">

                <label for="">Exterior</label>
                <input value="56" class="w-full h-14 border-2 border-black rounded-lg" type="text" name="recipientOutlines">

                <label for="">Código postal destino/label>
                <input value="44100" class="w-full h-14 border-2 border-black rounded-lg" type="text" name="recipientPostalCode">
        
                <label for="">Ciudad destino</label>
                <input value="Gualadajara" class="w-full h-14 border-2 border-black rounded-lg" type="text" name="recipientCity">
        
                <label for="">Estado o privincia destino</label>
                <input value="JA" class="w-full h-14 border-2 border-black rounded-lg" type="text" name="recipientStateOrProvinceCode">
                
                <label for="">País destino</label>
                <select class="w-full h-14 border-2 border-black rounded-lg" name="recipientCountryCode">
                    @foreach ($countryCode as $country=>$code)
                    @if ($code == 'MX')
                    <option selected value="{{$code}}">{{ $country }}</option>
                    @else
                    <option value="{{$code}}">{{ $country }}</option>
                    @endif($code == 'MX')
                    @endforeach
                </select>

                <label for="recipientPersonName">Nombre de quien recibe</label>
                <input value="Eduardo Osorio" class="w-full h-14 border-2 border-black rounded-lg" type="tel" name="recipientPersonName">
                
                <label for="">Telefono de quien recibe</label>
                <input value="3535353535" class="w-full h-14 border-2 border-black rounded-lg" type="tel" name="recipientPhoneNumber">

                <label for="recipientEmail">Email de quien recibe</label>
                <input value="test@test.com" class=" h-14 border-2 border-black rounded-lg" type="text" name="recipientEmail">
                
                <label for="recipientCompany">Compañía</label>
                <input value="torch" class=" h-14 border-2 border-black rounded-lg" type="text" name="recipientCompany">
            </div>
            <div class="flex flex-col" id="other">
                {{-- Service Type --}}
                <label for="">Tipo de servicio</label>
                <select class="w-full h-14 border-2 border-black rounded-lg" name="serviceType" id="">
                    <option value="PRIORITY_OVERNIGHT">Fedex Nacional</option>
                    <option value="STANDARD_OVERNIGHT">Fedex nacional día siguiente</option>
                    <option value="FEDEX_EXPRESS_SAVER">Fedex Nacional Económico</option>
                    <option selected value="SAME_DAY_CITY">Fedex Nacional Mismo Día, Misma Ciudad</option>
                </select>

                {{-- Packing Type --}}
                <label for="">Información del paquete</label>
                <select class="w-full h-14 border-2 border-black rounded-lg" name="packagingType" id="">
                    @foreach ($packingType as $packing=>$type)
                    <option value="{{$type}}">{{ $packing }}</option>
                    @endforeach
                </select>
                {{-- Package weight --}}
                <label for="">Peso y unidades</label>
                <div class="pacakgeWeight">
                    <input class="w-6/12 h-14 border-2 border-black rounded-lg" type="text" name="weight" id="" value="10">
                    <select class="w-3/12 h-14 border-2 border-black rounded-lg" name="units" id="">
                        <option value="KG">Kg</option>
                        <option value="LB">lb</option>
                    </select>
                </div>
                {{-- Package dimensions --}}
                <div id="package" class="flex py-4 gap-2">

                    <div class="md:columns-2" >
                        <div>
                            <label class="m-0" for="lenght">Largo</label>
                            
                        </div>
                        <div>
                            <input  value="10" class="w-full h-14 border-2 border-black rounded-lg" type="text" name="lenght" id="lenght" placeholder="cm...">
                            
                        </div>
                    </div>

                    <div class="md:columns-2" >
                        <div>
                            <label class="m-0" for="width">Ancho</label>
                            
                        </div>
                        <div>
                            <input  value="10" class="w-full h-14 border-2 border-black rounded-lg" type="text" name="width" id="width" placeholder="cm...">
                            
                        </div>
                    </div>

                    <div class="md:columns-2" >
                        <div>
                            <label class="m-0" for="height">Alto</label>
                            
                        </div>
                        <div>
                            <input  value="10" class="w-full h-14 border-2 border-black rounded-lg" type="text" name="height" id="height" placeholder="cm...">
                            
                        </div>
                    </div>

                </div>
                {{-- Pickup Type --}}
                <label for="">Tipo de recolección</label>
                <select class="w-full h-14 border-2 border-black rounded-lg" name="pickupType" id="">
                    @foreach ($pickupType as $pickup=>$type)
                    <option value="{{$type}}">{{ $pickup }}</option>
                    @endforeach
                </select>
            </div>
            
            
            <input class="cursor-pointer my-10 min-w-full border border-black rounded-xl" type="submit" value="submit" id="requestShip">
        </form>
        
    </div>
</div>
<div id="validateShipment">
    <p id="trackingNumber" class="flex flex-col justify-items-center items-center text-8xl m-20"></p>
</div>

@endsection

@section('scripts')
    <script type="module" src="{{ asset('js/fedex/shipments.js') }}"></script>
    <script type="module"  src="{{ asset('js/fedex/shipments.js') }}"></script>
@endsection