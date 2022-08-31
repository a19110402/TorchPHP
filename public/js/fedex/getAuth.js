
$(function(){
    $.ajax({
        type: 'POST',
        url: "http://127.0.0.1:8000/fedex/authKey",
        data:{
            credential_client: '',
            _token: $('input[name="_token"]').val(), 
        },
        success:function(){
        alert("success");
        },
        error:function(){
            alert("error");
        }
        });
})
