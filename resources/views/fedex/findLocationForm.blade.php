@extends('layouts.base')
@section('content')
    <form method='POST' action="javascript:void(0);" data-action="{{ url('/fedex') }}" id="find-location-fedex-form">
        @csrf
        <h3>FedEx Location Search API</h3>
        <fieldset>
            <legend>Fill in the customer information</legend>

            <label for="city">
                This is a placeholder for City Name.
                City or PostalCode is mandatory when search criteria is ADDRESS or PHONE_NUMBER
                Example: Beverly Hills<br>
            </label>
            <input placeholder="city" type="text" name="city" required><br><br>

            <label for="latitude">
                The geo coordinate value that specifies the north-south position of the address.<br>
            </label>
            <input placeholder="latitude" type="text" name="latitude" required><br><br>
            
            <label for="longitude">
                The geo coordinate value that specifies the East-West position of the address.<br>
            </label>
            <input placeholder="longitude" type="text" name="longitude" required><br><br>

            <label for="countryCode">
                Specify the ISO Alpha2 code of the country. (countryCode)<br>
                Example: US
            </label>
            <select name="countryCode" required>
            @foreach($countryCodes as $code => $country)
                <option value="{{$country}}">{{$code}} ({{$country}})</option>
            @endforeach
            </select><br><br>
            <input type="submit" value="Submit">
        </fieldset>
    </form>
@endsection
@section('scripts')
    <script type="text/javascript" src="{{ asset('js/fedex/find_location.js') }}"></script>
@endsection
