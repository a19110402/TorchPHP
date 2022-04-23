@extends('layouts.base')
@section('content')
    <form method='POST' action="javascript:void(0);" data-action="{{ url('/fedex') }}" id="global-trade-fedex-form">
        @csrf
        <h3>Global Trade - API</h3>
        <fieldset>
            <legend>Fill in the customer information</legend>

            <label for="carrierCode">
                Specify the FedEx Transportation carrier to be included.<br>
            </label>
            <input placeholder="carrierCode" type="text" name="carrierCode" required><br><br>
            
            <label for="harmonizedCode">
                Specify the FedEx Transportation carrier to be included. (harmonizedCode)<br>
            </label>
            <input placeholder="harmonizedCode" type="text" name="harmonizedCode" required><br><br>

            <fieldset>
                <legend>Origin address</legend>
                <label for="countryCodeOrigin">
                    Indicate the 2-character ISO country code. (countryCode)<br>
                    Example: US
                </label>
                <select name="countryCodeOrigin" required>
                    @foreach($countryCodes as $code => $country)
                        <option value="{{$country}}">{{$code}} ({{$country}})</option>
                    @endforeach
                </select><br><br>

            </fieldset>
            <fieldset>
                <legend>Destonation address</legend>
                <label for="countryCodeDestination">
                    Indicate the 2-character ISO country code. (countryCode)<br>
                    Example: US
                </label>
                <select name="countryCodeDestination" required>
                    @foreach($countryCodes as $code => $country)
                        <option value="{{$country}}">{{$code}} ({{$country}})</option>
                    @endforeach
                </select><br><br>
            </fieldset>
            <input type="submit" value="Submit">
        </fieldset>
    </form>
@endsection
@section('scripts')
    <script type="text/javascript" src="{{ asset('js/fedex/global_trade.js') }}"></script>
@endsection
