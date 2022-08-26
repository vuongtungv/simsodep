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
        $(".ver3").css('display','none');
    }
});
$(".ver3 .option").on("click", function () {
    $("#selected-city").attr("value", $(this).attr("value"));
    $('.value-city').addClass('success_input');
    $(".value-city").text($(this).attr("data-name"));
    $('.select-city').addClass('check_ok');
    $('.value-city').addClass('border_none');
    $(".select-city .options").css('display', 'none !important');
    $('#show-error-city').css("display",'none');
    $('.value-city').css('font-family','Text-Regular');
    $('#options-select-city').css('display','none');
    $('.infor-customer .deprecate_city').html($(this).attr("data-name"));
});





$(document).ready( function(){
    $("#deprecate_name").on("keyup",function(){
        var value= $(this).val();
        var regex_name = /^[a-zA-Z ÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚĂĐĨŨƠàáâãèéêìíòóôõùúăđĩũơƯĂẠẢẤẦẨẪẬẮẰẲẴẶẸẺẼỀỀỂưăạảấầẩẫậắằẳẵặẹẻẽềềểỄỆỈỊỌỎỐỒỔỖỘỚỜỞỠỢỤỦỨỪễệỉịọỏốồổỗộớờởỡợụủứừỬỮỰỲỴÝỶỸửữựỳỵỷỹ\\s]+$/;
        if (regex_name.test(value)) {
            $(this).removeClass("error_input");
            $(this).addClass("success_input");
            $('#show-error-name').css("display",'none');
            $(this).parent().addClass('check_ok');
            $('#deprecate_name').on('blur',function () {
                $('#deprecate_name').addClass('border_none');
            });
        }else{
            $(this).removeClass("success_input");
            $(this).addClass("error_input");
            $('#show-error-name').html("Họ tên phải là ký tự từ a-z");
            $('#show-error-name').css("display",'block');
            $('#deprecate_name').on('blur',function () {
                $('#deprecate_name').removeClass('border_none');
            });
            $(this).parent().removeClass('check_ok');
        };
    });
    $("#deprecate_phone").on("keyup",function(){
        var value= $(this).val();
        var regex_phone = /^0\d{9}$/;
        if (regex_phone.test(value)) {
            $(this).removeClass("error_input");
            $(this).addClass("success_input");
            $('#show-error-phone').css("display",'none');
            $(this).parent().addClass('check_ok');
            $('#deprecate_phone').on('blur',function () {
                $('#deprecate_phone').addClass('border_none');
            });
        }else{
            $(this).removeClass("success_input");
            $(this).addClass("error_input");
            $('#show-error-phone').html("Số điện thoại gồm 10 số, bắt đầu từ số 0");
            $('#show-error-phone').css("display",'block');
            $(this).parent().removeClass('check_ok');
            $('#deprecate_phone').on('blur',function () {
                $('#deprecate_phone').removeClass('border_none');
            });
        };
    });
    $("#deprecate_address").on("keyup",function(){
        var value= $(this).val();
        var regex_phone = /^0\d{9}$/;
        if (value !='') {
            $(this).removeClass("error_input");
            $(this).addClass("success_input");
            $('#show-error-address').css("display",'none');
            $(this).parent().addClass('check_ok');
            $('#deprecate_address').on('blur',function () {
                $('#deprecate_address').addClass('border_none');
            });
        }else{
            $(this).removeClass("success_input");
            $(this).addClass("error_input");
            $('#show-error-address').css("display",'block');
            $(this).parent().removeClass('check_ok');
            $('#deprecate_address').on('blur',function () {
                $('#deprecate_address').removeClass('border_none');
            });
        };
    });
    $("#deprecate_email").on("keyup",function(){
        var value= $(this).val();
        var regex_email = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        if (value !='') {
            if(regex_email.test(value)){
                $(this).removeClass("error_input");
                $(this).addClass("success_input");
                $('#show-error-email').css("display",'none');
                $(this).parent().addClass('check_ok');
                $('#deprecate_email').on('blur',function () {
                    $('#deprecate_email').addClass('border_none');
                });
            }else{
                $(this).removeClass("success_input");
                $(this).addClass("error_input");
                $('#show-error-email').css("display",'block');
                $(this).parent().removeClass('check_ok');
                $('#deprecate_email').on('blur',function () {
                    $('#deprecate_email').removeClass('border_none');
                });
            };
        }else{
            $(this).parent().removeClass('check_ok');
        }
    });
    // if($('#selected-city').val()==''){
    //     $('#show-error-city').css("display",'block');
    //     return false;
    // }
    // $('#show-error-city').css("display",'none');


    $("#deprecate_six").on("keyup",function(){
        var value= $(this).val();
        var regex_email = /^\d{0,6}$/;
        if (value !='') {
            if(regex_email.test(value)){
                $(this).removeClass("error_input");
                $(this).addClass("success_input");
                $('#show-error-six').css("display",'none');
                $(this).parent().addClass('check_ok');
                $('#deprecate_six').on('blur',function () {
                    $('#deprecate_six').addClass('border_none');
                });
            }else{
                $(this).removeClass("success_input");
                $(this).addClass("error_input");
                $('#show-error-six').css("display",'block');
                $(this).parent().removeClass('check_ok');
                $('#deprecate_six').on('blur',function () {
                    $('#deprecate_six').removeClass('border_none');
                });
            };
        }else{
            $('#show-error-six').css("display",'none');
            $(this).removeClass("error_input");
            $(this).removeClass("success_input");
            $('#deprecate_six').removeClass('border_none');
            $('#deprecate_six').parent().removeClass('check_ok');
        }
    });
    $("#deprecate_price").on("keyup",function(){
        var value= $(this).val();
        var regex_price = /^[1-9]{1}[0-9]+$/;
        if (value !='') {
            $(this).removeClass("error_input");
            $(this).addClass("success_input");
            $('#show-error-price').css("display",'none');
            $(this).parent().addClass('check_ok');
            $('#deprecate_price').on('blur',function () {
                $('#deprecate_price').addClass('border_none');
            });
            // if(regex_price.test(value)){
            //     $(this).removeClass("error_input");
            //     $(this).addClass("success_input");
            //     $('#show-error-price').css("display",'none');
            //     $(this).parent().addClass('check_ok');
            //     $('#deprecate_price').on('blur',function () {
            //         $('#deprecate_price').addClass('border_none');
            //     });
            //
            // }else{
            //     $(this).removeClass("success_input");
            //     $(this).addClass("error_input");
            //     $('#show-error-price').css("display",'block');
            //     $(this).parent().removeClass('check_ok');
            //     $('#deprecate_price').on('blur',function () {
            //         $('#deprecate_price').removeClass('border_none');
            //     });
            // };
        }else{
            $('#show-error-price').css("display",'none');
            $(this).removeClass("error_input");
            $(this).removeClass("success_input");
            $('#deprecate_price').removeClass('border_none');
            $('#deprecate_price').parent().removeClass('check_ok');
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

    var deprecate_name = document.forms['form-default']['deprecate_name'].value;
    var deprecate_phone = document.forms['form-default']['deprecate_phone'].value;
    var deprecate_address = document.forms['form-default']['deprecate_address'].value;
    var deprecate_email = document.forms['form-default']['deprecate_email'].value;
    // var deprecate_comment = document.forms['form-default']['deprecate_comment'].value;
    var deprecate_six = document.forms['form-default']['deprecate_six'].value;
    var deprecate_price = document.forms['form-default']['deprecate_price'].value;

    var filterEmail = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

    if(deprecate_name == ''){
        $('#deprecate_name').addClass("error_input");
        $('#show-error-name').css("display",'block');
        $('#deprecate_name').focus();
        return false;
    }
    else{
        if(/^[a-zA-Z ÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚĂĐĨŨƠàáâãèéêìíòóôõùúăđĩũơƯĂẠẢẤẦẨẪẬẮẰẲẴẶẸẺẼỀỀỂưăạảấầẩẫậắằẳẵặẹẻẽềềểỄỆỈỊỌỎỐỒỔỖỘỚỜỞỠỢỤỦỨỪễệỉịọỏốồổỗộớờởỡợụủứừỬỮỰỲỴÝỶỸửữựỳỵỷỹ\\s]+$/.test(deprecate_name)==false){
            $('#deprecate_name').focus();
            return false;
        }
    }
    if(deprecate_phone == ''){
        $('#deprecate_phone').addClass("error_input");
        $('#show-error-phone').css("display",'block');
        $('#deprecate_phone').focus();
        return false;
    }
    else{
        if(/^0\d{9}$/.test(deprecate_phone)==false){
            $('#deprecate_phone').focus();
            return false;
        }
    }

    if(deprecate_address == ''){
        $('#deprecate_address').addClass("error_input");
        $('#show-error-address').css("display",'block');
        $('#deprecate_address').focus();
        return false;
    }
    if($('#selected-city').val()==''){
        $('#show-error-city').css("display",'block');
        $('#selected-city').focus();
        return false;
    }

    if(deprecate_email != ''){
        if(filterEmail.test(deprecate_email)==false){
            $('#deprecate_email').focus();
            return false;
        }
    }


    if(deprecate_six==''){
        $('#show-error-six').css("display",'block');
        $('#deprecate_six').focus();
        return false;
    }
    if(deprecate_six != ''){
        if(/^\d{0,6}$/.test(deprecate_six)==false){
            $('#deprecate_six').focus();
            return false;
        }
    }

    if(deprecate_price==''){
        $('#show-error-price').html("Vui lòng nhập giá tiền");
        $('#show-error-price').css('display', 'block');
        $('#deprecate_price').focus();
        return false;
    }
    // if(deprecate_price != '') {
    //     if (/^[1-9]{1}[0-9]+$/.test(deprecate_price) == false) {
    //         $('#deprecate_price').focus();
    //         return false;
    //     }
    // }
    document.forms['form-default'].submit();
}


function isNumber(event) {
    var keycode = event.keyCode;
    if(keycode >=48 && keycode<=57){
        return true;
    }
    return false;
}