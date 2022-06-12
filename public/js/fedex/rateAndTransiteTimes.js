import ajax from '../ajax.js';

$("#fedEx").hide();
$("#requestRate").on('submit',
function (){
  $('#rates').remove();
    let url = $(this).attr('data-action');
    let input = JSON.stringify({
    "fedex": {
      "accountNumber": {
        "value": ""
      },
      "requestedShipment": {
        "shipper": {
          "address": {
            "city" : $('input[name="shipper_city"]').val(),
            "postalCode": $('input[name="shipper_postalCode"]').val(),
              "countryCode": $('select[name="shipper_countryCode"]').val(),
              }
        },
        "recipient": {
          "address": {
            "city" : $('input[name="recipient_city"]').val(),
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
    },
    "dhl": {
        "RateRequest": {
          "ClientDetails": null,
          "RequestedShipment": {
              "DropOffType": "REQUEST_COURIER",
              "ShipTimestamp": "2022-06-01T09:10:09",
              "UnitOfMeasurement": "SI",
              "Content": "NON_DOCUMENTS",
              "PaymentInfo": "DDU",
            "Account": "",
              "Ship": {
                  "Shipper": {
                      "City": "",
                      "PostalCode": "65247",
                      "CountryCode": "US"
                  },
                  "Recipient": {
                      "City": "",
                      "PostalCode": "75063",
                      "CountryCode": "US"
                  }
              },
              "Packages": {
                  "RequestedPackages": {
                      "@number": "1",
                      "Weight": {
                          "Value": 20
                      },
                      "Dimensions": {
                          "Length": 20,
                          "Width": 20,
                          "Height": 20
                      }
                  }
              }
            }
          }
    },
    "ups":{},
    });

    // let input = JSON.stringify({
    //   "accountNumber": {
    //     "value": ""
    //   },
    //   "requestedShipment": {
    //     "shipper": {
    //       "address": {
    //         "postalCode": 65247,
    //         "countryCode": "US"
    //       }
    //     },
    //     "recipient": {
    //       "address": {
    //         "postalCode": 75063,
    //         "countryCode": "US"
    //       }
    //     },
    //     "pickupType": "DROPOFF_AT_FEDEX_LOCATION",
    //     "rateRequestType": [
    //       "ACCOUNT",
    //       "LIST"
    //     ],
    //     "requestedPackageLineItems": [
    //       {
    //         "weight": {
    //           "units": "LB",
    //           "value": 10
    //         }
    //       }
    //     ]
    //   }
    // });
    request(url, input);
    
    function request(url, input){
      console.log("starting petition");
      let data = ajax('POST', url, input, $('input[name="_token"]').val());
      
      data.then(function(response){
        console.log("Reading response");
        switch (response.fedexResponse.statusCode){
          case 200:
            showResult(response);
            console.log("Cool");
            console.log(JSON.stringify(response));
            break;
          case 400:
            console.log("Some information is missing");
            console.log(response);
            break;
          case 401:
            console.log("notAuth, asking token");
            console.log(response);
            break;
        }
      });
    }

    function showResult(data){
        $("#fedEx").show();
        $('#rates').remove();

        $('#id-rateRequest').after("<div id='rates'></div>");
        $("#rates").css("display", "flex").css("justify-content", "space-evenly");
        //FEDEX
        $('#rates').append("<div id='ratesFedex'></div>");
        $("#ratesFedex").css("display", "flex").css("flex-direction", "column").css("padding", "5rem");
        $("#ratesFedex").append("<h2 id='fedex'>FedEx</h2>");        
        // data.rateAndTransitTimes.output.rateReplyDetails.forEach(element => {
        //   $("#ratesFedex").append("<p id='fedexRate'><b>Tipo de servicio: " + element.serviceType + "</b></p>");
        //   $("#ratesFedex").append("<p id='fedexRate'>Servicio por: " + element.serviceName+ "</p>");
        //   $("#ratesFedex").append("<p id='fedexRate'>Tarifa neta: " + element.ratedShipmentDetails[0].totalNetCharge*19.55 + "</p>");          
        // });
        data.fedexResponse.response.output.rateReplyDetails.forEach(element => {
          $("#ratesFedex").append("<p id='fedexRate'><b>Tipo de servicio: " + element.serviceType + "</b></p>");
          $("#ratesFedex").append("<p id='fedexRate'>Servicio por: " + element.serviceName+ "</p>");
          $("#ratesFedex").append("<p id='fedexRate'>Tarifa neta: " + element.ratedShipmentDetails[0].totalNetCharge*19.55 + "</p>");          
        });


        //DHL
        $('#rates').append("<div id='ratesDhl'></div>");
        $("#ratesDhl").css("display", "flex").css("flex-direction", "column").css("padding", "5rem");
        $("#ratesDhl").append("<h2 id='dhl'>DHL</h2>");
        $("#ratesDhl").append("<p id='dhlRate'>Tarifa dhl: $</p>");
        //UPS
        $('#rates').append("<div id='ratesUps'></div>");
        $("#ratesUps").css("display", "flex").css("flex-direction", "column").css("padding", "5rem");
        $("#ratesUps").append("<h2 id='ups'>UPS</h2>");
//         $("#ratesUps").append("<p id='upsRate'>Tarifa UPS: $</p>");
    }
//////////////////////////////////////////////////////////////////


//     $.ajax({
//       type: 'POST',
//       url: url ,
//       data: {
//           rateAndTransiteTimes: $input,
//           _token: $('input[name="_token"]').val()
//       },
//     success: function(data){
//       switch(data.statusCode){
//         case 200: 
//         console.log(data.statusCode + JSON.stringify(data));

//         $('#rates').remove();

//         $('#id-rateRequest').after("<div id='rates'></div>");
//         $("#rates").css("display", "flex").css("justify-content", "space-evenly");
//         //FEDEX
//         $('#rates').append("<div id='ratesFedex'></div>");
//         $("#ratesFedex").css("display", "flex").css("flex-direction", "column").css("padding", "5rem");
//         $("#ratesFedex").append("<h2 id='fedex'>FedEx</h2>");
//         $("#ratesFedex").append("<p id='fedexRate'>Tarifa FedEx: $" + data.rateAndTransitTimes.output.rateReplyDetails[0].ratedShipmentDetails[0].totalNetCharge + "</p>");
//         //DHL
//         $('#rates').append("<div id='ratesDhl'></div>");
//         $("#ratesDhl").css("display", "flex").css("flex-direction", "column").css("padding", "5rem");
//         $("#ratesDhl").append("<h2 id='dhl'>DHL</h2>");
//         $("#ratesDhl").append("<p id='dhlRate'>Tarifa dhl: $</p>");
//         //UPS
//         $('#rates').append("<div id='ratesUps'></div>");
//         $("#ratesUps").css("display", "flex").css("flex-direction", "column").css("padding", "5rem");
//         $("#ratesUps").append("<h2 id='ups'>UPS</h2>");
//         $("#ratesUps").append("<p id='upsRate'>Tarifa UPS: $</p>");
//         break;
//         case 400:
//         console.log(data.statusCode + JSON.stringify(data));
//         break;
//         case 401:
//           // requeringToken(rateAndTransiteTimes);
//           break;
          
//           default:
//             console.log(data.statusCode + JSON.stringify(data));
            
//     }
//     },
//     error: function(data){
//         alert(JSON.stringify(data));
//         }
// });



////////////////////////////////////////////////////////////////////////////////////////////////








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

