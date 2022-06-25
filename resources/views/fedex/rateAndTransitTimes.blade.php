
@extends('layouts.base')

@section('content')
    <h1>¡ Cotiza Con Nosotros !</h1>

    <div class="flex justify-center m-20" id="id-rateRequest">  
        <form class="w-min border-2 border-stone-500 p-20 rounded-3xl" action="javascript:void(0)" data-action="{{ route('rateAndTransitTimes') }}" method="POST" id="requestRate">
            @csrf
                <div class="flex-col items-center justify-center m">
                    
                    <div class="m-4 justify-center md:columns-2" >
                        <div>
                            <label class="m-0" for="shipper_postalCode">Origen</label>
                        </div>
                        <div>
                            <input required class="border border-black rounded" type="text" name="shipper_postalCode" id="shipper_postalCode" placeholder="Código postal...">
                        </div>
                    </div>
                    
                    {{-- <div class="m-4 justify-center md:columns-2" >
                        <div>
                            <label for="">City of shipper</label>
                        </div>
                        <div>
                            <input value="" class="border border-black rounded" type="text" name="shipper_city">
                        </div>
                    </div> --}}

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
                    <div class="md:columns-2 m-4 justify-center">
                        <div>
                            <label class="m-0" for="recipient_postalCode">Destino</label>
                            
                        </div>
                        
                        <div>
                            <input required  class="border border-black rounded" type="text" name="recipient_postalCode" id="recipient_postalCode" placeholder="Código postal...">
                        </div>
    
                    </div>

                    {{-- <div class="m-4 justify-center md:columns-2" >
                        <div>
                            <label for="">City of recipient</label>
                        </div>
                        <div>
                            <input value="" class="border border-black rounded" type="text" name="recipient_city">
                        </div>
                    </div> --}}

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
                    <div class="md:columns-2 justify-center">
                        <div>
                            <label class="m-0" for="pickupType">Tipo de recolección</label>
                            
                        </div>
                        <div>
                            <select class="border-black border rounded-r-md" name="pickupType">
                                <option value="CONTACT_FEDEX_TO_SCHEDULE">Contactar para programar recolección</option>
                                <option value="DROPOFF_AT_FEDEX_LOCATION">Entregar en paqueteria</option>
                                <option value="USE_SCHEDULED_PICKUP">Progarmar recolección</option>
                            </select>
                            
                        </div>
    
                    </div>

                    <div class="md:columns-2 justify-center">
                        <div>
                            <label class="m-0" for="#">Tipo de envío</label>
                            
                        </div>
                        <div>
                            <select class="border-black border rounded-r-md" name="carrierCodes">
                                <option value="FDXE ">Express </option>
                                <option value="FDXG">Terrestre</option>>
                            </select>
                            
                        </div>
    
                    </div>
            
                    <div class="md:columns-2" >
                        <div>
                            <label class="m-0" for="packagingType">Tipo de paquete</label>
                        </div>
                        <div>
                            <select  class="border-black border rounded-r-md" name="packagingType" id="packagingType">
                                <option value="FEDEX_ENVELOPE">Sobre</option>
                                <option selected value="YOUR_PACKAGING">Paquete</option>
                            </select>
                        </div>
                    </div>
    
                    <div class="md:columns-2" >
                        <div>
                            <label class="m-0" for="weight">Peso</label>
                            
                        </div>
                        <div>
                            <input required  class="border border-black rounded" type="text" name="weight" id="weight" placeholder="kg...">
                            
                        </div>
                    </div>

                    <div id="package">

                        <div class="md:columns-2" >
                            <div>
                                <label class="m-0" for="lenght">Largo</label>
                                
                            </div>
                            <div>
                                <input   class="border border-black rounded" type="text" name="lenght" id="lenght" placeholder="cm...">
                                
                            </div>
                        </div>
    
                        <div class="md:columns-2" >
                            <div>
                                <label class="m-0" for="width">Ancho</label>
                                
                            </div>
                            <div>
                                <input   class="border border-black rounded" type="text" name="width" id="width" placeholder="cm...">
                                
                            </div>
                        </div>
    
                        <div class="md:columns-2" >
                            <div>
                                <label class="m-0" for="height">Alto</label>
                                
                            </div>
                            <div>
                                <input   class="border border-black rounded" type="text" name="height" id="height" placeholder="cm...">
                                
                            </div>
                        </div>

                    </div>

                    <div>
                        <input  class="w-max border-2 border-slate-600 rounded-xl cursor-pointer m-4 justify-center" type="submit" name="requestRate" value="submit">
                    </div>
                </div>
            
            </div>
            
        </form>
        <div id="fedEx">
            {{-- <a class="border-2 rounded-lg border-gray-800" href="{{ route('shipments') }}">GENERAR ENVÍO CON FEDEX</a> --}}
            {{-- <h1>FedEx</h1> --}}
            {{-- <p id="id-serviceType">Tipo de servicio: </p>
            <p id="id-serviceName">Servicio por:</p>
            <p id="id-netCharge">Tarifa Neta:</p> --}}
        </div>
@endsection



@section('scripts')
    <script type="module" src="{{ asset('js/fedex/rateAndTransitTimes/rateAndTransiteTimes.js') }}"></script>
    <script type="module" src="{{ asset('js/ajax.js') }}"></script>
    <script type="module" src="{{ asset('js/fedex/rateAndTransitTimes/validations.js') }}"></script>
@endsection