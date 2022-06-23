import ajax from '../ajax.js';
// $("#fedEx").hide();


function getDate(){
  let date = new Date();
  let dateString =  date.getFullYear() + "-" + (date.getMonth()+1) + "-" + date.getDate();
  return dateString;
}

function validatePostalCode(postalCodeAPI){
  let response = '';
  let x;
  response = ajax('POST', '/validatePostalCode', postalCodeAPI, $('input[name="_token"]').val() );
  response.then(function(answer){
    x = answer.fedexResponse.statusCode;
  });
  return response;
}

$("#shipper_postalCode").on('change',function(e){
  $("#shipper_postalCode").css("border-color", "black");
  let shipperPostalCode = $('input[name="shipper_postalCode"]').val();
  let shipperCountrCode = $('select[name="shipper_countryCode"]').val();
  // let shipperCity = $('input[name="shipper_city"]').val();
  let postalCodeAPI = JSON.stringify({
    "carrierCode": "FDXG",
    "countryCode": shipperCountrCode,
    "postalCode": shipperPostalCode,
    "shipDate": getDate()
});
  let myPromise = new Promise(function(resolve){
    let response = validatePostalCode(postalCodeAPI);
    resolve(response);
  });

  myPromise.then(function(response){
    switch(response.fedexResponse.statusCode){
        case 200:
          $("#shipper_postalCode").css("border", "2px solid #8bef89");  
          break;
        case 400:
          $("#shipper_postalCode").css("border", "2px solid red");  
        }
  });
   
  // let response = validatePostalCode(postalCodeAPI);
  // switch(response.fedexResponse.statusCode){
  //   case 200:
  //     $("#shipper_postalCode").css("border", "2px solid green");  
  //     break;
  // }
});

$("#recipient_postalCode").on('change',function(e){
  let recipientPostalCode = $('input[name="recipient_postalCode"]').val();
  let recipientCountryCode = $('select[name="recipient_countryCode"]').val();
  // let recipientCity = $('input[name="recipient_city"]').val();
  let postalCodeAPI = JSON.stringify({
    "carrierCode": "FDXG",
    "countryCode": recipientCountryCode,
    "postalCode": recipientPostalCode,
    "shipDate": getDate()
});
let myPromise = new Promise(function(resolve){
  let response = validatePostalCode(postalCodeAPI);
  resolve(response);
});

myPromise.then(function(response){
  switch(response.fedexResponse.statusCode){
      case 200:
        $("#recipient_postalCode").css("border", "2px solid #8bef89");  
        break;
      case 400:
        $("#recipient_postalCode").css("border", "2px solid red");  
      }
});
});

$("#requestRate").on('submit',
function (){
  $('#rates').remove();
  //shipper
  let shipperCity = $('input[name="shipper_city"]').val();
  let shipperPostalCode = $('input[name="shipper_postalCode"]').val();
  let shipperCountrCode = $('select[name="shipper_countryCode"]').val();
  //recipient
  let recipientCity = $('input[name="recipient_city"]').val();
  let recipientPostalCode = $('input[name="recipient_postalCode"]').val();
  let recipientCountryCode = $('select[name="recipient_countryCode"]').val();
  //package
  let pickupType = $('select[name="pickupType"]').val();
  let weight = $('input[name="weight"]').val();
  let lenght = $('input[name="lenght"]').val();
  let width = $('input[name="width"]').val();
  let height = $('input[name="height"]').val();
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
        "rateRequestType":["LIST", "ACCOUNT"],
        "requestedPackageLineItems": [{
          "weight": {
            "units": "LB",
            "value": weight,
          },
          "dimensions": {
            "length": lenght,
            "width": width,
            "height": height,
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
    "ups":{},
    });
    request(url, input);
    
    function request(url, input){
      console.log("starting petition");
      let data = ajax('POST', url, input, $('input[name="_token"]').val());
      data.then(function(response){
        $('#id-rateRequest').after("<div id='rates'></div>");
        $("#rates").css("display", "flex").css("justify-content", "space-evenly");
        console.log(response.dhlResponse);
        let responseDhl = JSON.stringify(response.dhlResponse.response.RateResponse.Provider[0].Notification[0]);
        let codeDhl = responseDhl.replace("@", "");
        codeDhl = JSON.parse(codeDhl);
        console.log("Reading response");
        //FedEx
        switch (response.fedexResponse.statusCode){
          case 200:
            showFedex(response);
            console.log("Cool");
            console.log(response);
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
        //DHL        
        switch (codeDhl.code){
          case '0':
            showDhl(response);
            showUps(response);
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
        //UPS
        switch (response.upsResponse.statusCode){
          case 200:
            showFedex(response);
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

    function showFedex(data){
        $("#fedEx").show();
        //FEDEX
        $('#rates').append("<div id='ratesFedex'></div>");
        $("#ratesFedex").css("display", "flex").css("flex-direction", "column").css("padding", "5rem");
        $("#ratesFedex").append("<h2 id='fedex'>FedEx</h2>");        
        data.fedexResponse.response.output.rateReplyDetails.forEach(element => {
          $("#ratesFedex").append("<p id='fedexRate'><b>Tipo de servicio: " + element.serviceType + "</b></p>");
          $("#ratesFedex").append("<p id='fedexRate'>Servicio por: " + element.serviceName+ "</p>");
          $("#ratesFedex").append("<p id='fedexRate'>Tarifa neta: " + element.ratedShipmentDetails[0].totalNetCharge*19.55 + "</p>");          
        });
}
function showDhl(data){
  //DHL
  $('#rates').append("<div id='ratesDhl'></div>");
  $("#ratesDhl").css("display", "flex").css("flex-direction", "column").css("padding", "5rem");
  $("#ratesDhl").append("<h2 id='dhl'>DHL</h2>");
  if(data.dhlResponse.response.RateResponse.Provider[0].Service.length > 0){
    data.dhlResponse.response.RateResponse.Provider[0].Service.forEach(element =>{
      if(element.Charges !== undefined){
        $("#ratesDhl").append("<p id='dhlRate'>Tipo de servicio:" + element.Charges.Charge[0].ChargeType + "</p>");
        $("#ratesDhl").append("<p id='dhlRate'>Tarifa dhl: $" + element.TotalNet.Amount + "</p>");
      }
     
    });
    
  }
  else{
    $("#ratesDhl").append("<p id='dhlRate'>Tipo de servicio:" + data.dhlResponse.response.RateResponse.Provider[0].Service.Charges.Charge[0].ChargeType + "</p>");
    $("#ratesDhl").append("<p id='dhlRate'>Tarifa dhl: $" + data.dhlResponse.response.RateResponse.Provider[0].Service.TotalNet.Amount + "</p>");
  }
}
function showUps(data){
      //UPS
      $('#rates').append("<div id='ratesUps'></div>");
      $("#ratesUps").css("display", "flex").css("flex-direction", "column").css("padding", "5rem");
      $("#ratesUps").append("<h2 id='ups'>UPS</h2>");
    }
}
);

