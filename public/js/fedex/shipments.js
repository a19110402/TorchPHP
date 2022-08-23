import ajax from '../ajax.js';
import {recipientPostalCodeValidation, shipperPostalCodeValidation} from './rateAndTransitTimes/validations.js'
$(function(){
  // $("#shipFormFull").hide();
  $("#waitingMessage").hide();
});

export function getDate(){
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
//*******************************[buttons]*********************************************
$("#validatePostalCode").on("click",function(){
  if(shipperPostalCodeValidation == true && recipientPostalCodeValidation ==true)
  {
    var acc = document.getElementsByClassName("accordion");
    acc[0].nextElementSibling.style.display = "none";
    acc[1].nextElementSibling.style.display = "block";
  }
  else{
    alert("Verifica que los códigos postales sean correctos o que correspondan con su país");
  }
});

$("#requestShip").on('click',function(){
  let _token = $('input[name="_token"]').val();
  let shipperCity = $('input[name="shipperCity"]').val();
  let shipperPostalCode = $('input[name="shipperPostalCode"]').val();
  let shipperCountrCode = $('select[name="shipperCountryCode"]').val();
  //recipient
  let recipientCity = $('input[name="recipientCity"]').val();
  let recipientPostalCode = $('input[name="recipientPostalCode"]').val();
  let recipientCountryCode = $('select[name="recipientCountryCode"]').val();
  //package
  //let totalPackageCount = $('input[name="totalPackages"]').val();
  let unitOfMeasurement = $('select[name="units"]').val();
  let pickupType = $('select[name="pickupType"]').val();
  let packagingType = $('select[name="subPackagingType"]').val();
  let weight = $('input[name="weight"]').val();
  let lenght = $('input[name="lenght"]').val();
  let width = $('input[name="width"]').val();
  let height = $('input[name="height"]').val();
  //shipmentVariables
    //[__Fedex__]
    let carrierFedex = '';
    let fedexUnitOfMeasurement = '';
    let fedexUnitOfLenght = ''
    let date = getDate();
  
    switch(unitOfMeasurement)
    {
      case 'SI':
        fedexUnitOfMeasurement = 'KG';
        fedexUnitOfLenght = 'CM';
        break;
        case 'SU':
        fedexUnitOfMeasurement = 'LB';
        fedexUnitOfLenght = 'IN';
        break;
    }
  //let carrierCodes = $('select[name="carrierCodes"]').val();
  let url = "/fedex/rateAndServices"
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
        // "totalPackageCount": totalPackageCount,
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
      }
    }
    }
  );
    
  let data = ajax('POST', url, input, _token);
  data.then(
    function(response){
      switch(response.fedexResponse.statusCode)
      {
        case 200:
          var acc = document.getElementsByClassName("accordion");
          acc[1].nextElementSibling.style.display = "none";
          acc[2].nextElementSibling.style.display = "block";

        showFedex(response);
          let i;
          let text = document.querySelectorAll("#ratesFedex");
          for (i=0 ; i<text[0].childElementCount ; i++)
          {
            let serviceType  = text[0].children[i].children[0].innerHTML;
            text[0].children[i].addEventListener("click", function(){
              alert(serviceType);
            });
          }
        // let selector = $("#ratesFedex");
        // selector.children().on('click', function(){
        //   let text = document.getElementById("ratesFedex");
        //   text = text.children[0].innerHTML;
        //   console.log(text);
        // });
          break;
        default:
      }
    }
  );
});



$("#showServiceAvailableForm").on('click', function(){       
  $("#serviceType").empty();
  hideSpan();
  $("#shipFormFull").hide();
  $("#serviceAvailabilityValidation").show();
});

