@extends('layouts.base')

@section('extraCSS')
<style>
body {font-family: Arial;}

/* Style the tab */
.tab {
  overflow: hidden;
  border: 1px solid #ccc;
  background-color: #f1f1f1;
}

/* Style the buttons inside the tab */
.tab button {
  background-color: inherit;
  float: left;
  border: none;
  outline: none;
  cursor: pointer;
  padding: 14px 16px;
  transition: 0.3s;
  font-size: 17px;
}

/* Change background color of buttons on hover */
.tab button:hover {
  background-color: #ddd;
}

/* Create an active/current tablink class */
.tab button.active {
  background-color: #ccc;
}

/* Style the tab content */
.tabcontent {
  display: none;
  padding: 6px 12px;
  border: 1px solid #ccc;
  border-top: none;
}
.accordion, .dhlBlock {
  background-color: #eee;
  color: #444;
  cursor: pointer;
  padding: 18px;
  width: 100%;
  border: none;
  text-align: left;
  outline: none;
  font-size: 15px;
  transition: 0.4s;
}

.active, .accordion:hover, .dhlBlock {
  background-color: #ccc; 
}

.panel {
  padding: 0 18px;
  display: none;
  background-color: white;
  overflow: hidden;
}
</style>
@endsection
</head>

@section('content')
<div class="tab">
  <button class="tablinks" onclick="openCity(event, 'fedex')">FedEx</button>
  <button class="tablinks" onclick="openCity(event, 'dhl')">DHL</button>
  <button class="tablinks" onclick="openCity(event, 'ups')">UPS</button>
