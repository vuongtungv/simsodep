$("#number_sim").on("keyup",function(){
    $var  = $('#number_sim').val();
    $('.reload-phone').html($var);
});


// choose nhà mạng
var $show_city = 0;
$(".select-city").click(function(e) {
    $show_city++;
    $(".select-options .options").hide();
    $(".select-type .options").hide();
    $(".show-cart").hide();
    $('#search-guide').hide();
    $(".select-prices .options").hide();
    // $(".select-city .options").toggle('300');
    if($show_city %2 != 0){
        // $(".select-type .ver2").css('display','block');
        $("#options-select-city").addClass('show-op');
        $('.ver3').show(300);
    }
    else{
        // $(".select-type .ver2").hide('display','none !important');
        $("#options-select-city").addClass('show-op');
        $('.ver3').hide(300);
    }
    e.stopPropagation();
});
$( "body").mousedown(function( e ) {
    // var ele = event.target.className;
    var ele = event.target.className || event.target.id;
    // alert(ele);
    // if(ele == ''){
    //
    // }
    if(ele !='option' && ele !='mCustomScrollBox mCS-dark-3 mCSB_vertical mCSB_inside' && ele !='mCSB_dragger' && ele != 'mCSB_dragger_bar' && ele !='mCSB_draggerRail' && ele !='mCSB_draggerContainer' && ele !=''){
        $("#options-select-city").css('display','none');
    }
});
$(".ver3 .option").on("click", function () {
    $("#selected-city").attr("value", $(this).attr("value"));
    $('.value-city').addClass('success_input');
    $(".value-city").text($(this).text());
    $('.select-city').addClass('check_ok');
    $('.value-city').addClass('border_none');
    $(".select-city .options").css('display', 'none !important');
    $('#show-error-city').css("display",'none');
    $('.value-city').css('font-family','Text-Regular');
    $('#options-select-city').css('display','none');  
});


// $( "body").click(function( e ) {
//     var ele = event.target.className;
//
//     // ele !='mCSB_draggerRail' || ele !='mCSB_draggerContainer'
//     if(ele != 'mCSB_dragger_bar' && ele !='mCSB_draggerRail' && ele !='mCSB_draggerContainer'){
//         $("#options-select-city").css('display','none');
//     }
// });