$("#validateAvailableServices").on('click', function(){
  //shipper
  let shipperPostalCode = $('input[name="shipperPostalCode"]').val();
  let shipperCountrCode = $('select[name="shipperCountryCode"]').val();
  //recipient
  let recipientPostalCode = $('input[name="recipientPostalCode"]').val();
  let recipientCountryCode = $('select[name="recipientCountryCode"]').val();
  let _token = $('input[name="_token"]').val();
  let url = '/fedex/serviceAvailability'
  showSpan();
  let input = JSON.stringify(
    {
      "requestedShipment": {
      "shipper": {
      "address": {
      "postalCode": shipperPostalCode,
      "countryCode": shipperCountrCode
      }
      },
      "recipients": [
      {
      "address": {
      "postalCode": recipientPostalCode,
      "countryCode": recipientCountryCode
      }
      }
      ]
      },
      "carrierCodes": [
      "FDXE",
      "FDXG"
      ]
      }
  );
  //COLOCAR MENSJE ENTRE ESTE ESPACIO DE TIEMPO EN LO QUE SE VERIFICAN LOS SERVICIOS DISPONIBLES
    let data = ajax('POST',url, input, _token);
      data.then(
        function(response){
          console.log(response);
          switch (response.fedexResponse.statusCode)
          {
            case 200:
              hideSpan();
              $("#serviceAvailabilityValidation").hide();
              $("#shipFormFull").show();
              response = response.fedexResponse.validation.output;
              response.packageOptions.forEach(element => {
                if(element.packageType.key != "FEDEX_ENVELOPE"){
                  $('#serviceType').append($('<option>', {
                    value: element.serviceType.key,
                    text: element.serviceType.displayText
                }
                ));
                }
              });
              break;
            case 400:
              hideSpan();
              $("#serviceAvailabilityValidation").show();
              alert("Error en información")
              break;
            default:
          }
        }
      );
});

$("#requestFedex").on('submit',
function(){
  let delivery = $('select[name="delivery"]').val();
    let url = $(this).attr('data-action');
    let input = JSON.stringify({
      'delivery': 'fedex',
      'json':{
          "shipper": {
            "contact": {
              "personName": $('input[name="shipperPersonName"]').val(),
              "phoneNumber": $('input[name="shipperPhoneNumber"]').val(),
              "shipperEmail":  $("input[name='shipperEmail']").val(),
              "company":  $("input[name='shipperCompany']").val()
            },
            "address": {
              "streetLines": $('input[name="shipperStreetLines"]').val()
              ,
              "city": $('input[name="shipperCity"]').val(),
              "stateOrProvinceCode": $('input[name="shipperStateOrProvinceCode"]').val(),
              "postalCode": $('input[name="shipperPostalCode"]').val(),
              "countryCode":  $('select[name="shipperCountryCode"]').val()
            }
          },
          "recipients": [
            {
              "contact": {
                "personName": $('input[name="recipientPersonName"]').val(),
                "phoneNumber": $('input[name="recipientPhoneNumber"]').val(),
                "recipientEmail":  $("input[name='recipientEmail']").val(),
                "company":  $("input[name='recipientCompany']").val()
              },
              "address": {
                "streetLines": $('input[name="recipientStreetlines"]').val(),
                "city": $('input[name="recipientCity"]').val(),
                "stateOrProvinceCode": $('input[name="recipientStateOrProvinceCode"]').val(),
                "postalCode": $('input[name="recipientPostalCode"]').val(),
                "countryCode": $('select[name="recipientCountryCode"]').val()
              }
            }
          ],
          "shipDatestamp": $('input[name="shipDatestamp"]').val(),
          "serviceType": $('select[name="serviceType"]').val(),
          "packagingType": $('select[name="packagingType"]').val(),
          "pickupType": $('select[name="pickupType"]').val(),
          "shippingChargesPayment": {
            "paymentType": "SENDER"
          },
          "requestedPackageLineItems": [
            {
              "weight": {
                "units": $("select[name='units']").val(),
                "value": $("input[name='weight']").val()
              },
              "dimensions":{
                "lenght": $("input[name='lenght']").val(),
                "width":  $("input[name='width']").val(),
                "height": $("input[name='height']").val()
              }
            }
          ]
        }
      });
        console.log(input);
        request(url, input,  $('input[name="_token"]').val());
        
        function request(url, input, _token){
            console.log("Starting petition");
            let  data = ajax('POST', url, input, _token);

            data.then(function(response){
                console.log("Reading response");
                switch (response.fedexResponse.statusCode){
                  case 200:
                      // console.log(JSON.stringify(response.fedexResponse.response.shipAPI.output.transactionShipments[0].masterTrackingNumber))
                        console.log("Cool");
                        console.log(response);
                        // $('#trackingNumber').text("Your tracking number is: " + response.shipAPI.output.transactionShipments[0].masterTrackingNumber);
                        // trackingNumber.innerHTML = response.shipAPI.output.transactionShipments[0].masterTrackingNumber;
                        // $('#validateShipment').append("Your Tracking Number is: " + trackingNumber);
                        break;
                    case 400:
                      console.log(response);
                      break;
                      case 401:
                        break;
                      default:
                      console.log(response);
                }
            });
        }

    }
);

