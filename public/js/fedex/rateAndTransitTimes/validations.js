//THE AJAX FUNCTION IS A JS FILE WHICH ITS FUNCTIONALITY START AN AJAX PETITION
import ajax from '../../ajax.js';

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

  export function packageChange(){
    //reading inputs
    let packagingType = $("#packagingType").val();
    
    if (packagingType == "FEDEX_ENVELOPE"){
      $("#package").hide();
      let lenghtRequired = $("#lenght");
      let widthRequired = $("#width");
      let heightRequired = $("#height");
      //Make the dimention forms required
      lenghtRequired.removeAttr('required');
      widthRequired.removeAttr('required');
      heightRequired.removeAttr('required');
      //Clear dimention forms
      lenghtRequired.val("");
      widthRequired.val("");
      heightRequired.val("");
    }
    else{
      $("#package").show();
      let lenghtRequired = $("#lenght");
      let widthRequired = $("#width");
      let heightRequired = $("#height");
      //Make the dimention forms required
      lenghtRequired.prop('required', 'true');
      widthRequired.prop('required', 'true');
      heightRequired.prop('required', 'true');
    }
    weightError();
  }
  function weightError(){
    $("#weightLimit").remove();
    let weight = $("#weight").val();
    if( weight > 997  && $('#packagingType').val() == "YOUR_PACKAGING"){
      $("#weight").css("border-color", "red").after("<p id='weightLimit'>Límite excedido (max. 997kg)</p>");
      $("#weightLimit").css("font-size", "1rem");
    }
    else if(weight > 0.5  && $('#packagingType').val() == "FEDEX_ENVELOPE"){
      $("#weight").css("border-color", "red").after("<p id='weightLimit'>Límite excedido (max. 0.5kg)</p>");
      $("#weightLimit").css("font-size", "1rem");
    }
    else if(weight != 0){
      $("#weight").css("border", "2px solid #8bef89");
    }
  }
//EVALUATING EVERY TIME THERE IS A CHANGE
  $("#shipper_postalCode").on('change',function(e){
    $("#shipper_postalCode").css("border-color", "black");
    $(".shipperPostalCodeNotFound").remove();
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
            $("#shipper_postalCode").css("border", "2px solid red").after("<p id='shipperPostalCodeNotFound'>No pudimos encontrar el código postal</p>");  
            $("#shipperPostalCodeNotFound").css("font-size", "1rem");
          }
    });
  });
  
  $("#recipient_postalCode").on('change',function(e){
    $("#recipient_postalCode").css("border-color", "black");
    let recipientPostalCode = $('input[name="recipient_postalCode"]').val();
    let recipientCountryCode = $('select[name="recipient_countryCode"]').val();
    $(".recipientPostalCodeNotFound").remove();
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
          $("#recipient_postalCode").css("border", "2px solid red").after("<p id='recipientPostalCodeNotFound'>No pudimos encontrar el código postal</p>");   
          $("#recipientPostalCodeNotFound").css("font-size", "1rem");
        }
  });
  });

  $("#weight").on("keyup", function(){
    weightError();
  });
  
//EVALUATING EVERY TIME A KEY IS CLICKED-UP
  $("#lenght").on("keyup", function(){
    $("#lenghtLimit").remove();
    let lenght = $("#lenght").val();
    if( lenght > 999){
      $("#lenght").css("border-color", "red").after("<p id='lenghtLimit'>Límite excedido (max. 999cm)</p>");
      $("#lenghtLimit").css("font-size", "1rem");
    }
    else{
      $("#lenght").css("border", "2px solid #8bef89");
    }
    
  });

  $("#width").on("keyup", function(){
    $("#widthLimit").remove();
    let width = $("#width").val();
    if( width > 999){
      $("#width").css("border-color", "red").after("<p id='widthLimit'>Límite excedido (max. 999cm)</p>");
      $("#widthLimit").css("font-size", "1rem");
    }
    else{
      $("#width").css("border", "2px solid #8bef89");
    }
    
  });
  $("#height").on("keyup", function(){
    $("#heightLimit").remove();
    let height = $("#height").val();
    if( height > 999){
      $("#height").css("border-color", "red").after("<p id='heightLimit'>Límite excedido (max. 999cm)</p>");
      $("#heightLimit").css("font-size", "1rem");
    }
    else{
      $("#height").css("border", "2px solid #8bef89");
    }
  });

  $("#packagingType").on("change", function(e){
    packageChange();
  })