</div>
@csrf
<div id="fedex" class="tabcontent">

    <button class="accordion">Dirección</button>
    <div class="panel">
        <div class="flex justify-center p-14" id="shipFormFull">
            <div class=" flex w-3/6 border border-black rounded-xl p-14">
                    <div class="flex flex-col mx-40">
                    <div class="grid grid-cols-3 gap-10" id="shipper">
                        <div>
                            <label for="">Dirección origen</label>
                            <input value="Paseo del Bosque 2428" class=" h-14 border-2 border-black rounded-lg" type="text" name="shipperStreetLines">
                        </div>
                        <div>
                            <label for="">Exterior</label>
                            <input value="2428" class=" h-14 border-2 border-black rounded-lg" type="text" name="shipperOutlines">
                        </div>
                        <div>
                            <label for="">País origen</label>
                            <select class=" h-14 border-2 border-black rounded-lg" name="shipperCountryCode">
                                @foreach ($countryCode as $country=>$code)
                                @if ($code == 'MX')
                                <option selected value="{{$code}}">{{ $country }}</option>
                                @else
                                <option value="{{$code}}">{{ $country }}</option>
                                @endif($code == 'MX')
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="">Código postal origen</label>
                            <input value="45128" class=" h-14 border-2 border-black rounded-lg" type="text" name="shipperPostalCode" id="shipper_postalCode">
                        </div>
                        <div>
                            <label for="">Ciudad origen</label>
                            <input value="zapopan" class=" h-14 border-2 border-black rounded-lg" type="text" name="shipperCity">
                        </div>
                        <div>
                            <label for="">Estado o provincia origen</label>
                            <input value="JA" class=" h-14 border-2 border-black rounded-lg" type="text" name="shipperStateOrProvinceCode">
                        </div>
                        <div>
                            <label for="shipperPersonName">Nombre de quien envía</label>
                            <input value="Adrian Gutierrez" class=" h-14 border-2 border-black rounded-lg" type="tel" name="shipperPersonName">
                        </div>
                        <div>
                            <label for="shipperPhoneNumber">Teléfono de quien envía</label>
                            <input value="3434343434" class=" h-14 border-2 border-black rounded-lg" type="text" name="shipperPhoneNumber">
                        </div>
                        
                        <div>
                            <label for="shipperEmail">Email de quien envía</label>
                            <input value="test@test.com" class=" h-14 border-2 border-black rounded-lg" type="text" name="shipperEmail">
                        </div>
    
                        {{-- ship dateStamp    --}}
                        <label for="shipDatestamp">Fecha de recolección</label>
                        <input class=" h-14 border-2 border-black rounded-lg" type="date" name="shipDatestamp">
                    </div>

                    <!-- Recipient -->
                    <div class="grid grid-cols-3 gap-10" id="recipient">
                        <div>
                            <label for="">Dirección destino</label>
                            <input value="Lopez Cotilla 56" class=" h-14 border-2 border-black rounded-lg" type="text" name="recipientStreetlines">
                        </div>
                        <div>
                            <label for="">Exterior</label>
                            <input value="56" class="w-full h-14 border-2 border-black rounded-lg" type="text" name="recipientOutlines">
                        </div>
                        <div>
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
                        </div>
                        <div>
                            <label for="">Código postal destino</label>
                            <input value="44100" class="w-full h-14 border-2 border-black rounded-lg" type="text" name="recipientPostalCode" id="recipient_postalCode">
                        </div>
                        <div>
                            <label for="">Ciudad destino</label>
                            <input value="Gualadajara" class="w-full h-14 border-2 border-black rounded-lg" type="text" name="recipientCity">
                        </div>
                        <div>
                            <label for="">Estado o privincia destino</label>
                            <input value="JA" class="w-full h-14 border-2 border-black rounded-lg" type="text" name="recipientStateOrProvinceCode">
                        </div>
                        <div>
                            <label for="recipientPersonName">Nombre de quien recibe</label>
                            <input value="Eduardo Osorio" class="w-full h-14 border-2 border-black rounded-lg" type="tel" name="recipientPersonName">
                        </div>
                        <div>
                            <label for="">Telefono de quien recibe</label>
                            <input value="3535353535" class="w-full h-14 border-2 border-black rounded-lg" type="tel" name="recipientPhoneNumber">
                        </div>
                        <div>
                            <label for="recipientEmail">Email de quien recibe</label>
                            <input value="test@test.com" class=" h-14 border-2 border-black rounded-lg" type="text" name="recipientEmail">
                        </div>
                    </div>
                    <div class="flex justify-start py-10 ">
                        <button class="py-3 px-6 border border-black rounded-xl" id="validatePostalCode">Continuar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <button class="accordion">Información detallada de tu envío</button>
    <div class="panel">
        <div class="flex justify-center " id="shipFormFull">
            <div class=" flex w-3/6 border border-black rounded-xl">
                    <div class="flex flex-col mx-40">
                        {{-- <div class="flex flex-col" id="other"> --}}
                            {{-- Service Type --}}
                            {{-- <label for="">Tipo de servicio</label>
                            <select class="w-full h-14 border-2 border-black rounded-lg" name="serviceType" id="serviceType">
    
                            </select> --}}
            
                            {{-- Packing Type --}}
                            <label for="">Información del paquete</label>
                            <select class="w-full h-14 border-2 border-black rounded-lg" name="packagingType" id="">
                                <option value="YOUR_PACKAGING">Paquete</option>
                                <option value="FEDEX_ENVELOPE">Sobre</option>                       
                            </select>
                            {{-- Package weight --}}
                            <label for="">Peso y unidades</label>
                            <div class="pacakgeWeight">
                                <input class="w-6/12 h-14 border-2 border-black rounded-lg" type="text" name="weight" id="" value="10">
                                <select class="w-3/12 h-14 border-2 border-black rounded-lg" name="units" id="">
                                    <option value="SI">Kg/cm</option>
                                    <option value="SU">lb/in</option>
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
                        {{-- </div> --}}
                        
                        
                        <input class="cursor-pointer my-10 min-w-full border border-black rounded-xl" type="Verificar" value="submit" id="requestShip">
                    </div>
            </div>
        </div>
    </div>

    <button class="accordion">Cotización</button>
    <div class="panel">
        <div id="showRates" class="flex justify-evenly">
            <div class="flex flex-row gap-20 p-40" id="ratesFedex">
            </div>
        </div>
    </div>

    <button class="accordion">Pago</button>
    <div class="panel">
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
    </div>

    <button class="accordion">Confirmación</button>
    <div class="panel">
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
    </div>

    <!--<div class="flex justify-center " id="shipFormFull">
        {{-- <div class=" flex flex-col  border border-black rounded-xl p-10 w-3/12"> --}}
            <div class=" flex w-3/6 border border-black rounded-xl">
                <div class="flex justify-items-start p-10 hover:text-indigo-500">
                    <button class="border p-2" id="showServiceAvailableForm"><h6>Validar otra ubicación</h6></button>
                </div>
                <form class="flex flex-col mx-40" action="javascript:void(0)" data-action="{{ route('shipments') }}" method="POST" id="requestFedex" >
                    <h3>Envía con FedEx</h3>
                    @csrf
                    
                    
                </form>
            
        </div>
    </div>-->
