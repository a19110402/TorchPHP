import ajax from '../ajax.js';


$("#cancelShip").on('click', function(){
  let input = JSON.stringify(
    {
      "accountNumber": {
        "value": ""
      },
      "trackingNumber": "794649568011"//794649568011 79464957872
  }
  );
  let response = ajax('PUT', '/cancelShipments', input, $("input[name='_token']").val());

  console.log(response);

});

$("#requestShipments").on('submit',
function(){
  let delivery = $('select[name="delivery"]').val();
    let url = $(this).attr('data-action');
    let input = JSON.stringify({
      'delivery': delivery,
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