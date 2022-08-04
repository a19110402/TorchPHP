
export default async function ajax(verb, url, json, csrf){
    console.log(verb, url, json, csrf);
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
                        console.log(verb, url, json, csrf);
                        resolve(data);
                        break;
                    case 400:
                        resolve(data);
                        break;
                    case 401:
                        let response = getAuth('POST', '/fedex/authKey', '',csrf);
                        response.then(function(){
                            console.log("token ready, resending");
                            resolve(ajax(verb, url, json, csrf));
                        });
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

async function getAuth(verb, url, json, csrf){
    let myPromise = new Promise(function(resolve){
        $.ajax({
            type: verb,
            url: url,
            data:{
                json: json,
                _token: csrf
            },
            success: function(data){
                switch (data.statusCode){
                    case 200:
                        resolve(data);
                        break;
                    case 503:
                        break;
                }
            },
            error: function(){
                alert("ERROR");
            }
        });
    });
    return await myPromise;
}