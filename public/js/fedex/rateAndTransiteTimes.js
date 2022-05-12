import {requeringToken} from './requeringToken.js';

$("#requestRate").on('submit',
  function (){
    let url = $(this).attr('data-action');
    let input = JSON.stringify({
          
    "accountNumber": {
      "value": $('input[name="accountNumber"]').val()
    },
    "requestedShipment": {
      "shipper": {
        "address": {
          "postalCode": $('input[name="shipper_postalCode"]').val(),
            "countryCode": $('select[name="countryCode"]').val()
            }
      },
      "recipient": {
        "address": {
          "postalCode": $('input[name="recipient_postalCode"]').val(),
          "countryCode": $('select[name="countryCode"]').val()
        }
      },
      //   "pickupType": "DROPOFF_AT_FEDEX_LOCATION",
      //   "serviceType": "FEDEX_1_DAY_FREIGHT",
      //   "rateRequestType": [
      //     "LIST",
      //     "ACCOUNT"
      //   ],
      "requestedPackageLineItems": [{
        "weight": {
          "units": "LB",
          "value": 151
        },
        "dimensions": {
          "length": 30,
          "width": 30,
          "height": 40,
          "units": "IN"
        }
      }]
    }
    }
      );
    console.log(input);
    $.ajax({
      type: 'POST',
      url: url ,
      data: {
          rateAndTransiteTimes: input,
          _token: $('input[name="_token"]').val()
      },
    success: function(data){
      switch(data.statusCode){
        case 200: 
            console.log(data.statusCode);
        break;
        case 401:
            requeringToken(rateAndTransiteTimes);
        break;
    }
    },
    error: function(data){
        alert(JSON.stringify(data));
        }
});
  function rateAndTransiteTimes (){
  console.log("resending the post for create open ship");
    $.ajax({
        type: 'POST',
        url: url + '/openShip',
        data: {
          open_shipment: input,
          _token: $('input[name="_token"]').val(),
        },
    success: function(data){
        switch(data.statusCode){
            case 200:
            console.log("SMN" + data.statudCode);
            console.log(JSON.stringify(data));
            break;
            default: 
                console.log("def" + data.statusCode);
                console.log(JSON.stringify(data));
        }
    },
    error: {}
});
  }
}
    
);

