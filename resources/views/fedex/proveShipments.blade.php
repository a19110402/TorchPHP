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
</style>
@endsection
</head>

@section('content')
<div class="tab">
  <button class="tablinks" onclick="openCity(event, 'fedex')">FedEx</button>
  <button class="tablinks" onclick="openCity(event, 'dhl')">DHL</button>
  <button class="tablinks" onclick="openCity(event, 'ups')">UPS</button>
</div>

<div id="fedex" class="tabcontent">
    <div  class="flex flex-col justify-center" id="waitingMessage">
        <h3>Espere un momento</h3>
    </div>
    <div class="flex flex-col justify-center" id="serviceAvailabilityValidation">
        <h3>Validemos primero los servicios disponibles según tu código postal</h3>
        <div class="flex justify-center m-20" id="id-rateRequest">  
            <form class="w-min border-2 border-stone-500 p-20 rounded-3xl" action="javascript:void(0)" data-action="" method="POST" id="requestServices">
                @csrf
                    <div class="flex-col items-center justify-center">
    
                        <div class="md:columns-2 m-4 justify-center">
                            <div>
                                <label class="m-0" for="shipper_Country">País</label>
                                
                            </div>
                            <div>
                                <select class="border-black border rounded-r-md w-7/12" name="shipper_countryCode" id="">
                                    @foreach ($countryCode as $country => $code )
                                        @if ($code == 'MX')
                                            <option selected value="{{ $code }}">{{ $country }}</option>
                                        @else
                                            <option value="{{ $code }}">{{ $country }}</option>
                                        @endif
    
                                    @endforeach
                                </select>
                                
                            </div>
                        </div>
    
                        <div class="m-4 justify-center md:columns-2" >
                            <div>
                                <label class="m-0" for="shipper_postalCode">Origen</label>
                            </div>
                            <div>
                                <input required class="focus:outline-none border border-black rounded" type="text" name="shipper_postalCode" id="shipper_postalCode" placeholder="Código postal...">
                            </div>
                        </div>
    
                        <div class="md:columns-2 m-4 justify-center">
                            <div>
                                <label class="m-0" for="recipient_country">País</label>
                                
                            </div>
                            <div>
                                <select class="border-black border rounded-r-md w-7/12" name="recipient_countryCode" id="">
                                    @foreach ($countryCode as $country => $code )
                                        @if ($code == 'MX')
                                            <option selected value="{{ $code }}">{{ $country }}</option>
                                        @else
                                            <option value="{{ $code }}">{{ $country }}</option>
                                        @endif
    
                                    @endforeach
                                </select>
                                
                            </div>
        
                        </div>
    
                        <div class="md:columns-2 m-4 justify-center">
                            <div>
                                <label class="m-0" for="recipient_postalCode">Destino</label>
                                
                            </div>
                            
                            <div>
                                <input required  class="focus:outline-none border border-black rounded" type="text" name="recipient_postalCode" id="recipient_postalCode" placeholder="Código postal...">
                            </div>
        
                        </div>
                        <div>
                            <input  class="w-max border-2 border-slate-600 rounded-xl cursor-pointer m-4 justify-center" type="submit" id="validateAvailableServices" value="submit">
                        </div>
                    </div>
                
                </div>
                
            </form>
    </div>
    
    {{-- <div class="flex justify-center m-10 m-"> --}}
    <div class="flex justify-center " id="shipFormFull">
        {{-- <div class=" flex flex-col  border border-black rounded-xl p-10 w-3/12"> --}}
            <div class=" flex w-3/6 border border-black rounded-xl">
                <div class="flex justify-items-start p-10 hover:text-indigo-500">
                    <button class="border p-2" id="showServiceAvailableForm"><h6>Validar otra ubicación</h6></button>
                </div>
                <form class="flex flex-col mx-40" action="javascript:void(0)" data-action="{{ route('shipments') }}" method="POST" id="requestFedex" >
                    <h3>Envía con FedEx</h3>
                    @csrf
                    <!-- Shipper -->
                    <div class="grid grid-cols-3 " id="shipper">
                        <div>
                            <label for="">Dirección origen</label>
                            <input value="Paseo del Bosque 2428" class=" h-14 border-2 border-black rounded-lg" type="text" name="shipperStreetLines">
                        </div>
                        <div>
                            <label for="">Exterior</label>
                            <input value="2428" class=" h-14 border-2 border-black rounded-lg" type="text" name="shipperOutlines">
                        </div>
                        <div>
                            <label for="">Código postal origen</label>
                            <input value="45128" class=" h-14 border-2 border-black rounded-lg" type="text" name="shipperPostalCode">
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
                    </div>

                    {{-- ship dateStamp    --}}
                    <label for="shipDatestamp">Fecha de recolección</label>
                    <input class=" h-14 border-2 border-black rounded-lg" type="date" name="shipDatestamp">

                    <!-- Recipient -->
                    <hr>
                    <div class="grid grid-cols-3" id="recipient">
                        <div>
                            <label for="">Dirección destino</label>
                            <input value="Lopez Cotilla 56" class=" h-14 border-2 border-black rounded-lg" type="text" name="recipientStreetlines">
                        </div>
                        <div>
                            <label for="">Exterior</label>
                            <input value="56" class="w-full h-14 border-2 border-black rounded-lg" type="text" name="recipientOutlines">
                        </div>
                        <div>
                            <label for="">Código postal destino/label>
                            <input value="44100" class="w-full h-14 border-2 border-black rounded-lg" type="text" name="recipientPostalCode">
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
                    <div class="flex flex-col" id="other">
                        {{-- Service Type --}}
                        <label for="">Tipo de servicio</label>
                        <select class="w-full h-14 border-2 border-black rounded-lg" name="serviceType" id="serviceType">

                        </select>
        
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
</div>

<div id="dhl" class="tabcontent">
  <h3>Paris</h3>
  <p>Paris is the capital of France.</p> 
</div>

<div id="ups" class="tabcontent">
  <h3>Tokyo</h3>
  <p>Tokyo is the capital of Japan.</p>
</div>
@endsection

<body>


@section('scripts')
<script type="module" src="{{ asset('js/fedex/shipments.js') }}"></script>
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
