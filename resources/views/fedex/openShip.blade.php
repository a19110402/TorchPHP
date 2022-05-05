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

        <label for="paymentType">
        Specifies the payment Type.
        Note: This is required for Express, Ground and SmartPost shipments.
        The payment type COLLECT is applicable only for Ground shipments<br>
        </label>
        <select name="paymentType">
            <option value="SENDER">SENDER</option>
            <option value="RECIPIENT">RECIPIENT</option>
            <option value="THIRD_PARTY">THIRD PARTY</option>
            <option value="COLLECT">COLLECT</option>
        </select><br><br>

        <label for="weight_value">
        In pound.
        This is the weight. Maximum length is 99999.<br>
        </label>
        <input placeholder="value" type="text" name="weight_value" ><br><br>
        
        <label for="accountNumber_value">
        Specify contact name. Maximum length is 70.
        Note: Either the companyName or personName is mandatory.
        Example: John Taylor<br>
        </label>
        <input placeholder="value" type="text" name="accountNumber" ><br><br>

            <fieldset>

                <legend>shipper information</legend>
    
    
                <label for="personName">
                Specify contact name. Maximum length is 70.
                Note: Either the companyName or personName is mandatory.
                Example: John Taylor<br>
                </label>
                <input placeholder="personName" type="text" name="shipper_personName" ><br><br>
    
                <label for="phoneNumber">
                Specify contact phone number.
                Minimum length is 10 and supports Maximum as 15 for certain countries using longer phone numbers.
                Note: Recommended Maximum length is 15 and there's no specific validation will be done for the phone number.
                Example: 918xxxxx890<br>
                </label>
                <input placeholder="phoneNumber" type="tel" name="shipper_phoneNumber" ><br><br>
                
                <label for="streetLines">
                This is the combination of number, street name, etc. Maximum length per line is 35.
                Example: 10 FedEx Parkway, Suite 302.<br>
                </label>
                <input placeholder="streetLines" type="text" name="shipper_streetLines" ><br><br>
                
                <label for="city">
                This is a placeholder for City Name.
                Note: This is conditional and not  in all the requests.
                Note: It is recommended for Express shipments for the most accurate ODA and OPA surcharges.<br>
                </label>
                <input placeholder="city" type="text" name="shipper_city" ><br><br>
                
                <label for="stateOrProvinceCode">
                This is a placeholder for state or province code.
                Example: CA.<br>
                </label>
                <input placeholder="stateOrProvinceCode" type="text" name="shipper_stateOrProvinceCode" ><br><br>
                
                <label for="countryCode">
                This is a placeholder for state or province code.
                Example: CA.<br>
                </label>
                <select name="shipper_countryCode" required>
                    @foreach($countryCode as $code => $country)
                    <option value="{{$country}}">{{$code}} ({{$country}})</option>
                    @endforeach
                </select>
                
            </fieldset> <!--SHIPPER FORM -->

            <fieldset>

                <legend>Recipient information</legend>
    
                <label for="personName">
                Specify contact name. Maximum length is 70.
                Note: Either the companyName or personName is mandatory.
                Example: John Taylor<br>
                </label>
                <input placeholder="personName" type="text" name="recipient_personName" ><br><br>
    
                <label for="phoneNumber">
                Specify contact phone number.
                Minimum length is 10 and supports Maximum as 15 for certain countries using longer phone numbers.
                Note: Recommended Maximum length is 15 and there's no specific validation will be done for the phone number.
                Example: 918xxxxx890<br>
                </label>
                <input placeholder="phoneNumber" type="tel" name="recipient_phoneNumber" ><br><br>
                
                <label for="streetLines">
                This is the combination of number, street name, etc. Maximum length per line is 35.
                Example: 10 FedEx Parkway, Suite 302.<br>
                </label>
                <input placeholder="streetLines" type="text" name="recipient_streetLines" ><br><br>
                
                <label for="city">
                This is a placeholder for City Name.
                Note: This is conditional and not  in all the requests.
                Note: It is recommended for Express shipments for the most accurate ODA and OPA surcharges.<br>
                </label>
                <input placeholder="city" type="text" name="recipient_city" ><br><br>
                
                <label for="stateOrProvinceCode">
                This is a placeholder for state or province code.
                Example: CA.<br>
                </label>
                <input placeholder="stateOrProvinceCode" type="text" name="recipient_stateOrProvinceCode" ><br><br>
                
                <label for="countryCode">
                This is a placeholder for state or province code.
                Example: CA.<br>
                </label>
                <select name="recipient_countryCode" required>
                    @foreach($countryCode as $code => $country)
                    <option value="{{$country}}">{{$code}} ({{$country}})</option>
                    @endforeach
                </select>
                
                
            </fieldset><!--RECIPIENT FORM -->
            
            <input type="submit" value="Submit">
        </form>  
  </section>
  <section id="section2">
    <h3>Modify Open shipment</h3>
      @csrf
      <form method='PUT' action="javascript:void(0);" data-action="{{ url('/fedex') }}" id="modify-open-ship">
        @csrf
        <label for="serviceType">                	
        Indicate the FedEx serviceType used for this shipment. The results will be filtered by the serviceType value indicated.
        Example: STANDARD_OVERNIGHT<br>
        </label>
        <select name="serviceType">
        @foreach($serviceType as $type => $service)
            <option value="{{$service}}">{{$type}} ({{$service}})</option>
        @endforeach
        </select><br><br>

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

        <label for="weight_value">
        In pound.
        This is the weight. Maximum length is 99999.<br>
        </label>
        <input placeholder="weight" type="text" name="weight_value" ><br><br>
        
        <label for="accountNumber">
        Specify contact name. Maximum length is 70.
        Note: Either the companyName or personName is mandatory.
        Example: John Taylor<br>
        </label>
        <input placeholder="value" type="text" name="accountNumber" ><br><br>

        <fieldset>

          <legend>shipper information</legend>

          <label for="personName">
          Specify contact name. Maximum length is 70.
          Note: Either the companyName or personName is mandatory.
          Example: John Taylor<br>
          </label>
          <input placeholder="personName" type="text" name="shipper_personName" ><br><br>

          <label for="shipper_phoneNumber">
          Specify contact phone number.
          Minimum length is 10 and supports Maximum as 15 for certain countries using longer phone numbers.
          Note: Recommended Maximum length is 15 and there's no specific validation will be done for the phone number.
          Example: 918xxxxx890<br>
          </label>
          <input placeholder="phoneNumber" type="tel" name="shipper_phoneNumber" ><br><br>
          
          <label for="shipper_streetLines">
          This is the combination of number, street name, etc. Maximum length per line is 35.
          Example: 10 FedEx Parkway, Suite 302.<br>
          </label>
          <input placeholder="streetLines" type="text" name="shipper_streetLines" ><br><br>
          
          <label for="shipper_city">
          This is a placeholder for City Name.
          Note: This is conditional and not  in all the requests.
          Note: It is recommended for Express shipments for the most accurate ODA and OPA surcharges.<br>
          </label>
          <input placeholder="city" type="text" name="shipper_city" ><br><br>
          
          <label for="shipper_stateOrProvinceCode">
          This is a placeholder for state or province code.
          Example: CA.<br>
          </label>
          <input placeholder="stateOrProvinceCode" type="text" name="shipper_stateOrProvinceCode" ><br><br>
          
          <label for="shipper_countryCode">
          This is a placeholder for state or province code.
          Example: CA.<br>
          </label>
          <select name="shipper_countryCode" required>
              @foreach($countryCode as $code => $country)
              <option value="{{$country}}">{{$code}} ({{$country}})</option>
              @endforeach
          </select>
              
        </fieldset> <!--SHIPPER FORM -->

          <fieldset>
            <legend>Recipient information</legend>
  
            <label for="recipient_personName">
            Specify contact name. Maximum length is 70.
            Note: Either the companyName or personName is mandatory.
            Example: John Taylor<br>
            </label>
            <input placeholder="personName" type="text" name="recipient_personName" ><br><br>

            <label for="recipient_phoneNumber">
            Specify contact phone number.
            Minimum length is 10 and supports Maximum as 15 for certain countries using longer phone numbers.
            Note: Recommended Maximum length is 15 and there's no specific validation will be done for the phone number.
            Example: 918xxxxx890<br>
            </label>
            <input placeholder="phoneNumber" type="tel" name="recipient_phoneNumber" ><br><br>
            
            <label for="recipient_streetLines">
            This is the combination of number, street name, etc. Maximum length per line is 35.
            Example: 10 FedEx Parkway, Suite 302.<br>
            </label>
            <input placeholder="streetLines" type="text" name="recipient_streetLines" ><br><br>
            
            <label for="recipient_city">
            This is a placeholder for City Name.
            Note: This is conditional and not  in all the requests.
            Note: It is recommended for Express shipments for the most accurate ODA and OPA surcharges.<br>
            </label>
            <input placeholder="city" type="text" name="recipient_city" ><br><br>
            
            <label for="recipient_stateOrProvinceCode">
            This is a placeholder for state or province code.
            Example: CA.<br>
            </label>
            <input placeholder="stateOrProvinceCode" type="text" name="recipient_stateOrProvinceCode" ><br><br>
            
            <label for="recipient_countryCode">
            This is a placeholder for state or province code.
            Example: CA.<br>
            </label>
            <select name="recipient_countryCode" required>
                    @foreach($countryCode as $code => $country)
                    <option value="{{$country}}">{{$code}} ({{$country}})</option>
                    @endforeach
            </select>
              
              
          </fieldset><!--RECIPIENT FORM -->
            
            <input type="submit" value="Submit">
        </form>  
  </section>
  <section id="section3">
    <h3>Confirm Open shipment</h3>
      @csrf
      <form method='POST' action="javascript:void(0);" data-action="{{ url('/fedex') }}" id="confirm-open-ship">
        @csrf
        <label for="serviceType">                	
        Indicate the FedEx serviceType used for this shipment. The results will be filtered by the serviceType value indicated.
        Example: STANDARD_OVERNIGHT<br>
        </label>
        <select name="serviceType">
        @foreach($serviceType as $type => $service)
            <option value="{{$service}}">{{$type}} ({{$service}})</option>
        @endforeach
        </select><br><br>

        <label for="packagingType">
        Specify the Packaging Type used with the shipment.
        Note: For Express Freight shipments, the packaging will default to YOUR_PACKAGING irrespective of the user provided package type in the request.
        Example: YOUR_PACKAGING<br>
        </label>
        <select name="packagingType">
        @foreach($packageType as $type => $package)
            <option value="{{$package}}">{{$type}} ({{$package}})</option>
        @endforeach
        </select><br><br>

        <label for="pickupType">
        Indicate if shipment is being dropped off at a FedEx location or being picked up by FedEx or if it's a regular scheduled pickup for this shipment.<br>
        </label>
        <select name="pickupType">
           @foreach($pickupType as $type => $pickup)
            <option value="{{$pickup}}">{{$type}} ({{$pickup}})</option>
            @endforeach
        </select><br><br>

        <label for="paymentType">
        Specifies the payment Type.
        Note: This is required for Express, Ground and SmartPost shipments.
        The payment type COLLECT is applicable only for Ground shipments<br>
        </label>
        <select name="paymentType">
            <option value="SENDER">SENDER</option>
            <option value="RECIPIENT">RECIPIENT</option>
            <option value="THIRD_PARTY">THIRD PARTY</option>
            <option value="COLLECT">COLLECT</option>
        </select><br><br>

        <label for="weight_value">
        In pound.
        This is the weight. Maximum length is 99999.<br>
        </label>
        <input placeholder="weight" type="text" name="weight_value" ><br><br>
        
        <label for="accountNumber">
        Specify contact name. Maximum length is 70.
        Note: Either the companyName or personName is mandatory.
        Example: John Taylor<br>
        </label>
        <input placeholder="value" type="text" name="accountNumber" ><br><br>

        <fieldset>

          <legend>shipper information</legend>

          <label for="personName">
          Specify contact name. Maximum length is 70.
          Note: Either the companyName or personName is mandatory.
          Example: John Taylor<br>
          </label>
          <input placeholder="personName" type="text" name="shipper_personName" ><br><br>

          <label for="shipper_phoneNumber">
          Specify contact phone number.
          Minimum length is 10 and supports Maximum as 15 for certain countries using longer phone numbers.
          Note: Recommended Maximum length is 15 and there's no specific validation will be done for the phone number.
          Example: 918xxxxx890<br>
          </label>
          <input placeholder="phoneNumber" type="tel" name="shipper_phoneNumber" ><br><br>
          
          <label for="shipper_streetLines">
          This is the combination of number, street name, etc. Maximum length per line is 35.
          Example: 10 FedEx Parkway, Suite 302.<br>
          </label>
          <input placeholder="streetLines" type="text" name="shipper_streetLines" ><br><br>
          
          <label for="shipper_city">
          This is a placeholder for City Name.
          Note: This is conditional and not  in all the requests.
          Note: It is recommended for Express shipments for the most accurate ODA and OPA surcharges.<br>
          </label>
          <input placeholder="city" type="text" name="shipper_city" ><br><br>
          
          <label for="shipper_stateOrProvinceCode">
          This is a placeholder for state or province code.
          Example: CA.<br>
          </label>
          <input placeholder="stateOrProvinceCode" type="text" name="shipper_stateOrProvinceCode" ><br><br>
          
          <label for="shipper_countryCode">
          This is a placeholder for state or province code.
          Example: CA.<br>
          </label>
          <select name="shipper_countryCode" required>
              @foreach($countryCode as $code => $country)
              <option value="{{$country}}">{{$code}} ({{$country}})</option>
              @endforeach
          </select>
              
        </fieldset> <!--SHIPPER FORM -->

          <fieldset>
            <legend>Recipient information</legend>
  
            <label for="recipient_personName">
            Specify contact name. Maximum length is 70.
            Note: Either the companyName or personName is mandatory.
            Example: John Taylor<br>
            </label>
            <input placeholder="personName" type="text" name="recipient_personName" ><br><br>

            <label for="recipient_phoneNumber">
            Specify contact phone number.
            Minimum length is 10 and supports Maximum as 15 for certain countries using longer phone numbers.
            Note: Recommended Maximum length is 15 and there's no specific validation will be done for the phone number.
            Example: 918xxxxx890<br>
            </label>
            <input placeholder="phoneNumber" type="tel" name="recipient_phoneNumber" ><br><br>
            
            <label for="recipient_streetLines">
            This is the combination of number, street name, etc. Maximum length per line is 35.
            Example: 10 FedEx Parkway, Suite 302.<br>
            </label>
            <input placeholder="streetLines" type="text" name="recipient_streetLines" ><br><br>
            
            <label for="recipient_city">
            This is a placeholder for City Name.
            Note: This is conditional and not  in all the requests.
            Note: It is recommended for Express shipments for the most accurate ODA and OPA surcharges.<br>
            </label>
            <input placeholder="city" type="text" name="recipient_city" ><br><br>
            
            <label for="recipient_stateOrProvinceCode">
            This is a placeholder for state or province code.
            Example: CA.<br>
            </label>
            <input placeholder="stateOrProvinceCode" type="text" name="recipient_stateOrProvinceCode" ><br><br>
            
            <label for="recipient_countryCode">
            This is a placeholder for state or province code.
            Example: CA.<br>
            </label>
            <select name="recipient_countryCode" required>
                    @foreach($countryCode as $code => $country)
                    <option value="{{$country}}">{{$code}} ({{$country}})</option>
                    @endforeach
            </select>
              
              
          </fieldset><!--RECIPIENT FORM -->
            
            <input type="submit" value="Submit">
        </form>
  </section>
  <section id="section4">
    <h3>Modify Open shipment Packages</h3>
      @csrf
      <form method='PUT' action="javascript:void(0);" data-action="{{ url('/fedex') }}" id="modify-open-ship-packages">
        @csrf
        <label for="serviceType">                	
        Indicate the FedEx serviceType used for this shipment. The results will be filtered by the serviceType value indicated.
        Example: STANDARD_OVERNIGHT<br>
        </label>
        <select name="serviceType">
        @foreach($serviceType as $type => $service)
            <option value="{{$service}}">{{$type}} ({{$service}})</option>
        @endforeach
        </select><br><br>

        <label for="packagingType">
        Specify the Packaging Type used with the shipment.
        Note: For Express Freight shipments, the packaging will default to YOUR_PACKAGING irrespective of the user provided package type in the request.
        Example: YOUR_PACKAGING<br>
        </label>
        <select name="packagingType">
        @foreach($packageType as $type => $package)
            <option value="{{$package}}">{{$type}} ({{$package}})</option>
        @endforeach
        </select><br><br>

        <label for="pickupType">
        Indicate if shipment is being dropped off at a FedEx location or being picked up by FedEx or if it's a regular scheduled pickup for this shipment.<br>
        </label>
        <select name="pickupType">
           @foreach($pickupType as $type => $pickup)
            <option value="{{$pickup}}">{{$type}} ({{$pickup}})</option>
            @endforeach
        </select><br><br>

        <label for="paymentType">
        Specifies the payment Type.
        Note: This is required for Express, Ground and SmartPost shipments.
        The payment type COLLECT is applicable only for Ground shipments<br>
        </label>
        <select name="paymentType">
            <option value="SENDER">SENDER</option>
            <option value="RECIPIENT">RECIPIENT</option>
            <option value="THIRD_PARTY">THIRD PARTY</option>
            <option value="COLLECT">COLLECT</option>
        </select><br><br>

        <label for="weight_value">
        In pound.
        This is the weight. Maximum length is 99999.<br>
        </label>
        <input placeholder="weight" type="text" name="weight_value" ><br><br>
        
        <label for="accountNumber">
        Specify contact name. Maximum length is 70.
        Note: Either the companyName or personName is mandatory.
        Example: John Taylor<br>
        </label>
        <input placeholder="value" type="text" name="accountNumber" ><br><br>

        <fieldset>

          <legend>shipper information</legend>

          <label for="personName">
          Specify contact name. Maximum length is 70.
          Note: Either the companyName or personName is mandatory.
          Example: John Taylor<br>
          </label>
          <input placeholder="personName" type="text" name="shipper_personName" ><br><br>

          <label for="shipper_phoneNumber">
          Specify contact phone number.
          Minimum length is 10 and supports Maximum as 15 for certain countries using longer phone numbers.
          Note: Recommended Maximum length is 15 and there's no specific validation will be done for the phone number.
          Example: 918xxxxx890<br>
          </label>
          <input placeholder="phoneNumber" type="tel" name="shipper_phoneNumber" ><br><br>
          
          <label for="shipper_streetLines">
          This is the combination of number, street name, etc. Maximum length per line is 35.
          Example: 10 FedEx Parkway, Suite 302.<br>
          </label>
          <input placeholder="streetLines" type="text" name="shipper_streetLines" ><br><br>
          
          <label for="shipper_city">
          This is a placeholder for City Name.
          Note: This is conditional and not  in all the requests.
          Note: It is recommended for Express shipments for the most accurate ODA and OPA surcharges.<br>
          </label>
          <input placeholder="city" type="text" name="shipper_city" ><br><br>
          
          <label for="shipper_stateOrProvinceCode">
          This is a placeholder for state or province code.
          Example: CA.<br>
          </label>
          <input placeholder="stateOrProvinceCode" type="text" name="shipper_stateOrProvinceCode" ><br><br>
          
          <label for="shipper_countryCode">
          This is a placeholder for state or province code.
          Example: CA.<br>
          </label>
          <select name="shipper_countryCode" required>
              @foreach($countryCode as $code => $country)
              <option value="{{$country}}">{{$code}} ({{$country}})</option>
              @endforeach
          </select>
              
        </fieldset> <!--SHIPPER FORM -->

          <fieldset>
            <legend>Recipient information</legend>
  
            <label for="recipient_personName">
            Specify contact name. Maximum length is 70.
            Note: Either the companyName or personName is mandatory.
            Example: John Taylor<br>
            </label>
            <input placeholder="personName" type="text" name="recipient_personName" ><br><br>

            <label for="recipient_phoneNumber">
            Specify contact phone number.
            Minimum length is 10 and supports Maximum as 15 for certain countries using longer phone numbers.
            Note: Recommended Maximum length is 15 and there's no specific validation will be done for the phone number.
            Example: 918xxxxx890<br>
            </label>
            <input placeholder="phoneNumber" type="tel" name="recipient_phoneNumber" ><br><br>
            
            <label for="recipient_streetLines">
            This is the combination of number, street name, etc. Maximum length per line is 35.
            Example: 10 FedEx Parkway, Suite 302.<br>
            </label>
            <input placeholder="streetLines" type="text" name="recipient_streetLines" ><br><br>
            
            <label for="recipient_city">
            This is a placeholder for City Name.
            Note: This is conditional and not  in all the requests.
            Note: It is recommended for Express shipments for the most accurate ODA and OPA surcharges.<br>
            </label>
            <input placeholder="city" type="text" name="recipient_city" ><br><br>
            
            <label for="recipient_stateOrProvinceCode">
            This is a placeholder for state or province code.
            Example: CA.<br>
            </label>
            <input placeholder="stateOrProvinceCode" type="text" name="recipient_stateOrProvinceCode" ><br><br>
            
            <label for="recipient_countryCode">
            This is a placeholder for state or province code.
            Example: CA.<br>
            </label>
            <select name="recipient_countryCode" required>
                    @foreach($countryCode as $code => $country)
                    <option value="{{$country}}">{{$code}} ({{$country}})</option>
                    @endforeach
            </select>
              
              
          </fieldset><!--RECIPIENT FORM -->
            
            <input type="submit" value="Submit">
        </form>  
  </section>
  <section id="section5">
    <h3>Add Open shipment Packages</h3>
      @csrf
      <form method='PUT' action="javascript:void(0);" data-action="{{ url('/fedex') }}" id="add-open-ship-packages">
        @csrf
        <label for="serviceType">                	
        Indicate the FedEx serviceType used for this shipment. The results will be filtered by the serviceType value indicated.
        Example: STANDARD_OVERNIGHT<br>
        </label>
        <select name="serviceType">
        @foreach($serviceType as $type => $service)
            <option value="{{$service}}">{{$type}} ({{$service}})</option>
        @endforeach
        </select><br><br>

        <label for="packagingType">
        Specify the Packaging Type used with the shipment.
        Note: For Express Freight shipments, the packaging will default to YOUR_PACKAGING irrespective of the user provided package type in the request.
        Example: YOUR_PACKAGING<br>
        </label>
        <select name="packagingType">
        @foreach($packageType as $type => $package)
            <option value="{{$package}}">{{$type}} ({{$package}})</option>
        @endforeach
        </select><br><br>

        <label for="pickupType">
        Indicate if shipment is being dropped off at a FedEx location or being picked up by FedEx or if it's a regular scheduled pickup for this shipment.<br>
        </label>
        <select name="pickupType">
           @foreach($pickupType as $type => $pickup)
            <option value="{{$pickup}}">{{$type}} ({{$pickup}})</option>
            @endforeach
        </select><br><br>

        <label for="paymentType">
        Specifies the payment Type.
        Note: This is required for Express, Ground and SmartPost shipments.
        The payment type COLLECT is applicable only for Ground shipments<br>
        </label>
        <select name="paymentType">
            <option value="SENDER">SENDER</option>
            <option value="RECIPIENT">RECIPIENT</option>
            <option value="THIRD_PARTY">THIRD PARTY</option>
            <option value="COLLECT">COLLECT</option>
        </select><br><br>

        <label for="weight_value">
        In pound.
        This is the weight. Maximum length is 99999.<br>
        </label>
        <input placeholder="weight" type="text" name="weight_value" ><br><br>
        
        <label for="accountNumber">
        Specify contact name. Maximum length is 70.
        Note: Either the companyName or personName is mandatory.
        Example: John Taylor<br>
        </label>
        <input placeholder="value" type="text" name="accountNumber" ><br><br>

        <fieldset>

          <legend>shipper information</legend>

          <label for="personName">
          Specify contact name. Maximum length is 70.
          Note: Either the companyName or personName is mandatory.
          Example: John Taylor<br>
          </label>
          <input placeholder="personName" type="text" name="shipper_personName" ><br><br>

          <label for="shipper_phoneNumber">
          Specify contact phone number.
          Minimum length is 10 and supports Maximum as 15 for certain countries using longer phone numbers.
          Note: Recommended Maximum length is 15 and there's no specific validation will be done for the phone number.
          Example: 918xxxxx890<br>
          </label>
          <input placeholder="phoneNumber" type="tel" name="shipper_phoneNumber" ><br><br>
          
          <label for="shipper_streetLines">
          This is the combination of number, street name, etc. Maximum length per line is 35.
          Example: 10 FedEx Parkway, Suite 302.<br>
          </label>
          <input placeholder="streetLines" type="text" name="shipper_streetLines" ><br><br>
          
          <label for="shipper_city">
          This is a placeholder for City Name.
          Note: This is conditional and not  in all the requests.
          Note: It is recommended for Express shipments for the most accurate ODA and OPA surcharges.<br>
          </label>
          <input placeholder="city" type="text" name="shipper_city" ><br><br>
          
          <label for="shipper_stateOrProvinceCode">
          This is a placeholder for state or province code.
          Example: CA.<br>
          </label>
          <input placeholder="stateOrProvinceCode" type="text" name="shipper_stateOrProvinceCode" ><br><br>
          
          <label for="shipper_countryCode">
          This is a placeholder for state or province code.
          Example: CA.<br>
          </label>
          <select name="shipper_countryCode" required>
              @foreach($countryCode as $code => $country)
              <option value="{{$country}}">{{$code}} ({{$country}})</option>
              @endforeach
          </select>
              
        </fieldset> <!--SHIPPER FORM -->

          <fieldset>
            <legend>Recipient information</legend>
  
            <label for="recipient_personName">
            Specify contact name. Maximum length is 70.
            Note: Either the companyName or personName is mandatory.
            Example: John Taylor<br>
            </label>
            <input placeholder="personName" type="text" name="recipient_personName" ><br><br>

            <label for="recipient_phoneNumber">
            Specify contact phone number.
            Minimum length is 10 and supports Maximum as 15 for certain countries using longer phone numbers.
            Note: Recommended Maximum length is 15 and there's no specific validation will be done for the phone number.
            Example: 918xxxxx890<br>
            </label>
            <input placeholder="phoneNumber" type="tel" name="recipient_phoneNumber" ><br><br>
            
            <label for="recipient_streetLines">
            This is the combination of number, street name, etc. Maximum length per line is 35.
            Example: 10 FedEx Parkway, Suite 302.<br>
            </label>
            <input placeholder="streetLines" type="text" name="recipient_streetLines" ><br><br>
            
            <label for="recipient_city">
            This is a placeholder for City Name.
            Note: This is conditional and not  in all the requests.
            Note: It is recommended for Express shipments for the most accurate ODA and OPA surcharges.<br>
            </label>
            <input placeholder="city" type="text" name="recipient_city" ><br><br>
            
            <label for="recipient_stateOrProvinceCode">
            This is a placeholder for state or province code.
            Example: CA.<br>
            </label>
            <input placeholder="stateOrProvinceCode" type="text" name="recipient_stateOrProvinceCode" ><br><br>
            
            <label for="recipient_countryCode">
            This is a placeholder for state or province code.
            Example: CA.<br>
            </label>
            <select name="recipient_countryCode" required>
                    @foreach($countryCode as $code => $country)
                    <option value="{{$country}}">{{$code}} ({{$country}})</option>
                    @endforeach
            </select>
              
              
          </fieldset><!--RECIPIENT FORM -->
            
            <input type="submit" value="Submit">
        </form>  
  </section>
  <section id="section6">
    <h3>Delete Open shipment Packages</h3>
      @csrf
      <form method='PUT' action="javascript:void(0);" data-action="{{ url('/fedex') }}" id="delete-open-ship-packages">
        @csrf
        <label for="serviceType">                	
        Indicate the FedEx serviceType used for this shipment. The results will be filtered by the serviceType value indicated.
        Example: STANDARD_OVERNIGHT<br>
        </label>
        <select name="serviceType">
        @foreach($serviceType as $type => $service)
            <option value="{{$service}}">{{$type}} ({{$service}})</option>
        @endforeach
        </select><br><br>

        <label for="packagingType">
        Specify the Packaging Type used with the shipment.
        Note: For Express Freight shipments, the packaging will default to YOUR_PACKAGING irrespective of the user provided package type in the request.
        Example: YOUR_PACKAGING<br>
        </label>
        <select name="packagingType">
        @foreach($packageType as $type => $package)
            <option value="{{$package}}">{{$type}} ({{$package}})</option>
        @endforeach
        </select><br><br>

        <label for="pickupType">
        Indicate if shipment is being dropped off at a FedEx location or being picked up by FedEx or if it's a regular scheduled pickup for this shipment.<br>
        </label>
        <select name="pickupType">
           @foreach($pickupType as $type => $pickup)
            <option value="{{$pickup}}">{{$type}} ({{$pickup}})</option>
            @endforeach
        </select><br><br>

        <label for="paymentType">
        Specifies the payment Type.
        Note: This is required for Express, Ground and SmartPost shipments.
        The payment type COLLECT is applicable only for Ground shipments<br>
        </label>
        <select name="paymentType">
            <option value="SENDER">SENDER</option>
            <option value="RECIPIENT">RECIPIENT</option>
            <option value="THIRD_PARTY">THIRD PARTY</option>
            <option value="COLLECT">COLLECT</option>
        </select><br><br>

        <label for="weight_value">
        In pound.
        This is the weight. Maximum length is 99999.<br>
        </label>
        <input placeholder="weight" type="text" name="weight_value" ><br><br>
        
        <label for="accountNumber">
        Specify contact name. Maximum length is 70.
        Note: Either the companyName or personName is mandatory.
        Example: John Taylor<br>
        </label>
        <input placeholder="value" type="text" name="accountNumber" ><br><br>

        <fieldset>

          <legend>shipper information</legend>

          <label for="personName">
          Specify contact name. Maximum length is 70.
          Note: Either the companyName or personName is mandatory.
          Example: John Taylor<br>
          </label>
          <input placeholder="personName" type="text" name="shipper_personName" ><br><br>

          <label for="shipper_phoneNumber">
          Specify contact phone number.
          Minimum length is 10 and supports Maximum as 15 for certain countries using longer phone numbers.
          Note: Recommended Maximum length is 15 and there's no specific validation will be done for the phone number.
          Example: 918xxxxx890<br>
          </label>
          <input placeholder="phoneNumber" type="tel" name="shipper_phoneNumber" ><br><br>
          
          <label for="shipper_streetLines">
          This is the combination of number, street name, etc. Maximum length per line is 35.
          Example: 10 FedEx Parkway, Suite 302.<br>
          </label>
          <input placeholder="streetLines" type="text" name="shipper_streetLines" ><br><br>
          
          <label for="shipper_city">
          This is a placeholder for City Name.
          Note: This is conditional and not  in all the requests.
          Note: It is recommended for Express shipments for the most accurate ODA and OPA surcharges.<br>
          </label>
          <input placeholder="city" type="text" name="shipper_city" ><br><br>
          
          <label for="shipper_stateOrProvinceCode">
          This is a placeholder for state or province code.
          Example: CA.<br>
          </label>
          <input placeholder="stateOrProvinceCode" type="text" name="shipper_stateOrProvinceCode" ><br><br>
          
          <label for="shipper_countryCode">
          This is a placeholder for state or province code.
          Example: CA.<br>
          </label>
          <select name="shipper_countryCode" required>
              @foreach($countryCode as $code => $country)
              <option value="{{$country}}">{{$code}} ({{$country}})</option>
              @endforeach
          </select>
              
        </fieldset> <!--SHIPPER FORM -->

          <fieldset>
            <legend>Recipient information</legend>
  
            <label for="recipient_personName">
            Specify contact name. Maximum length is 70.
            Note: Either the companyName or personName is mandatory.
            Example: John Taylor<br>
            </label>
            <input placeholder="personName" type="text" name="recipient_personName" ><br><br>

            <label for="recipient_phoneNumber">
            Specify contact phone number.
            Minimum length is 10 and supports Maximum as 15 for certain countries using longer phone numbers.
            Note: Recommended Maximum length is 15 and there's no specific validation will be done for the phone number.
            Example: 918xxxxx890<br>
            </label>
            <input placeholder="phoneNumber" type="tel" name="recipient_phoneNumber" ><br><br>
            
            <label for="recipient_streetLines">
            This is the combination of number, street name, etc. Maximum length per line is 35.
            Example: 10 FedEx Parkway, Suite 302.<br>
            </label>
            <input placeholder="streetLines" type="text" name="recipient_streetLines" ><br><br>
            
            <label for="recipient_city">
            This is a placeholder for City Name.
            Note: This is conditional and not  in all the requests.
            Note: It is recommended for Express shipments for the most accurate ODA and OPA surcharges.<br>
            </label>
            <input placeholder="city" type="text" name="recipient_city" ><br><br>
            
            <label for="recipient_stateOrProvinceCode">
            This is a placeholder for state or province code.
            Example: CA.<br>
            </label>
            <input placeholder="stateOrProvinceCode" type="text" name="recipient_stateOrProvinceCode" ><br><br>
            
            <label for="recipient_countryCode">
            This is a placeholder for state or province code.
            Example: CA.<br>
            </label>
            <select name="recipient_countryCode" required>
                    @foreach($countryCode as $code => $country)
                    <option value="{{$country}}">{{$code}} ({{$country}})</option>
                    @endforeach
            </select>
              
              
          </fieldset><!--RECIPIENT FORM -->
            
            <input type="submit" value="Submit">
        </form>  
  </section>
  <section id="section7">
    <h3>Retrieve Open shipment Packages</h3>
      @csrf
      <form method='PUT' action="javascript:void(0);" data-action="{{ url('/fedex') }}" id="retrieve-open-ship-packages">
        @csrf
        <label for="serviceType">                	
        Indicate the FedEx serviceType used for this shipment. The results will be filtered by the serviceType value indicated.
        Example: STANDARD_OVERNIGHT<br>
        </label>
        <select name="serviceType">
        @foreach($serviceType as $type => $service)
            <option value="{{$service}}">{{$type}} ({{$service}})</option>
        @endforeach
        </select><br><br>

        <label for="packagingType">
        Specify the Packaging Type used with the shipment.
        Note: For Express Freight shipments, the packaging will default to YOUR_PACKAGING irrespective of the user provided package type in the request.
        Example: YOUR_PACKAGING<br>
        </label>
        <select name="packagingType">
        @foreach($packageType as $type => $package)
            <option value="{{$package}}">{{$type}} ({{$package}})</option>
        @endforeach
        </select><br><br>

        <label for="pickupType">
        Indicate if shipment is being dropped off at a FedEx location or being picked up by FedEx or if it's a regular scheduled pickup for this shipment.<br>
        </label>
        <select name="pickupType">
           @foreach($pickupType as $type => $pickup)
            <option value="{{$pickup}}">{{$type}} ({{$pickup}})</option>
            @endforeach
        </select><br><br>

        <label for="paymentType">
        Specifies the payment Type.
        Note: This is required for Express, Ground and SmartPost shipments.
        The payment type COLLECT is applicable only for Ground shipments<br>
        </label>
        <select name="paymentType">
            <option value="SENDER">SENDER</option>
            <option value="RECIPIENT">RECIPIENT</option>
            <option value="THIRD_PARTY">THIRD PARTY</option>
            <option value="COLLECT">COLLECT</option>
        </select><br><br>

        <label for="weight_value">
        In pound.
        This is the weight. Maximum length is 99999.<br>
        </label>
        <input placeholder="weight" type="text" name="weight_value" ><br><br>
        
        <label for="accountNumber">
        Specify contact name. Maximum length is 70.
        Note: Either the companyName or personName is mandatory.
        Example: John Taylor<br>
        </label>
        <input placeholder="value" type="text" name="accountNumber" ><br><br>

        <fieldset>

          <legend>shipper information</legend>

          <label for="personName">
          Specify contact name. Maximum length is 70.
          Note: Either the companyName or personName is mandatory.
          Example: John Taylor<br>
          </label>
          <input placeholder="personName" type="text" name="shipper_personName" ><br><br>

          <label for="shipper_phoneNumber">
          Specify contact phone number.
          Minimum length is 10 and supports Maximum as 15 for certain countries using longer phone numbers.
          Note: Recommended Maximum length is 15 and there's no specific validation will be done for the phone number.
          Example: 918xxxxx890<br>
          </label>
          <input placeholder="phoneNumber" type="tel" name="shipper_phoneNumber" ><br><br>
          
          <label for="shipper_streetLines">
          This is the combination of number, street name, etc. Maximum length per line is 35.
          Example: 10 FedEx Parkway, Suite 302.<br>
          </label>
          <input placeholder="streetLines" type="text" name="shipper_streetLines" ><br><br>
          
          <label for="shipper_city">
          This is a placeholder for City Name.
          Note: This is conditional and not  in all the requests.
          Note: It is recommended for Express shipments for the most accurate ODA and OPA surcharges.<br>
          </label>
          <input placeholder="city" type="text" name="shipper_city" ><br><br>
          
          <label for="shipper_stateOrProvinceCode">
          This is a placeholder for state or province code.
          Example: CA.<br>
          </label>
          <input placeholder="stateOrProvinceCode" type="text" name="shipper_stateOrProvinceCode" ><br><br>
          
          <label for="shipper_countryCode">
          This is a placeholder for state or province code.
          Example: CA.<br>
          </label>
          <select name="shipper_countryCode" required>
              @foreach($countryCode as $code => $country)
              <option value="{{$country}}">{{$code}} ({{$country}})</option>
              @endforeach
          </select>
              
        </fieldset> <!--SHIPPER FORM -->

          <fieldset>
            <legend>Recipient information</legend>
  
            <label for="recipient_personName">
            Specify contact name. Maximum length is 70.
            Note: Either the companyName or personName is mandatory.
            Example: John Taylor<br>
            </label>
            <input placeholder="personName" type="text" name="recipient_personName" ><br><br>

            <label for="recipient_phoneNumber">
            Specify contact phone number.
            Minimum length is 10 and supports Maximum as 15 for certain countries using longer phone numbers.
            Note: Recommended Maximum length is 15 and there's no specific validation will be done for the phone number.
            Example: 918xxxxx890<br>
            </label>
            <input placeholder="phoneNumber" type="tel" name="recipient_phoneNumber" ><br><br>
            
            <label for="recipient_streetLines">
            This is the combination of number, street name, etc. Maximum length per line is 35.
            Example: 10 FedEx Parkway, Suite 302.<br>
            </label>
            <input placeholder="streetLines" type="text" name="recipient_streetLines" ><br><br>
            
            <label for="recipient_city">
            This is a placeholder for City Name.
            Note: This is conditional and not  in all the requests.
            Note: It is recommended for Express shipments for the most accurate ODA and OPA surcharges.<br>
            </label>
            <input placeholder="city" type="text" name="recipient_city" ><br><br>
            
            <label for="recipient_stateOrProvinceCode">
            This is a placeholder for state or province code.
            Example: CA.<br>
            </label>
            <input placeholder="stateOrProvinceCode" type="text" name="recipient_stateOrProvinceCode" ><br><br>
            
            <label for="recipient_countryCode">
            This is a placeholder for state or province code.
            Example: CA.<br>
            </label>
            <select name="recipient_countryCode" required>
                    @foreach($countryCode as $code => $country)
                    <option value="{{$country}}">{{$code}} ({{$country}})</option>
                    @endforeach
            </select>
              
              
          </fieldset><!--RECIPIENT FORM -->
            
            <input type="submit" value="Submit">
        </form>  
  </section>
  <section id="section8">
    <h3>Open shipment Delete</h3>
      @csrf
      <form method='PUT' action="javascript:void(0);" data-action="{{ url('/fedex') }}" id="open-ship-delete">
        @csrf
        <label for="serviceType">                	
        Indicate the FedEx serviceType used for this shipment. The results will be filtered by the serviceType value indicated.
        Example: STANDARD_OVERNIGHT<br>
        </label>
        <select name="serviceType">
        @foreach($serviceType as $type => $service)
            <option value="{{$service}}">{{$type}} ({{$service}})</option>
        @endforeach
        </select><br><br>

        <label for="packagingType">
        Specify the Packaging Type used with the shipment.
        Note: For Express Freight shipments, the packaging will default to YOUR_PACKAGING irrespective of the user provided package type in the request.
        Example: YOUR_PACKAGING<br>
        </label>
        <select name="packagingType">
        @foreach($packageType as $type => $package)
            <option value="{{$package}}">{{$type}} ({{$package}})</option>
        @endforeach
        </select><br><br>

        <label for="pickupType">
        Indicate if shipment is being dropped off at a FedEx location or being picked up by FedEx or if it's a regular scheduled pickup for this shipment.<br>
        </label>
        <select name="pickupType">
           @foreach($pickupType as $type => $pickup)
            <option value="{{$pickup}}">{{$type}} ({{$pickup}})</option>
            @endforeach
        </select><br><br>

        <label for="paymentType">
        Specifies the payment Type.
        Note: This is required for Express, Ground and SmartPost shipments.
        The payment type COLLECT is applicable only for Ground shipments<br>
        </label>
        <select name="paymentType">
            <option value="SENDER">SENDER</option>
            <option value="RECIPIENT">RECIPIENT</option>
            <option value="THIRD_PARTY">THIRD PARTY</option>
            <option value="COLLECT">COLLECT</option>
        </select><br><br>

        <label for="weight_value">
        In pound.
        This is the weight. Maximum length is 99999.<br>
        </label>
        <input placeholder="weight" type="text" name="weight_value" ><br><br>
        
        <label for="accountNumber">
        Specify contact name. Maximum length is 70.
        Note: Either the companyName or personName is mandatory.
        Example: John Taylor<br>
        </label>
        <input placeholder="value" type="text" name="accountNumber" ><br><br>

        <fieldset>

          <legend>shipper information</legend>

          <label for="personName">
          Specify contact name. Maximum length is 70.
          Note: Either the companyName or personName is mandatory.
          Example: John Taylor<br>
          </label>
          <input placeholder="personName" type="text" name="shipper_personName" ><br><br>

          <label for="shipper_phoneNumber">
          Specify contact phone number.
          Minimum length is 10 and supports Maximum as 15 for certain countries using longer phone numbers.
          Note: Recommended Maximum length is 15 and there's no specific validation will be done for the phone number.
          Example: 918xxxxx890<br>
          </label>
          <input placeholder="phoneNumber" type="tel" name="shipper_phoneNumber" ><br><br>
          
          <label for="shipper_streetLines">
          This is the combination of number, street name, etc. Maximum length per line is 35.
          Example: 10 FedEx Parkway, Suite 302.<br>
          </label>
          <input placeholder="streetLines" type="text" name="shipper_streetLines" ><br><br>
          
          <label for="shipper_city">
          This is a placeholder for City Name.
          Note: This is conditional and not  in all the requests.
          Note: It is recommended for Express shipments for the most accurate ODA and OPA surcharges.<br>
          </label>
          <input placeholder="city" type="text" name="shipper_city" ><br><br>
          
          <label for="shipper_stateOrProvinceCode">
          This is a placeholder for state or province code.
          Example: CA.<br>
          </label>
          <input placeholder="stateOrProvinceCode" type="text" name="shipper_stateOrProvinceCode" ><br><br>
          
          <label for="shipper_countryCode">
          This is a placeholder for state or province code.
          Example: CA.<br>
          </label>
          <select name="shipper_countryCode" required>
              @foreach($countryCode as $code => $country)
              <option value="{{$country}}">{{$code}} ({{$country}})</option>
              @endforeach
          </select>
              
        </fieldset> <!--SHIPPER FORM -->

          <fieldset>
            <legend>Recipient information</legend>
  
            <label for="recipient_personName">
            Specify contact name. Maximum length is 70.
            Note: Either the companyName or personName is mandatory.
            Example: John Taylor<br>
            </label>
            <input placeholder="personName" type="text" name="recipient_personName" ><br><br>

            <label for="recipient_phoneNumber">
            Specify contact phone number.
            Minimum length is 10 and supports Maximum as 15 for certain countries using longer phone numbers.
            Note: Recommended Maximum length is 15 and there's no specific validation will be done for the phone number.
            Example: 918xxxxx890<br>
            </label>
            <input placeholder="phoneNumber" type="tel" name="recipient_phoneNumber" ><br><br>
            
            <label for="recipient_streetLines">
            This is the combination of number, street name, etc. Maximum length per line is 35.
            Example: 10 FedEx Parkway, Suite 302.<br>
            </label>
            <input placeholder="streetLines" type="text" name="recipient_streetLines" ><br><br>
            
            <label for="recipient_city">
            This is a placeholder for City Name.
            Note: This is conditional and not  in all the requests.
            Note: It is recommended for Express shipments for the most accurate ODA and OPA surcharges.<br>
            </label>
            <input placeholder="city" type="text" name="recipient_city" ><br><br>
            
            <label for="recipient_stateOrProvinceCode">
            This is a placeholder for state or province code.
            Example: CA.<br>
            </label>
            <input placeholder="stateOrProvinceCode" type="text" name="recipient_stateOrProvinceCode" ><br><br>
            
            <label for="recipient_countryCode">
            This is a placeholder for state or province code.
            Example: CA.<br>
            </label>
            <select name="recipient_countryCode" required>
                    @foreach($countryCode as $code => $country)
                    <option value="{{$country}}">{{$code}} ({{$country}})</option>
                    @endforeach
            </select>
              
              
          </fieldset><!--RECIPIENT FORM -->
            
            <input type="submit" value="Submit">
        </form>  
  </section>
  <section id="section9">
    <h3>Retrieve Open shipment</h3>
      @csrf
      <form method='PUT' action="javascript:void(0);" data-action="{{ url('/fedex') }}" id="retrieve-open-ship">
        @csrf
        <label for="serviceType">                	
        Indicate the FedEx serviceType used for this shipment. The results will be filtered by the serviceType value indicated.
        Example: STANDARD_OVERNIGHT<br>
        </label>
        <select name="serviceType">
        @foreach($serviceType as $type => $service)
            <option value="{{$service}}">{{$type}} ({{$service}})</option>
        @endforeach
        </select><br><br>

        <label for="packagingType">
        Specify the Packaging Type used with the shipment.
        Note: For Express Freight shipments, the packaging will default to YOUR_PACKAGING irrespective of the user provided package type in the request.
        Example: YOUR_PACKAGING<br>
        </label>
        <select name="packagingType">
        @foreach($packageType as $type => $package)
            <option value="{{$package}}">{{$type}} ({{$package}})</option>
        @endforeach
        </select><br><br>

        <label for="pickupType">
        Indicate if shipment is being dropped off at a FedEx location or being picked up by FedEx or if it's a regular scheduled pickup for this shipment.<br>
        </label>
        <select name="pickupType">
           @foreach($pickupType as $type => $pickup)
            <option value="{{$pickup}}">{{$type}} ({{$pickup}})</option>
            @endforeach
        </select><br><br>

        <label for="paymentType">
        Specifies the payment Type.
        Note: This is required for Express, Ground and SmartPost shipments.
        The payment type COLLECT is applicable only for Ground shipments<br>
        </label>
        <select name="paymentType">
            <option value="SENDER">SENDER</option>
            <option value="RECIPIENT">RECIPIENT</option>
            <option value="THIRD_PARTY">THIRD PARTY</option>
            <option value="COLLECT">COLLECT</option>
        </select><br><br>

        <label for="weight_value">
        In pound.
        This is the weight. Maximum length is 99999.<br>
        </label>
        <input placeholder="weight" type="text" name="weight_value" ><br><br>
        
        <label for="accountNumber">
        Specify contact name. Maximum length is 70.
        Note: Either the companyName or personName is mandatory.
        Example: John Taylor<br>
        </label>
        <input placeholder="value" type="text" name="accountNumber" ><br><br>

        <fieldset>

          <legend>shipper information</legend>

          <label for="personName">
          Specify contact name. Maximum length is 70.
          Note: Either the companyName or personName is mandatory.
          Example: John Taylor<br>
          </label>
          <input placeholder="personName" type="text" name="shipper_personName" ><br><br>

          <label for="shipper_phoneNumber">
          Specify contact phone number.
          Minimum length is 10 and supports Maximum as 15 for certain countries using longer phone numbers.
          Note: Recommended Maximum length is 15 and there's no specific validation will be done for the phone number.
          Example: 918xxxxx890<br>
          </label>
          <input placeholder="phoneNumber" type="tel" name="shipper_phoneNumber" ><br><br>
          
          <label for="shipper_streetLines">
          This is the combination of number, street name, etc. Maximum length per line is 35.
          Example: 10 FedEx Parkway, Suite 302.<br>
          </label>
          <input placeholder="streetLines" type="text" name="shipper_streetLines" ><br><br>
          
          <label for="shipper_city">
          This is a placeholder for City Name.
          Note: This is conditional and not  in all the requests.
          Note: It is recommended for Express shipments for the most accurate ODA and OPA surcharges.<br>
          </label>
          <input placeholder="city" type="text" name="shipper_city" ><br><br>
          
          <label for="shipper_stateOrProvinceCode">
          This is a placeholder for state or province code.
          Example: CA.<br>
          </label>
          <input placeholder="stateOrProvinceCode" type="text" name="shipper_stateOrProvinceCode" ><br><br>
          
          <label for="shipper_countryCode">
          This is a placeholder for state or province code.
          Example: CA.<br>
          </label>
          <select name="shipper_countryCode" required>
              @foreach($countryCode as $code => $country)
              <option value="{{$country}}">{{$code}} ({{$country}})</option>
              @endforeach
          </select>
              
        </fieldset> <!--SHIPPER FORM -->

          <fieldset>
            <legend>Recipient information</legend>
  
            <label for="recipient_personName">
            Specify contact name. Maximum length is 70.
            Note: Either the companyName or personName is mandatory.
            Example: John Taylor<br>
            </label>
            <input placeholder="personName" type="text" name="recipient_personName" ><br><br>

            <label for="recipient_phoneNumber">
            Specify contact phone number.
            Minimum length is 10 and supports Maximum as 15 for certain countries using longer phone numbers.
            Note: Recommended Maximum length is 15 and there's no specific validation will be done for the phone number.
            Example: 918xxxxx890<br>
            </label>
            <input placeholder="phoneNumber" type="tel" name="recipient_phoneNumber" ><br><br>
            
            <label for="recipient_streetLines">
            This is the combination of number, street name, etc. Maximum length per line is 35.
            Example: 10 FedEx Parkway, Suite 302.<br>
            </label>
            <input placeholder="streetLines" type="text" name="recipient_streetLines" ><br><br>
            
            <label for="recipient_city">
            This is a placeholder for City Name.
            Note: This is conditional and not  in all the requests.
            Note: It is recommended for Express shipments for the most accurate ODA and OPA surcharges.<br>
            </label>
            <input placeholder="city" type="text" name="recipient_city" ><br><br>
            
            <label for="recipient_stateOrProvinceCode">
            This is a placeholder for state or province code.
            Example: CA.<br>
            </label>
            <input placeholder="stateOrProvinceCode" type="text" name="recipient_stateOrProvinceCode" ><br><br>
            
            <label for="recipient_countryCode">
            This is a placeholder for state or province code.
            Example: CA.<br>
            </label>
            <select name="recipient_countryCode" required>
                    @foreach($countryCode as $code => $country)
                    <option value="{{$country}}">{{$code}} ({{$country}})</option>
                    @endforeach
            </select>
              
              
          </fieldset><!--RECIPIENT FORM -->
            
            <input type="submit" value="Submit">
        </form>  
  </section>
  <section id="section10">
    <h3>Get Open shipment Results</h3>
      @csrf
      <form method='PUT' action="javascript:void(0);" data-action="{{ url('/fedex') }}" id="get-open-ship-results">
        @csrf
        <label for="serviceType">                	
        Indicate the FedEx serviceType used for this shipment. The results will be filtered by the serviceType value indicated.
        Example: STANDARD_OVERNIGHT<br>
        </label>
        <select name="serviceType">
        @foreach($serviceType as $type => $service)
            <option value="{{$service}}">{{$type}} ({{$service}})</option>
        @endforeach
        </select><br><br>

        <label for="packagingType">
        Specify the Packaging Type used with the shipment.
        Note: For Express Freight shipments, the packaging will default to YOUR_PACKAGING irrespective of the user provided package type in the request.
        Example: YOUR_PACKAGING<br>
        </label>
        <select name="packagingType">
        @foreach($packageType as $type => $package)
            <option value="{{$package}}">{{$type}} ({{$package}})</option>
        @endforeach
        </select><br><br>

        <label for="pickupType">
        Indicate if shipment is being dropped off at a FedEx location or being picked up by FedEx or if it's a regular scheduled pickup for this shipment.<br>
        </label>
        <select name="pickupType">
           @foreach($pickupType as $type => $pickup)
            <option value="{{$pickup}}">{{$type}} ({{$pickup}})</option>
            @endforeach
        </select><br><br>

        <label for="paymentType">
        Specifies the payment Type.
        Note: This is required for Express, Ground and SmartPost shipments.
        The payment type COLLECT is applicable only for Ground shipments<br>
        </label>
        <select name="paymentType">
            <option value="SENDER">SENDER</option>
            <option value="RECIPIENT">RECIPIENT</option>
            <option value="THIRD_PARTY">THIRD PARTY</option>
            <option value="COLLECT">COLLECT</option>
        </select><br><br>

        <label for="weight_value">
        In pound.
        This is the weight. Maximum length is 99999.<br>
        </label>
        <input placeholder="weight" type="text" name="weight_value" ><br><br>
        
        <label for="accountNumber">
        Specify contact name. Maximum length is 70.
        Note: Either the companyName or personName is mandatory.
        Example: John Taylor<br>
        </label>
        <input placeholder="value" type="text" name="accountNumber" ><br><br>

        <fieldset>

          <legend>shipper information</legend>

          <label for="personName">
          Specify contact name. Maximum length is 70.
          Note: Either the companyName or personName is mandatory.
          Example: John Taylor<br>
          </label>
          <input placeholder="personName" type="text" name="shipper_personName" ><br><br>

          <label for="shipper_phoneNumber">
          Specify contact phone number.
          Minimum length is 10 and supports Maximum as 15 for certain countries using longer phone numbers.
          Note: Recommended Maximum length is 15 and there's no specific validation will be done for the phone number.
          Example: 918xxxxx890<br>
          </label>
          <input placeholder="phoneNumber" type="tel" name="shipper_phoneNumber" ><br><br>
          
          <label for="shipper_streetLines">
          This is the combination of number, street name, etc. Maximum length per line is 35.
          Example: 10 FedEx Parkway, Suite 302.<br>
          </label>
          <input placeholder="streetLines" type="text" name="shipper_streetLines" ><br><br>
          
          <label for="shipper_city">
          This is a placeholder for City Name.
          Note: This is conditional and not  in all the requests.
          Note: It is recommended for Express shipments for the most accurate ODA and OPA surcharges.<br>
          </label>
          <input placeholder="city" type="text" name="shipper_city" ><br><br>
          
          <label for="shipper_stateOrProvinceCode">
          This is a placeholder for state or province code.
          Example: CA.<br>
          </label>
          <input placeholder="stateOrProvinceCode" type="text" name="shipper_stateOrProvinceCode" ><br><br>
          
          <label for="shipper_countryCode">
          This is a placeholder for state or province code.
          Example: CA.<br>
          </label>
          <select name="shipper_countryCode" required>
              @foreach($countryCode as $code => $country)
              <option value="{{$country}}">{{$code}} ({{$country}})</option>
              @endforeach
          </select>
              
        </fieldset> <!--SHIPPER FORM -->

          <fieldset>
            <legend>Recipient information</legend>
  
            <label for="recipient_personName">
            Specify contact name. Maximum length is 70.
            Note: Either the companyName or personName is mandatory.
            Example: John Taylor<br>
            </label>
            <input placeholder="personName" type="text" name="recipient_personName" ><br><br>

            <label for="recipient_phoneNumber">
            Specify contact phone number.
            Minimum length is 10 and supports Maximum as 15 for certain countries using longer phone numbers.
            Note: Recommended Maximum length is 15 and there's no specific validation will be done for the phone number.
            Example: 918xxxxx890<br>
            </label>
            <input placeholder="phoneNumber" type="tel" name="recipient_phoneNumber" ><br><br>
            
            <label for="recipient_streetLines">
            This is the combination of number, street name, etc. Maximum length per line is 35.
            Example: 10 FedEx Parkway, Suite 302.<br>
            </label>
            <input placeholder="streetLines" type="text" name="recipient_streetLines" ><br><br>
            
            <label for="recipient_city">
            This is a placeholder for City Name.
            Note: This is conditional and not  in all the requests.
            Note: It is recommended for Express shipments for the most accurate ODA and OPA surcharges.<br>
            </label>
            <input placeholder="city" type="text" name="recipient_city" ><br><br>
            
            <label for="recipient_stateOrProvinceCode">
            This is a placeholder for state or province code.
            Example: CA.<br>
            </label>
            <input placeholder="stateOrProvinceCode" type="text" name="recipient_stateOrProvinceCode" ><br><br>
            
            <label for="recipient_countryCode">
            This is a placeholder for state or province code.
            Example: CA.<br>
            </label>
            <select name="recipient_countryCode" required>
                    @foreach($countryCode as $code => $country)
                    <option value="{{$country}}">{{$code}} ({{$country}})</option>
                    @endforeach
            </select>
              
              
          </fieldset><!--RECIPIENT FORM -->
            
            <input type="submit" value="Submit">
        </form>  
  </section>
  

</div>
@endsection
@section('scripts')
    <script type="text/javascript" src="{{ asset('js/fedex/ground_day_close.js') }}"></script>
@endsection
