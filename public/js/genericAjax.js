
export default async function genericAjax(verb, url, json, csrf){
    let myPromise = new Promise(function(resolve){
        $.ajax({
            type: verb,
            url: url,
            data:{
                json: json,
                _token: csrf
            },
            success: function(data){
                console.log(data.fedexResponse.statusCode);
                switch (data.fedexResponse.statusCode){
                    case 200:
                        resolve(data);
                        break;
                    case 400:
                        resolve(data);
                        break;
                    case 401:
                        resolve(data);
                    break;
                    default:
                        resolve(data)
                }
            },
            error: function(){
                alert("ERROR");
            }
        });
    });
    
    return await myPromise;
}