$(document).ready(function(){
    $('#global-trade-fedex-form').on('submit', function(event){
        $url = $(this).attr('data-action');
        $input = JSON.stringify({
            'carrierCode':$('input[name="carrierCode"]').val(),
            'harmonizedCode':$('input[name="harmonizedCode"]').val(),
            'countryCodeOrigin':$('select[name="countryCodeOrigin"]').val(),
            'countryCodeDestination':$('select[name="countryCodeDestination"]').val(),
        });
        $.ajax({
            type:'POST',
            url:$url + '/globalTradeRequest',
            data: {
                global_trade: $input,
                _token: $('input[name="_token"]').val(), 
            },
            success:function(data) {
                //window.confirm(data.validateAddressJson.errors[0].code + " " +JSON.stringify(data.cookie))
                switch(data.statusCode){
                    case 200:
                        console.log("SMN");
                        console.log(JSON.stringify(data));
                        if (window.confirm(JSON.stringify(data))){
                            //window.location = $url;
                        }
                    break;
                    case 400:
                    case 401:
                    case 403:
                    case 404:
                    case 500:
                    case 503:
                        console.log("NEL");
                        window.confirm(data.statusCode + " " + JSON.stringify(data))
                        console.log(JSON.stringify(data));
                    break;
                    default:
                        window.confirm(data.validateAddressJson.errors[0].code + " " +JSON.stringify(data.cookie))
                }
            },
            error:function(data){
                alert(JSON.stringify(data));
            }
        });
    });
});