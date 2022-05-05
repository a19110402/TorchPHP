$(document).ready(function(){
    $('#find-location-fedex-form').on('submit', function(event){
        $url = $(this).attr('data-action');
        $input = JSON.stringify({
            'country_code':$('select[name="countryCode"]').val(),
            'city':$('input[name="city"]').val(),
            'latitude':parseInt($('input[name="latitude"]').val()),
            'longitude':parseInt($('input[name="longitude"]').val()),
        });
        $.ajax({
            type:'POST',
            url:$url + '/findLocationRequest',
            data: {
                find_location: $input,
                _token: $('input[name="_token"]').val(), 
            },
            success:function(data) {
                //window.confirm(data.validateAddressJson.errors[0].code + " " +JSON.stringify(data.cookie))
                switch(data.statusCode){
                    case 200:
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
                        window.confirm(data.statusCode + " " + JSON.stringify(data))
                        console.log(JSON.stringify(data));
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