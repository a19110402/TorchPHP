$(document).ready(function(){
    $('#get-key-auth-fedex-form').on('submit', function(event){
        $url = $(this).attr('data-action');
        input = JSON.stringify({
            'child_Key':$('input[name="client_id"]').val(),
            'child_secret':$('input[name="child_secret"]').val(),
        });
        $.ajax({
            type:'POST',
            url:$url + '/authKey',
            data: {
                credential_client: input,
                _token: $('input[name="_token"]').val(), 
            },
            success:function(data) {
                switch(data.statusCode){
                    case 200:
                        if (window.confirm(JSON.stringify(data) )){
                            //window.location = $url;
                            console.log(JSON.stringify(data));
                        }
                    break;
                    case 400:
                    case 401:
                    case 403:
                    case 404:
                    case 500:
                    case 503:
                        window.confirm(data.statusCode + " " + data.validateAddressJson.errors[0].message)
                        console.log(JSON.stringify(data));
                    break;
                    default:
                        window.confirm(data.validateAddressJson.errors[0].code + " " +JSON.stringify(data.cookie))
                }
                //if (window.confirm("accepted credentials " + JSON.stringify(data))){
                //if (window.confirm("accepted credentials ")){
                //    window.location = $url;
                //}
            },
            error:function(x,xs,xt){
                alert("Error");
            }
        });
    });
});
