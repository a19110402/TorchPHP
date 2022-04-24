@extends('layouts.base')
@section('extraCSS')
<link rel="stylesheet" href="{{url('css/tabs.css')}}">
@endsection
@section('content')

<div class="tabbed">
  <ul>
    <li>
      <a href="#section1">Ground End Of Day Close</a>
    </li>
    <li>
      <a href="#section2">Reprint End Of Day</a>
    </li>
  </ul>
  <section id="section1">
    <form method='POST' action="javascript:void(0);" data-action="{{ url('/fedex') }}" id="ground-day-close-fedex-form">
            @csrf
            <h3>Ground End of Day Close API</h3>
            <legend>Fill in the customer information</legend>

            <label for="accountNumber">
                Specify the FedEx Account number.
                Example: Your account numbers<br>
            </label>
            <input placeholder="accountNumber" type="text" name="accountNumber" required><br><br>
            
            <label for="closeReqType">
                Specify the close request type to initiate processing of shipment data.
                For ground close the closeReqType is GCDR and for Reprint EndofDay the applicable value is RGCDR.
            </label>
            <select name="closeReqType" required>
                <option value="GCDR">GCDR</option>
                <option value="RGCDR">RGCDR</option>
            </select><br><br>

            <label for="closeDate">Indicates the close date:</label><br>
            <input type="date" name="closeDate"><br><br>

            <label for="groundServiceCategory">
                This is to specify FedEx ground category for which 
                the shipment to be submitted for end of the day closing.
            </label><br>
            <select name="groundServiceCategory" required>
                <option value="SMARTPOST">SMARTPOST</option>
                <option value="GROUND">GROUND</option>
            </select><br><br>

            <input type="submit" value="Submit">
        </form>  
  </section>
  <section id="section2">
    <form method='POST' action="javascript:void(0);" data-action="{{ url('/fedex') }}" id="reprint-day-close-fedex-form">
            @csrf
            <h3>Reprint End Of Day</h3>

            <label for="accountNumberReprint">
                Specify the FedEx Account number.
                Example: Your account numbers<br>
            </label>
            <input placeholder="accountNumberReprint" type="text" name="accountNumberReprint" required><br><br>
            
            <label for="closeReqTypeReprint">
                Specify the close request type to initiate processing of shipment data.
                For ground close the closeReqType is GCDR and for Reprint EndofDay the applicable value is RGCDR.
            </label>
            <select name="closeReqTypeReprint" required>
                <option value="GCDR">GCDR</option>
                <option value="RGCDR">RGCDR</option>
            </select><br><br>

            <label for="closeDateReprint">Indicates the close date:</label><br>
            <input type="date" name="closeDateReprint"><br><br>

            <label for="groundServiceCategoryReprint">
                This is to specify FedEx ground category for which 
                the shipment to be submitted for end of the day closing.
            </label><br>
            <select name="groundServiceCategoryReprint" required>
                <option value="SMARTPOST">SMARTPOST</option>
                <option value="GROUND">GROUND</option>
            </select><br><br>

            <input type="submit" value="Submit">
        </form>
    </section>
</div>
@endsection
@section('scripts')
    <script type="text/javascript" src="{{ asset('js/fedex/ground_day_close.js') }}"></script>
@endsection
