$("#requestRate").on('submit',
function (){
    let url = $(this).attr('data-action');
    // $input = JSON.stringify({
    // "accountNumber": {
    //   "value": ""
    // },
    // "requestedShipment": {
    //   "shipper": {
    //     "address": {
    //       "postalCode": "65247",
    //         "countryCode": "US"
    //         }
    //   },
    //   "recipient": {
    //     "address": {
    //       "postalCode": "75063",
    //       "countryCode": "US"
    //     }
    //   },
    //   "pickupType": $('select[name="pickupType"]').val(),
    //   "rateRequestType":["ACCOUNT"],
    //   "requestedPackageLineItems": [{
    //     "weight": {
    //       "units": "LB",
    //       "value": "10",
    //     },
    //     "dimensions": {
    //       "length": "10",
    //       "width": "10",
    //       "height": "10",
    //       "units": "IN"
    //     }
    //   }]
    // }
    // });
    $input = JSON.stringify({
    "accountNumber": {
      "value": ""
    },
    "requestedShipment": {
      "shipper": {
        "address": {
          "postalCode": $('input[name="shipper_postalCode"]').val(),
            "countryCode": $('select[name="shipper_countryCode"]').val()
            }
      },
      "recipient": {
        "address": {
          "postalCode": $('input[name="recipient_postalCode"]').val(),
          "countryCode": $('select[name="recipient_countryCode"]').val()
        }
      },
      "pickupType": $('select[name="pickupType"]').val(),
      "rateRequestType":["LIST", "ACCOUNT"],
      "requestedPackageLineItems": [{
        "weight": {
          "units": "LB",
          "value": $('input[name="weight"]').val(),
        },
        "dimensions": {
          "length": $('input[name="lenght"]').val(),
          "width": $('input[name="width"]').val(),
          "height": $('input[name="height"]').val(),
          "units": "IN"
        }
      }]
    }
    });
    $.ajax({
      type: 'POST',
      url: url ,
      data: {
          rateAndTransiteTimes: $input,
          _token: $('input[name="_token"]').val()
      },
    success: function(data){
      switch(data.statusCode){
        case 200: 
        console.log(data.statusCode + JSON.stringify(data));

        $('#rates').remove();

        $('#requestRate').after("<div id='rates'></div>");
        $("#rates").css("display", "flex").css("justify-content", "space-evenly");
        //FEDEX
        $('#rates').append("<div id='ratesFedex'></div>");
        $("#ratesFedex").css("display", "flex").css("flex-direction", "column");
        $("#ratesFedex").append("<h2 id='fedex'>FedEx</h2>");
        $("#ratesFedex").append("<p id='fedexRate'>Tarifa FedEx: $" + data.rateAndTransitTimes.output.rateReplyDetails[0].ratedShipmentDetails[0].totalNetCharge + "</p>");
        //DHL
        $('#rates').append("<div id='ratesDhl'></div>");
        $("#ratesDhl").css("display", "flex").css("flex-direction", "column");
        $("#ratesDhl").append("<h2 id='dhl'>DHL</h2>");
        $("#ratesDhl").append("<p id='dhlRate'>Tarifa dhl: $</p>");
        //UPS
        $('#rates').append("<div id='ratesUps'></div>");
        $("#ratesUps").css("display", "flex").css("flex-direction", "column");
        $("#ratesUps").append("<h2 id='ups'>UPS</h2>");
        $("#ratesUps").append("<p id='upsRate'>Tarifa UPS: $</p>");
        break;
        case 400:
        console.log(data.statusCode + JSON.stringify(data));
        break;
        case 401:
          // requeringToken(rateAndTransiteTimes);
          break;
          
          default:
            console.log(data.statusCode + JSON.stringify(data));
            
    }
    },
    error: function(data){
        alert(JSON.stringify(data));
        }
});
//   function rateAndTransiteTimes (){
//   console.log("resending the post for create open ship");
//     $.ajax({
//         type: 'POST',
//         url: url + '/openShip',
//         data: {
//           open_shipment: input,
//           _token: $('input[name="_token"]').val(),
//         },
//     success: function(data){
//         switch(data.statusCode){
//             case 200:
//             console.log("SMN" + data.statudCode);
//             console.log(JSON.stringify(data));
//             break;
//             default: 
//                 console.log("def" + data.statusCode);
//                 console.log(JSON.stringify(data));
//         }
//     },
//     error: {}
// });
//   }
}
    
);

