@extends('layouts.base')
@section('content')
    <form method='POST' action="javascript:void(0);" data-action="{{ url('/fedex') }}" id="get-validate-addres-fedex-form">
        @csrf
        <h3>Address Validation API</h3>
        <fieldset>
            <legend>Use this endpoint to get address resolution details.</legend>
            <label for="x-customer-transaction-id">
                This element allows you to assign a unique identifier to your transaction. (customer-transaction)<br>
            </label>
            <input placeholder="customer-transaction" type="text" name="x-customer-transaction-id"><br><br>
            
            <label for="streetLines">
                Indicate the combination of number, street name. etc. (streetLines)<br>
            </label>
            <input placeholder="streetLines" type="text" name="streetLines" required><br><br>
            
            <label for="countryCode">
                Specify the ISO Alpha2 code of the country. (countryCode)<br>
                Example: US
            </label>
            
            <select name="countryCode" required>
            @foreach($countryCode as $code => $country)
                <option value="{{$country}}">{{$code}} ({{$country}})</option>
            @endforeach
            </select><br><br>

            <label for="x-locale">Choose a Locale: (x-locale)</label>
            <select name="x-locale">
                @foreach($jayParsedAry as $locate => $val)
                <option value="{{$val}}">{{$locate}}</option>
                @endforeach
            </select>
            <br>
            <input type="submit" value="Submit">
        </fieldset>
    </form>
@endsection
@section('scripts')
    <script type="text/javascript" src="{{ asset('js/fedex/val-addres.js') }}"></script>
@endsection