</div>

<div id="dhl" class="tabcontent">
    <button class="dhlBlock">Crear envío</button>
    <div class="panel">
        <div class="flex justify-center p-14" id="shipFormFull">
            <div class=" flex w-3/6 border border-black rounded-xl p-14">
                    <div class="flex flex-col mx-40">
                    <div class="grid grid-cols-3 gap-10" id="shipper">
                        <div>
                            <label for="">Dirección origen</label>
                            <input value="Paseo del Bosque 2428" class=" h-14 border-2 border-black rounded-lg" type="text" name="shipperStreetLines">
                        </div>
                        <div>
                            <label for="">Exterior</label>
                            <input value="2428" class=" h-14 border-2 border-black rounded-lg" type="text" name="shipperOutlines">
                        </div>
                        <div>
                            <label for="">País origen</label>
                            <select class=" h-14 border-2 border-black rounded-lg" name="dhlShipperCountryCode">
                                @foreach ($countryCode as $country=>$code)
                                @if ($code == 'MX')
                                <option selected value="{{$code}}">{{ $country }}</option>
                                @else
                                <option value="{{$code}}">{{ $country }}</option>
                                @endif($code == 'MX')
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="">Código postal origen</label>
                            <input value="45128" class=" h-14 border-2 border-black rounded-lg" type="text" name="dhlShipperPostalCode" id="dhl_shipper_postalCode">
                        </div>
                        <div>
                            <label for="">Ciudad origen</label>
                            <input value="zapopan" class=" h-14 border-2 border-black rounded-lg" type="text" name="shipperCity">
                        </div>
                        <div>
                            <label for="">Estado o provincia origen</label>
                            <input value="JA" class=" h-14 border-2 border-black rounded-lg" type="text" name="shipperStateOrProvinceCode">
                        </div>
                        <div>
                            <label for="shipperPersonName">Nombre de quien envía</label>
                            <input value="Adrian Gutierrez" class=" h-14 border-2 border-black rounded-lg" type="tel" name="shipperPersonName">
                        </div>
                        <div>
                            <label for="shipperPhoneNumber">Teléfono de quien envía</label>
                            <input value="3434343434" class=" h-14 border-2 border-black rounded-lg" type="text" name="shipperPhoneNumber">
                        </div>
                        
                        <div>
                            <label for="shipperEmail">Email de quien envía</label>
                            <input value="test@test.com" class=" h-14 border-2 border-black rounded-lg" type="text" name="shipperEmail">
                        </div>
    
                        {{-- ship dateStamp    --}}
                        <label for="shipDatestamp">Fecha de recolección</label>
                        <input class=" h-14 border-2 border-black rounded-lg" type="date" name="shipDatestamp">
                    </div>

                    <!-- Recipient -->
                    <div class="grid grid-cols-3 gap-10" id="recipient">
                        <div>
                            <label for="">Dirección destino</label>
                            <input value="Lopez Cotilla 56" class=" h-14 border-2 border-black rounded-lg" type="text" name="recipientStreetlines">
                        </div>
                        <div>
                            <label for="">Exterior</label>
                            <input value="56" class="w-full h-14 border-2 border-black rounded-lg" type="text" name="recipientOutlines">
                        </div>
                        <div>
                            <label for="">País destino</label>
                            <select class="w-full h-14 border-2 border-black rounded-lg" name="dhlRecipientCountryCode">
                                @foreach ($countryCode as $country=>$code)
                                @if ($code == 'MX')
                                <option selected value="{{$code}}">{{ $country }}</option>
                                @else
                                <option value="{{$code}}">{{ $country }}</option>
                                @endif($code == 'MX')
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="">Código postal destino</label>
                            <input value="44100" class="w-full h-14 border-2 border-black rounded-lg" type="text" name="dhlRecipientPostalCode" id="dhl_recipient_postalCode">
                        </div>
                        <div>
                            <label for="">Ciudad destino</label>
                            <input value="Gualadajara" class="w-full h-14 border-2 border-black rounded-lg" type="text" name="recipientCity">
                        </div>
                        <div>
                            <label for="">Estado o privincia destino</label>
                            <input value="JA" class="w-full h-14 border-2 border-black rounded-lg" type="text" name="recipientStateOrProvinceCode">
                        </div>
                        <div>
                            <label for="recipientPersonName">Nombre de quien recibe</label>
                            <input value="Eduardo Osorio" class="w-full h-14 border-2 border-black rounded-lg" type="tel" name="recipientPersonName">
                        </div>
                        <div>
                            <label for="">Telefono de quien recibe</label>
                            <input value="3535353535" class="w-full h-14 border-2 border-black rounded-lg" type="tel" name="recipientPhoneNumber">
                        </div>
                        <div>
                            <label for="recipientEmail">Email de quien recibe</label>
                            <input value="test@test.com" class=" h-14 border-2 border-black rounded-lg" type="text" name="recipientEmail">
                        </div>
                    </div>
                    <div class="flex justify-start py-10 ">
                        <button class="py-3 px-6 border border-black rounded-xl" id="dhlValidatePostalCode">Continuar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <button class="dhlBlock">Información detallada de tu envío</button>
    <div class="panel">
        <div class="flex justify-center " id="shipFormFull">
            <div class=" flex w-3/6 border border-black rounded-xl">
                    <div class="flex flex-col mx-40">
                        {{-- <div class="flex flex-col" id="other"> --}}
                            {{-- Service Type --}}
                            {{-- <label for="">Tipo de servicio</label>
                            <select class="w-full h-14 border-2 border-black rounded-lg" name="serviceType" id="serviceType">
    
                            </select> --}}
            
                            {{-- Packing Type --}}
                            <label for="">Información del paquete</label>
                            <select class="w-full h-14 border-2 border-black rounded-lg" name="packagingType" id="">
                                <option value="YOUR_PACKAGING">Paquete</option>
                                <option value="FEDEX_ENVELOPE">Sobre</option>                       
                            </select>
                            {{-- Package weight --}}
                            <label for="">Peso y unidades</label>
                            <div class="pacakgeWeight">
                                <input class="w-6/12 h-14 border-2 border-black rounded-lg" type="text" name="weight" id="" value="10">
                                <select class="w-3/12 h-14 border-2 border-black rounded-lg" name="units" id="">
                                    <option value="SI">Kg/cm</option>
                                    <option value="SU">lb/in</option>
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
                        {{-- </div> --}}
                        
                        
                        <input class="cursor-pointer my-10 min-w-full border border-black rounded-xl" type="Verificar" value="submit" id="dhlRequestRate">
                    </div>
            </div>
        </div>
    </div>

    <button class="dhlBlock">Cotización</button>
    <div class="panel">
        <div id="dhlShowRates" class="flex justify-evenly">
            <div class="flex flex-row gap-20 p-40" id="ratesDhl">
            </div>
        </div>
    </div>

    <button class="dhlBlock">Pago</button>
    <div class="panel">
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
    </div>

    <button class="dhlBlock">Confirmación</button>
    <div class="panel">
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
    </div>
</div>

<div id="ups" class="tabcontent">
  <h3>UPS</h3>
</div>
@endsection

<body>


@section('scripts')
<script type="module" src="{{ asset('js/ajax.js') }}"></script>
<script type="module" src="{{ asset('js/fedex/rateAndTransitTimes/validations.js') }}"></script>
<script type="module" src="{{ asset('js/dhl/validation.js') }}"></script>
<script type="module" src="{{ asset('js/fedex/shipments.js') }}"></script>
<script type="module" src="{{ asset('js/dhl/shipments.js') }}"></script>

<script>
    function openCity(evt, cityName) {
  var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablinks");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }
  document.getElementById(cityName).style.display = "block";
  evt.currentTarget.className += " active";
}
</script>
    
@endsection
   
</body>
</html> 
