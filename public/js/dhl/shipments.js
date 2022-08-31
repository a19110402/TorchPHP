import genericAjax from '../genericAjax.js';
import ajax from '../ajax.js';
import {dhlRecipientPostalCodeValidation, dhlShipperPostalCodeValidation} from '../dhl/validation.js'


export function getDate(){
    let date = new Date();
    let dateString =  date.getFullYear() + "-" + (date.getMonth()+1) + "-" + date.getDate();
    return dateString;
  }

//*******************************[buttons]*********************************************
$("#dhlValidatePostalCode").on("click",function(){
  if(dhlRecipientPostalCodeValidation == true && dhlShipperPostalCodeValidation ==true)
  {
    var dhlBlock = document.getElementsByClassName("dhlBlock");
    dhlBlock[0].nextElementSibling.style.display = "none";
    dhlBlock[1].nextElementSibling.style.display = "block";
  }
  else{
    alert("Verifica que los códigos postales sean correctos o que correspondan con su país");
  }
});

$("#dhlRequestRate").on('click',function(){
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
    let dhlUnitOfMeasurement = '';
    let date = getDate();
  
    switch(unitOfMeasurement)
    {
      case 'SI':
        dhlUnitOfMeasurement = 'SI';
        break;
        case 'SU':
        dhlUnitOfMeasurement = 'SU';
        break;
    }
  //let carrierCodes = $('select[name="carrierCodes"]').val();
  let url = "/fedex/rateAndServices"
  let input = JSON.stringify({
    "delivery": "dhl",
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
    }
    }
  );
    
  let data = genericAjax('POST', url, input, _token);
  data.then(
    function(response){
        //adapting dhlResponse to validate de statusCode of the response of the API
        console.log(response);
        let responseDhl = JSON.stringify(response.fedexResponse.response.RateResponse.Provider[0].Notification[0]);
        let codeDhl = responseDhl.replace("@", "");
        codeDhl = JSON.parse(codeDhl);
        //dhl response 200
        if(codeDhl.code == "0"){
            //display the next element of the form
            var dhlBlock = document.getElementsByClassName("dhlBlock");
            dhlBlock[1].nextElementSibling.style.display = "none";
            dhlBlock[2].nextElementSibling.style.display = "block";
            let cont = 0;
            let selector = '';

            if(response.fedexResponse.response.RateResponse.Provider[0].Service.length > 0){
                response.fedexResponse.response.RateResponse.Provider[0].Service.forEach(element =>{
                if(element.Charges != undefined && element.Charges.Charge.length != undefined){
                    selector = "#rates" + cont;
                    $("#ratesDhl").append("<div id='rates" + cont + "'></div>");
                    $(selector).append("<p hidden id='serviceType'>" + element.Charges.Charge[0].ChargeType + "</p>");
                    $(selector).append("<p>Servicio por: " + element.Charges.Charge[0].ChargeType + "</p>");
                    $(selector).append("<p>Tarifa neta: " + element.TotalNet.Amount + "</p>");
                    cont++; 
                //   $("#dhlRate").append("<p id='dhlRate'>Tipo de servicio:" + element.Charges.Charge[0].ChargeType + "</p>");
                //   $("#dhlRate").append("<p id='dhlRate'>Tarifa dhl: $" + element.TotalNet.Amount + "</p>");
                }    
                let addRates = $("#ratesDhl");
                addRates.children().css("display", "flex");
                addRates.children().css("flex-direction", "column");
                addRates.children().css("border", "3px solid black");
                addRates.children().css("padding", "5rem");
                addRates.children().css("cursor", "pointer");
              });
              
            }
            else{
              $("#dhlRate").append("<p id='dhlRate'>Tipo de servicio:" + response.fedexResponse.response.RateResponse.Provider[0].Service.Charges.Charge[0].ChargeType + "</p>");
              $("#dhlRate").append("<p id='dhlRate'>Tarifa dhl: $" + response.fedexResponse.response.RateResponse.Provider[0].Service.TotalNet.Amount + "</p>");
            }
          }
          else{
            $('#createShipDhl').hide();
            $("#createShipDhl").before("<div id='dhlRate'></div>");
            $("#dhlRate").append("<p id='dhlRate'>Servicio no disponible</p>");  
          }

          let i=0;
          let rates = document.querySelectorAll("#ratesDhl");
          for (i=0 ; i<rates[0].childElementCount ; i++)
          {
            let serviceType  = rates[0].children[i].children[0].innerHTML;
            rates[0].children[i].addEventListener("click", function(){
              alert(serviceType);
            });
          }
    }
  );

});

$("#requestFedex").on('submit',
function(){
    let url = $(this).attr('data-action');
    let input = JSON.stringify({
      'delivery': 'dhl',
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

var dhlBlock = document.getElementsByClassName("dhlBlock");
dhlBlock[0].addEventListener("click", function() {
      this.classList.toggle("active");
      var panel = this.nextElementSibling;
      if (panel.style.display === "block") {
      panel.style.display = "none";
      } else {
      panel.style.display = "block";
      }
  });
  dhlBlock[1].addEventListener("click", function(){
    this.classList.toggle("active");
    var panel = this.nextElementSibling;
    if (panel.style.display === "block") {
    panel.style.display = "none";
    } else if(dhlRecipientPostalCodeValidation == true && dhlShipperPostalCodeValidation == true){
    panel.style.display = "block";
    }
});

function showFedex(data){

      } 