@extends('layouts.baseMenu')

@section('content')

<h1>¡ Cotiza Con Nosotros !</h1>

<form action="javascript:void(0)" data-action="{{ route('rateAndTransitTimes') }}" method="POST" id="requestRate">
    
    @csrf
    <label for="accountNumber">AccountNumber 510087020</label>
    <input type="text" name="accountNumber" id=""><br><br>
        <fieldset>
            <legend>Shipper</legend>
            <label for="shipper_postalCode">Postal Code</label>
            <input type="text" name="shipper_postalCode" id=""><br><br>
    
            <label for="shipper_Country">Country</label>
            <select name="countryCode" id="">
                @foreach ($countryCode as $country => $code )
                    <option value="{{ $code }}">{{ $country }}({{ $code }})</option>
                @endforeach
            </select>
        </fieldset>

        <fieldset>
            <legend>Recipient</legend>
            <label for="recipient_postalCode">Postal Code</label>
            <input type="text" name="recipient_postalCode" id=""><br><br>
    
            <label for="recipient_country">Country</label>
            <input type="text" name="recipient_country" id=""><br><br>
    
            <label for="pickupType">Pick up type</label>
            <select name="pickupType">
                <option value="CONTACT_FEDEX_TO_SCHEDULE">Contact FedEx To Schedule</option>
                <option value="DROPOFF_AT_FEDEX_LOCATION">Dropoff At FedEx Location</option>
                <option value="USE_SCHEDULED_PICKUP">Use Scheduled Pickup</option>
            </select>

        </fieldset>

        <fieldset>
            <legend>Package</legend>
            <label for="weight">Weight</label>
            <input type="text" name="weight" id=""><br><br>
    
            <label for="lenght">lenght</label>
            <input type="text" name="lenght" id=""><br><br>
    
            <label for="width">Width</label>
            <input type="text" name="width" id=""><br><br>
    
            <label for="height">Height</label>
            <input type="text" name="height" id=""><br><br>
    
        </fieldset>

        <input type="submit" name="requestRate" value="submit">
    </form>



@endsection

@section('rates')
    <p>

    </p>
@endsection

    @section('scripts')
    <script type="module" src="{{ asset('js/fedex/rateAndTransiteTimes.js') }}"></script>
@endsection