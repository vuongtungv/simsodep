$( ".value-promotion" ).change(function() {
    // alert( "Handler for .change() called." );
    var $cid_val = $('.value-promotion').val();
    $.ajax({  
        url: "index.php?module=home&view=home&task=ajax_get_promotions&raw=1",
        data: {
            cid: $cid_val
        },
        dataType: "json",
        success: function(json) {
            // var obj = JSON.parse('{"firstName":"John", "lastName":"Doe"}');
            // alert(obj.firstName);
            // var detail_per = JSON.parse(json);
            if(json.title !='null'){
                document.getElementById("name_regis").innerHTML = json.title;
                document.getElementById("price_regis").innerHTML = json.price;
                document.getElementById("detail_regis").innerHTML = json.content;
                document.getElementById("send_detail").innerHTML = json.rules_regis;
                document.getElementById("send_num").innerHTML = json.number_send;

                if(json.link != null){
                    $('.quick-re-iphone').attr('href',json.link );
                    $('.quick-re-android').attr('href',json.link);


                }else{
                    $('.quick-re-iphone').attr('href','sms:'+json.number_send+'&body='+json.rules_regis);
                    $('.quick-re-android').attr('href','sms:'+json.number_send+'?body='+json.rules_regis);

                }

            }
        }
    });
});
