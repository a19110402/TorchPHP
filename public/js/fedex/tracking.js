import ajax from '../ajax.js';

$("#requestTracking").on('click', function(){
    let companyName     = $("#company").val();
    let trackingNumer   = $("#tracking").val();
    let _token          = $("input[name='_token']").val();
    let input = JSON.stringify({
        'trackingNumber': trackingNumer,
        'companyName': companyName
    });
    
    let data = ajax('POST', 'http://127.0.0.1:8000/tracking', input, _token);

    data.then(function(response){
        console.log(response);
    });
    
});