function showSpan(){
  $("#serviceAvailabilityValidation").hide();
  $("#waitingMessage").show();
}

function hideSpan(){
  $("#waitingMessage").hide();
}

var acc = document.getElementsByClassName("accordion");
acc[0].addEventListener("click", function() {
      this.classList.toggle("active");
      var panel = this.nextElementSibling;
      if (panel.style.display === "block") {
      panel.style.display = "none";
      } else {
      panel.style.display = "block";
      }
  });
acc[1].addEventListener("click", function(){
    this.classList.toggle("active");
    var panel = this.nextElementSibling;
    if (panel.style.display === "block") {
    panel.style.display = "none";
    } else if(recipientPostalCodeValidation == true && shipperPostalCodeValidation == true){
    panel.style.display = "block";
    }
});
// for (i = 0; i < acc.length; i++) {
// acc[i].addEventListener("click", function() {
//     this.classList.toggle("active");
//     var panel = this.nextElementSibling;
//     if (panel.style.display === "block") {
//     panel.style.display = "none";
//     } else {
//     panel.style.display = "block";
//     }
// });
// }

function showFedex(data){
  let cont=0;
  let selector = '';
        $("#showRates").show();
        //FEDEX

        // $('#rates').append("<div id='ratesFedex'></div>");
        // $("#ratesFedex").css("display", "flex").css("flex-direction", "column").css("padding", "5rem");
        // $("#ratesFedex").append("<h2 id='fedex'>FedEx</h2>");      
        if(data.fedexResponse.statusCode == 200){
          // $("#showRates").append("<div id='fedexRate'></div>");
          data.fedexResponse.response.output.rateReplyDetails.forEach(element => {
            selector = "#rates" + cont;
            $("#ratesFedex").append("<div id='rates" + cont + "'></div>");
            $(selector).append("<p hidden id='serviceType'>" + element.serviceType + "</p>");
            $(selector).append("<p>Servicio por: " + element.serviceName+ "</p>");
            $(selector).append("<p>Tarifa neta: " + element.ratedShipmentDetails[0].totalNetCharge*19.55 + "</p>");
            cont++;
          });
          // let i=0;
          let addRates = $("#ratesFedex");
          addRates.children().css("display", "flex");
          addRates.children().css("flex-direction", "column");
          addRates.children().css("border", "3px solid black");
          addRates.children().css("padding", "5rem");
          addRates.children().css("cursor", "pointer");

          // var addRates = document.getElementById("ratesFedex");

          // data.fedexResponse.response.output.rateReplyDetails.forEach(element => {
          //   // addRates.children[i].append("Tipo de servicio: " + element.serviceType);
          //   addRates.children[i].append("Servicio por: " + element.serviceName);
          //   addRates.children[i].append("Tarifa neta: " + element.ratedShipmentDetails[0].totalNetCharge*19.55);   
          //   i++;
          // });

          // $("#rates").append("<p><b>Tipo de servicio: " + element.serviceType + "</b></p>");
          // $("#rates").append("<p>Servicio por: " + element.serviceName+ "</p>");
          // $("#rates").append("<p>Tarifa neta: " + element.ratedShipmentDetails[0].totalNetCharge*19.55 + "</p>");   
          $('#createShipFedex').show();
        }  
        else{
          $("#createShipFedex").before("<div id='fedexRate'></div>");
          $("#fedexRate").append("<p id='fedexRate'>Servicio no disponible</p>");      
          $('#createShipFedex').hide();
        }
      } 