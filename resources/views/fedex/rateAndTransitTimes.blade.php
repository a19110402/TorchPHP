
@extends('layouts.base')

@section('content')
    <h1>¡ Cotiza Con Nosotros !</h1>

    <div class="flex justify-center m-20" id="id-rateRequest">  
        <form class="w-min border-2 border-stone-500 p-20 rounded-3xl" action="javascript:void(0)" data-action="{{ route('rateAndTransitTimes') }}" method="POST" id="requestRate">
            @csrf
                <div class="flex-col items-center justify-center">
                    
                    <div class="p-1 md:columns-2" >
                        <div>
                            <label class="m-0" for="shipper_postalCode"> Origin Postal Code</label>
                        </div>
                        <div>
                            <input required class="border border-black rounded" type="text" name="shipper_postalCode" id="shipper_postalCode">
                        </div>
                    </div>
                    
                    {{-- <div class="p-1 md:columns-2" >
                        <div>
                            <label for="">City of shipper</label>
                        </div>
                        <div>
                            <input value="" class="border border-black rounded" type="text" name="shipper_city">
                        </div>
                    </div> --}}

                    <div class="md:columns-2 p-1">
                        <div>
                            <label class="m-0" for="shipper_Country">Country</label>
                            
                        </div>
                        <div>
                            <select class="border-black border rounded-r-md w-7/12" name="shipper_countryCode" id="">
                                @foreach ($countryCode as $country => $code )
                                    @if ($code == 'US')
                                        <option selected value="{{ $code }}">{{ $country }}({{ $code }})</option>
                                    @else
                                        <option value="{{ $code }}">{{ $country }}({{ $code }})</option>
                                    @endif

                                @endforeach
                            </select>
                            
                        </div>
                    </div>
                    <div class="md:columns-2 p-1">
                        <div>
                            <label class="m-0" for="recipient_postalCode">Destination Postal Code</label>
                            
                        </div>
                        
                        <div>
                            <input required  class="border border-black rounded" type="text" name="recipient_postalCode" id="recipient_postalCode">
                            
                        </div>
    
                    </div>

                    {{-- <div class="p-1 md:columns-2" >
                        <div>
                            <label for="">City of recipient</label>
                        </div>
                        <div>
                            <input value="" class="border border-black rounded" type="text" name="recipient_city">
                        </div>
                    </div> --}}

                    <div class="md:columns-2 p-1">
                        <div>
                            <label class="m-0" for="recipient_country">Country</label>
                            
                        </div>
                        <div>
                            <select class="border-black border rounded-r-md w-7/12" name="recipient_countryCode" id="">
                                @foreach ($countryCode as $country => $code )
                                    @if ($code == 'US')
                                        <option selected value="{{ $code }}">{{ $country }}({{ $code }})</option>
                                    @else
                                        <option value="{{ $code }}">{{ $country }}({{ $code }})</option>
                                    @endif

                                @endforeach
                            </select>
                            
                        </div>
    
                    </div>
                    <div class="md:columns-2 p-1">
                        <div>
                            <label class="m-0" for="pickupType">Pick up type</label>
                            
                        </div>
                        <div>
                            <select class="border-black border rounded-r-md" name="pickupType">
                                <option value="CONTACT_FEDEX_TO_SCHEDULE">Contact FedEx To Schedule</option>
                                <option value="DROPOFF_AT_FEDEX_LOCATION">Dropoff At FedEx Location</option>
                                <option value="USE_SCHEDULED_PICKUP">Use Scheduled Pickup</option>
                            </select>
                            
                        </div>
    
                    </div>
            
                    <div class="md:columns-2" >
                        <div>
                            <label class="m-0" for="weight">Weight</label>
                            
                        </div>
                        <div>
                            <input required  class="border border-black rounded" type="text" name="weight" id="">
                            
                        </div>
                    </div>
                    <div class="md:columns-2" >
                        <div>
                            <label class="m-0" for="lenght">lenght</label>
                            
                        </div>
                        <div>
                            <input required  class="border border-black rounded" type="text" name="lenght" id="">
                            
                        </div>
                    </div>
                    <div class="md:columns-2" >
                        <div>
                            <label class="m-0" for="width">Width</label>
                            
                        </div>
                        <div>
                            <input required  class="border border-black rounded" type="text" name="width" id="">
                            
                        </div>
                    </div>
                    <div class="md:columns-2" >
                        <div>
                            <label class="m-0" for="height">Height</label>
                            
                        </div>
                        <div>
                            <input required  class="border border-black rounded" type="text" name="height" id="">
                            
                        </div>
                    </div>
                    <div  >
                        <input required class="w-max border-2 border-slate-600 rounded-xl cursor-pointer p-1" type="submit" name="requestRate" value="submit">
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
    <script type="module" src="{{ asset('js/fedex/rateAndTransiteTimes.js') }}"></script>
    <script type="module" src="{{ asset('js/ajax.js') }}"></script>
@endsection