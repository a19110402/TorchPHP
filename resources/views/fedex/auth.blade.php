@extends('layouts.base')
@section('content')
    <form method='POST' action="javascript:void(0);" data-action="{{ url('/fedex') }}" id="get-key-auth-fedex-form">
        @csrf
        <h3>API Authorization</h3>
        <fieldset>
            <legend>Fill in the customer information</legend>
            <label for="client_id">Specify the Client ID also known as Customer Key. </label>
            <input placeholder="Customer key" type="text" name="client_id"><br><br>
            <label for="child_secret">Specify the Client secret also known as Customer Secret.</label>
            <input placeholder="Customer secret" type="text" name="child_secret"><br><br>
            <input type="submit" value="Submit">
        </fieldset>
    </form>
@endsection
@section('scripts')
    <script type="text/javascript" src="{{ asset('js/fedex/auth.js') }}"></script>
@endsection
