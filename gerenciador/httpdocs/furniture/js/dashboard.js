$.ajax({
    type: "GET",
    url: data_users_json.url
    , data: data_users_json.data
    ,success: function( data ){
        $.each( data.total , function(i,o){
            $( "#" + i + "SpanUser").html( o )
        })
    }
})
