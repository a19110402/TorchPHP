import ajax from '../../ajax.js';
import { packageChange } from './validations.js';
import { getDate } from './validations.js';
$(function(){
  packageChange();
  $("#showRates").hide();
});

$("#requestRate").on('submit',
function (){
  $('#fedexRate').remove();
  $('#dhlRate').remove();
  $('#upsRate').remove();
  $("#showRates").hide();
  //shipper
  let shipperCity = $('input[name="shipper_city"]').val();
  let shipperPostalCode = $('input[name="shipperPostalCode"]').val();
  let shipperCountrCode = $('select[name="shipperCountryCode"]').val();
  //recipient
  let recipientCity = $('input[name="recipient_city"]').val();
  let recipientPostalCode = $('input[name="recipientPostalCode"]').val();
  let recipientCountryCode = $('select[name="recipientCountryCode"]').val();
  //package
  let totalPackageCount = $('input[name="totalPackages"]').val();
  let unitOfMeasurement = $('select[name="unitOfMeasurement"]').val();
  let pickupType = $('select[name="pickupType"]').val();
  let packagingType = $('select[name="subPackagingType"]').val();
  let weight = $('input[name="weight"]').val();
  let lenght = $('input[name="lenght"]').val();
  let width = $('input[name="width"]').val();
  let height = $('input[name="height"]').val();
  //shipmentVariables
  let carrierCodes = $('select[name="carrierCodes"]').val();
  //[__Fedex__]
  let upsServiceDescription = '';
  let carrierFedex = '';
  let carrierUps = '';
  let fedexUnitOfMeasurement = '';
  let fedexUnitOfLenght = ''
  let dhlUnitOfMeasurement = '';
  let dhlUnitOfLenght = '';
  let upsUnitOfMeasurement = '';
  let upsUnitOfLenght = '';
  let date = getDate();
  

  switch(carrierCodes)
  {
    case 'express':
      carrierFedex = 'FDXE';
      carrierUps = '07';
      upsServiceDescription = 'express';
      break;
      case 'ground':
      carrierFedex = 'FDXG';
      carrierUps = '03';
      upsServiceDescription = 'ground';
      break;
  }
  switch(unitOfMeasurement)
  {
    case 'SI':
      fedexUnitOfMeasurement = 'KG';
      fedexUnitOfLenght = 'CM';
      dhlUnitOfMeasurement = 'SI';
      upsUnitOfMeasurement = 'KBS';
      upsUnitOfLenght = 'CM';
      break;
      case 'SU':
      fedexUnitOfMeasurement = 'LB';
      fedexUnitOfLenght = 'IN';
      dhlUnitOfMeasurement = 'SU';
      upsUnitOfMeasurement = 'LBS';
      upsUnitOfLenght = 'IN';
      break;
  }

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
            "city" : shipperCity,
            "postalCode": shipperPostalCode,
              "countryCode": shipperCountrCode,
              }
        },
        "recipient": {
          "address": {
            "city" : recipientCity,
            "postalCode": recipientPostalCode,
            "countryCode": recipientCountryCode
          }
        },
        "pickupType": pickupType,
        "totalPackageCount": totalPackageCount,
        "rateRequestType":["LIST", "ACCOUNT"],
        "requestedPackageLineItems": [{
          "packagingType": packagingType,
          "weight": {
            "units": fedexUnitOfMeasurement,
            "value": weight,
          },
          "dimensions": {
            "length": lenght,
            "width": width,
            "height": height,
            "units": fedexUnitOfLenght
          }
        }]
      },
      "carrierCode": carrierFedex
    },
    "dhl": {
        "RateRequest": {
          "ClientDetails": null,
          "RequestedShipment": {
              "DropOffType": "REQUEST_COURIER",
              "ShipTimestamp": "2022-06-01T09:10:09",
              "UnitOfMeasurement": dhlUnitOfMeasurement,
              "Content": "NON_DOCUMENTS",
              "PaymentInfo": "DDU",
            "Account": "",
              "Ship": {
                  "Shipper": {
                      "City": "",
                      "PostalCode": shipperPostalCode,
                      "CountryCode": shipperCountrCode
                  },
                  "Recipient": {
                      "City": "",
                      "PostalCode": recipientPostalCode,
                      "CountryCode": recipientCountryCode
                  }
              },
              "Packages": {
                  "RequestedPackages": {
                      "@number": "1",
                      "Weight": {
                          "Value": weight
                      },
                      "Dimensions": {
                          "Length": lenght,
                          "Width": width,
                          "Height": height
                      }
                  }
              }
            }
          }
    },
    "ups":
    {
      "RateRequest": {
        "Request": {
          "SubVersion": "1703",
          "TransactionReference": {
            "CustomerContext": " "
          }
        },
        "Shipment": {
          "ShipmentRatingOptions": {
            "UserLevelDiscountIndicator": "TRUE"
          },
          "Shipper": {
            "Address": {
              "PostalCode": shipperPostalCode,
              "CountryCode": shipperCountrCode
            }
          },
          "ShipTo": {
            "Address": {
              "PostalCode": recipientPostalCode,
              "CountryCode": recipientCountryCode
            }
          },
          "Service": {
            "Code": carrierUps
          },
          "ShipmentTotalWeight": {
            "UnitOfMeasurement": {
              "Code": upsUnitOfMeasurement
            },
            "Weight": "10"
          },
          "Package": {
            "PackagingType": {
              "Code": "02",
              "Description": "Package"
            },
            "Dimensions": {
              "UnitOfMeasurement": {
                "Code": upsUnitOfLenght
              },
              "Length": "10",
              "Width": "7",
              "Height": "5"
            },
            "PackageWeight": {
              "UnitOfMeasurement": {
                "Code": "kgs"
              },
              "Weight": "7"
            }
          }
        }
      }
    } 
    });
    console.log(JSON.parse(input));
    request(url, input);
    
    function request(url, input){
      console.log("starting petition");
      let data = ajax('POST', url, input, $('input[name="_token"]').val());
      data.then(function(response){
        $('#id-rateRequest').after("<div id='rates'></div>");
        $("#rates").css("display", "flex").css("justify-content", "space-evenly");
        console.log(response);
        //adapting dhlResponse to validate de statusCode of the response of the API
        let responseDhl = JSON.stringify(response.dhlResponse.response.RateResponse.Provider[0].Notification[0]);
        let codeDhl = responseDhl.replace("@", "");
        codeDhl = JSON.parse(codeDhl);
        console.log("Reading response");
        console.log("UPS response");
        console.log(JSON.stringify(response.upsResponse));

        //FedEx
        switch (response.fedexResponse.statusCode){
          case 200:
            showFedex(response);
            console.log("Cool");
            console.log(response);
            break;
          case 400:
            showFedex(response);
            console.log("Some information is missing");
            console.log(response);
            break;
          case 401:
            console.log("notAuth, asking token");
            console.log(response);
            break;
          default:
            console.log(response);
        }
        //DHL   
        showDhl(response, codeDhl.code);   
        // switch (codeDhl.code){
        //   case '0':
        //     showDhl(response, codeDhl.code);
        //     showUps(response);
        //     console.log("Cool");
        //     console.log(JSON.stringify(response));
        //     break;
        //   case 400:
        //     showDhl(response, codeDhl.code);
        //     console.log("Some information is missing");
        //     console.log(response);
        //     break;
        // }
        //UPS
        switch (response.upsResponse.statusCode){
          case 200:
            showUps(response.upsResponse);
            console.log("Cool");
            console.log(JSON.stringify(response));
            break;
          case 400:
            showUps(response.upsResponse);
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

    function showFedex(data){
        $("#showRates").show();
        //FEDEX

        // $('#rates').append("<div id='ratesFedex'></div>");
        // $("#ratesFedex").css("display", "flex").css("flex-direction", "column").css("padding", "5rem");
        // $("#ratesFedex").append("<h2 id='fedex'>FedEx</h2>");      
        if(data.fedexResponse.statusCode == 200){
          $("#createShipFedex").before("<div id='fedexRate'></div>");
          data.fedexResponse.response.output.rateReplyDetails.forEach(element => {
            $("#fedexRate").append("<p><b>Tipo de servicio: " + element.serviceType + "</b></p>");
            $("#fedexRate").append("<p>Servicio por: " + element.serviceName+ "</p>");
            $("#fedexRate").append("<p>Tarifa neta: " + element.ratedShipmentDetails[0].totalNetCharge*19.55 + "</p>");     
          });
          $('#createShipFedex').show();
        }  
        else{
          $("#createShipFedex").before("<div id='fedexRate'></div>");
          $("#fedexRate").append("<p id='fedexRate'>Servicio no disponible</p>");      
          $('#createShipFedex').hide();
        }
      } 
function showDhl(data, code){
  $("#showRates").show();
  //DHL
  // $('#rates').append("<div id='ratesDhl'></div>");
  // $("#ratesDhl").css("display", "flex").css("flex-direction", "column").css("padding", "5rem");
  // $("#ratesDhl").append("<h2 id='dhl'>DHL</h2>");
  if(code == "0"){
    $("#createShipDhl").before("<div id='dhlRate'></div>");
    $('#createShipDhl').show();
    if(data.dhlResponse.response.RateResponse.Provider[0].Service.length > 0){
      data.dhlResponse.response.RateResponse.Provider[0].Service.forEach(element =>{
        if(element.Charges != undefined && element.Charges.Charge.length != undefined){
          $("#dhlRate").append("<p id='dhlRate'>Tipo de servicio:" + element.Charges.Charge[0].ChargeType + "</p>");
          $("#dhlRate").append("<p id='dhlRate'>Tarifa dhl: $" + element.TotalNet.Amount + "</p>");
        }    
      });
      
    }
    else{
      $("#dhlRate").append("<p id='dhlRate'>Tipo de servicio:" + data.dhlResponse.response.RateResponse.Provider[0].Service.Charges.Charge[0].ChargeType + "</p>");
      $("#dhlRate").append("<p id='dhlRate'>Tarifa dhl: $" + data.dhlResponse.response.RateResponse.Provider[0].Service.TotalNet.Amount + "</p>");
    }
  }
  else{
    $('#createShipDhl').hide();
    $("#createShipDhl").before("<div id='dhlRate'></div>");
    $("#dhlRate").append("<p id='dhlRate'>Servicio no disponible</p>");  
  }
}
function showUps(data){
  $("#showRates").show();
    //UPS
    if(data.statusCode == 200)
    {
      $('#createShipUps').show();
      console.log("ups: " + JSON.stringify(data.statusCode));
      $("#createShipUps").before("<div id='upsRate'></div>");
      $("#upsRate").append("<p> Tipo de servicio" + "</p>");
      $("#upsRate").append("<p> Tarifa " + upsServiceDescription + ": $" + data.response.RateResponse.RatedShipment.TotalCharges.MonetaryValue + "</p>");

    }
    else{
      $('#createShipUps').hide();
      $("#createShipUps").before("<div id='upsRate'></div>");
      $("#upsRate").append("<p id='fedexRate'>Servicio no disponible</p>");      
    }
    // // $('#rates').append("<div id='ratesUps'></div>");
    // $("#ratesUps").css("display", "flex").css("flex-direction", "column").css("padding", "5rem");
    // $("#ratesUps").append("<h2 id='ups'>UPS</h2>");
  }
}
);

