$(document).ready(function(){
    $('#get-validate-addres-fedex-form').on('submit', function(event){
        $url = $(this).attr('data-action');
        $input = JSON.stringify({
            'country_code':$('select[name="countryCode"]').val(),
            'street_lines':$('input[name="streetLines"]').val(),
        });
        $.ajax({
            type:'POST',
            url:$url + '/addresValidationRequest',
            data: {
                address_to_validate: $input,
                _token: $('input[name="_token"]').val(), 
            },
            success:function(data) {
                switch(data.statusCode){
                    case 200:
                        if (window.confirm(data.validateAddressJson.output.resolvedAddresses[0].customerMessages[0].code + " (" + data.statusCode + ")")){
                            //window.location = $url;
                        }
                    break;
                    case 400:
                    case 401:
                    case 403:
                    case 404:
                    case 500:
                    case 503:
                        window.confirm(data.statusCode + " " + data.validateAddressJson.errors[0].message)
                    break;
                    default:
                        window.confirm(data.validateAddressJson.errors[0].code + " " +JSON.stringify(data.cookie))
                }
            },
            error:function(x,xs,xt){
                alert("Error");
            }
        });
    });
});