$(document).ready( function(){
    $("#signed_name").on("keyup",function(){
        var value= $(this).val();
        var regex_name = /^[a-zA-Z ÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚĂĐĨŨƠàáâãèéêìíòóôõùúăđĩũơƯĂẠẢẤẦẨẪẬẮẰẲẴẶẸẺẼỀỀỂưăạảấầẩẫậắằẳẵặẹẻẽềềểỄỆỈỊỌỎỐỒỔỖỘỚỜỞỠỢỤỦỨỪễệỉịọỏốồổỗộớờởỡợụủứừỬỮỰỲỴÝỶỸửữựỳỵỷỹ\\s]+$/;
        if (regex_name.test(value)) {
            $(this).removeClass("error_input");
            $(this).addClass("success_input");
            $('#show-error-name').css("display",'none');
            $(this).parent().addClass('check_ok');
            $('#signed_name').on('blur',function () {
                $('#signed_name').addClass('border_none');
            });
        }else{
            $(this).removeClass("success_input");
            $(this).addClass("error_input");
            $('#show-error-name').html("Họ tên phải là ký tự từ a-z");
            $('#show-error-name').css("display",'block');
            $('#signed_name').on('blur',function () {
                $('#signed_name').removeClass('border_none');
            });
            $(this).parent().removeClass('check_ok');
        };
    });
    $("#signed_phone").on("keyup",function(){
        var value= $(this).val();
        var regex_phone = /^0\d{9}$/;
        if (regex_phone.test(value)) {
            $(this).removeClass("error_input");
            $(this).addClass("success_input");
            $('#show-error-phone').css("display",'none');
            $(this).parent().addClass('check_ok');
            $('#signed_phone').on('blur',function () {
                $('#signed_phone').addClass('border_none');
            });
        }else{
            $(this).removeClass("success_input");
            $(this).addClass("error_input");
            $('#show-error-phone').html("Số điện thoại gồm 10 số, bắt đầu từ số 0");
            $('#show-error-phone').css("display",'block');
            $('#signed_phone').on('blur',function () {
                $('#signed_phone').removeClass('border_none');
            });
            $(this).parent().removeClass('check_ok');
        };
    });
    $("#signed_address").on("keyup",function(){
        var value= $(this).val();
        var regex_phone = /^0\d{9}$/;
        if (value !='') {
            $(this).removeClass("error_input");
            $(this).addClass("success_input");
            $('#show-error-address').css("display",'none');
            $(this).parent().addClass('check_ok');
            $('#signed_address').on('blur',function () {
                $('#signed_address').addClass('border_none');
            });
        }else{
            $(this).removeClass("success_input");
            $(this).addClass("error_input");
            $('#show-error-address').css("display",'block');
            $('#signed_address').on('blur',function () {
                $('#signed_address').removeClass('border_none');
            });
            $(this).parent().removeClass('check_ok');

        };
    });
    $("#signed_email").on("keyup",function(){
        var value= $(this).val();
        var regex_email = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        if (value !='') {
            if(regex_email.test(value)){
                $(this).removeClass("error_input");
                $(this).addClass("success_input");
                $('#show-error-email').css("display",'none');
                $(this).parent().addClass('check_ok');
                $('#signed_email').on('blur',function () {
                    $('#signed_email').addClass('border_none');
                });
            }else{
                $(this).removeClass("success_input");
                $(this).addClass("error_input");
                $('#show-error-email').css("display",'block');
                $(this).parent().removeClass('check_ok');
                $('#signed_email').on('blur',function () {
                    $('#signed_email').removeClass('border_none');
                });
            };
        }else{
            $(this).parent().removeClass('check_ok');
        }
    });
    $("#number_sim").on('keyup',function(){
        var value= $(this).val();
        var regex = /^0\d{9}$/;
        if (value !='') {
            if(regex.test(value)){
                $(this).removeClass("error_input");
                $(this).addClass("success_input");
                $('#show-error-number-sim').css("display",'none');
                $(this).parent().addClass('check_ok');
                $('#number_sim').on('blur',function () {
                    $('#number_sim').addClass('border_none');
                });
            }else{
                $(this).removeClass("success_input");
                $(this).addClass("error_input");
                $('#show-error-number-sim').css("display",'block');
                $(this).parent().removeClass('check_ok');
                $('#number_sim').on('blur',function () {
                    $('#number_sim').removeClass('border_none');
                });
            };
        }else{
            $('#show-error-number-sim').css("display",'none');
            $(this).removeClass("error_input");
            $(this).removeClass("success_input");
            $('#number_sim').removeClass('border_none');
            $('#number_sim').parent().removeClass('check_ok');
        }
    });
    $("#price_sell").on("keyup",function(){
        var value= $(this).val();
        var regex = /^[1-9]{1}[0-9]+$/;
        if (value !='') {
            $(this).removeClass("error_input");
            $(this).addClass("success_input");
            $('#show-error-price-sell').css("display",'none');
            $(this).parent().addClass('check_ok');
            $('#price_sell').on('blur',function () {
                $('#price_sell').addClass('border_none');
            });
            // if(regex.test(value)){
            //     $(this).removeClass("error_input");
            //     $(this).addClass("success_input");
            //     $('#show-error-price-sell').css("display",'none');
            //     $(this).parent().addClass('check_ok');
            //     $('#price_sell').on('blur',function () {
            //         $('#price_sell').addClass('border_none');
            //     });
            // }else{
            //     $(this).removeClass("success_input");
            //     $(this).addClass("error_input");
            //     $('#show-error-price-sell').css("display",'block');
            //     $(this).parent().removeClass('check_ok');
            //     $('#price_sell').on('blur',function () {
            //         $('#price_sell').removeClass('border_none');
            //     });
            // };
        }else{
            $('#show-error-price-sell').css("display",'none');
            $(this).removeClass("error_input");
            $(this).removeClass("success_input");
            $('#price_sell').removeClass('border_none');
            $('#price_sell').parent().removeClass('check_ok');
        }
    });
    $("#percent_brokers").on("keyup",function(){
        var value= $(this).val();
        var regex = /^(100|[1-9]?[0-9])$/;
        if (value !='') {
            if(regex.test(value) && value>=15){
                $(this).removeClass("error_input");
                $(this).addClass("success_input");
                $('#show-error-percent-brokers').css("display",'none');
                $(this).parent().addClass('check_ok');
                $('#percent_brokers').on('blur',function () {
                    $('#percent_brokers').addClass('border_none');
                });
            }else{
                $(this).removeClass("success_input");
                $(this).addClass("error_input");
                $('#show-error-percent-brokers').css("display",'block');
                $(this).parent().removeClass('check_ok');
                $('#percent_brokers').on('blur',function () {
                    $('#percent_brokers').removeClass('border_none');
                });
            };
        }else{
            $('#show-error-percent-brokers').css("display",'none');
            $(this).removeClass("error_input");
            $(this).removeClass("success_input");
            $('#percent_brokers').removeClass('border_none');
            $('#percent_brokers').parent().removeClass('check_ok');
        }
    });

    /* FORM CONTACT */
    $('#submitbt').click(function(){
        if(checkFormsubmit()){
            // document.form_register.submit();
        }
    });
});
function checkFormsubmit()
{

    var signed_name = document.forms['form-default']['signed_name'].value;
    var signed_phone = document.forms['form-default']['signed_phone'].value;
    var signed_address = document.forms['form-default']['signed_address'].value;
    var signed_email = document.forms['form-default']['signed_email'].value;
    var signed_number_sim = document.forms['form-default']['number_sim'].value;
    var signed_price_sell = document.forms['form-default']['price_sell'].value;
    var signed_percent_brokers = document.forms['form-default']['percent_brokers'].value;

    var filterEmail = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

    if(signed_name == ''){
        $('#signed_name').addClass("error_input");
        $('#show-error-name').css("display",'block');
        // var id_block = document.getElementById("signed_name");
        // id_block.scrollIntoView({
        //     behavior: 'auto',
        //     block: 'center',
        //     inline: 'center',
        // });
        $('#signed_name').focus();
        return false;
    }
    else{
        if(/^[a-zA-Z ÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚĂĐĨŨƠàáâãèéêìíòóôõùúăđĩũơƯĂẠẢẤẦẨẪẬẮẰẲẴẶẸẺẼỀỀỂưăạảấầẩẫậắằẳẵặẹẻẽềềểỄỆỈỊỌỎỐỒỔỖỘỚỜỞỠỢỤỦỨỪễệỉịọỏốồổỗộớờởỡợụủứừỬỮỰỲỴÝỶỸửữựỳỵỷỹ\\s]+$/.test(signed_name)==false){
            // var id_block = document.getElementById("signed_name");
            // id_block.scrollIntoView({
            //     behavior: 'smooth',
            //     block: 'center',
            //     inline: 'center',
            // });
            $('#signed_name').focus();
            return false;
        }
    }
    if(signed_phone == ''){
        $('#signed_phone').addClass("error_input");
        $('#show-error-phone').css("display",'block');
        // var id_block = document.getElementById("signed_phone");
        // id_block.scrollIntoView({
        //     behavior: 'auto',
        //     block: 'center',
        //     inline: 'center',
        // });
        $('#signed_phone').focus();
        return false;
    }
    else{
        if(/^0\d{9}$/.test(signed_phone)==false){
            // var id_block = document.getElementById("signed_phone");
            // id_block.scrollIntoView({
            //     behavior: 'smooth',
            //     block: 'center',
            //     inline: 'center',
            // });
            $('#signed_phone').focus();
            return false;
        }
    }


    if(signed_address == ''){
        $('#signed_address').addClass("error_input");
        $('#show-error-address').css("display",'block');
        // var id_block = document.getElementById("signed_address");
        // id_block.scrollIntoView({
        //     behavior: 'auto',
        //     block: 'center',
        //     inline: 'center',
        // });
        $('#signed_address').focus();
        return false;
    }

    if($('#selected-city').val()==''){
        $('#show-error-city').css("display",'block');
        return false;
    }
    $('#show-error-city').css("display",'none');


    if(signed_email != ''){
        if(filterEmail.test(signed_email)==false){
            // var id_block = document.getElementById("signed_email");
            // id_block.scrollIntoView({
            //     behavior: 'smooth',
            //     block: 'center',
            //     inline: 'center',
            // });
            $('#signed_email').focus();
            return false;
        }
    }


    if(signed_number_sim == ''){
        $('#show-error-number-sim').html("Vui lòng nhập sim ký gửi");
        $('#show-error-number-sim').css('display', 'block');
        $('#number_sim').focus();
        return false;
    }
    if(signed_number_sim != ''){
        if(/^0\d{9}$/.test(signed_number_sim)==false){
            // var id_block = document.getElementById("number_sim");
            // id_block.scrollIntoView({
            //     behavior: 'smooth',
            //     block: 'center',
            //     inline: 'center',
            // });
            $('#number_sim').focus();
            return false;
        }
    }

    if(signed_price_sell==''){
        $('#show-error-price-sell').html("Vui lòng nhập giá tiền");
        $('#show-error-price-sell').css('display', 'block');
        $('#price_sell').focus();
        return false;
    }


    // if(signed_price_sell != '') {
    //     if (/^[1-9]{1}$/.test(signed_price_sell) == false) {
    //         // var id_block = document.getElementById("price_sell");
    //         // id_block.scrollIntoView({
    //         //     behavior: 'smooth',
    //         //     block: 'center',
    //         //     inline: 'center',
    //         // });
    //         $('#price_sell').focus();
    //         return false;
    //     }
    // }


    if(signed_percent_brokers==''){
        $('#show-error-percent-brokers').html("Vui lòng nhập % ký gửi");
        $('#show-error-percent-brokers').css('display', 'block');
        $('#percent_brokers').focus();
        return false;
    }
    if(signed_percent_brokers != '') {
        if (/^(100|[1-9]?[0-9])$/.test(signed_percent_brokers) == false && signed_percent_brokers>=15) {
            // var id_block = document.getElementById("percent_brokers");
            // id_block.scrollIntoView({
            //     behavior: 'smooth',
            //     block: 'center',
            //     inline: 'center',
            // });
            $('#percent_brokers').focus();
            return false;
        }
    }
    document.forms['form-default'].submit();
}

function isNumber(event) {
    var keycode = event.keyCode;
    if(keycode >=48 && keycode<=57){
        return true;
    }
    return false;
}