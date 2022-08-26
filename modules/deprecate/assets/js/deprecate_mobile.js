$(document).ready( function(){
    $("#deprecate_name").on("keyup",function(){
        var value= $(this).val();
        var regex_name = /^[a-zA-Z ÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚĂĐĨŨƠàáâãèéêìíòóôõùúăđĩũơƯĂẠẢẤẦẨẪẬẮẰẲẴẶẸẺẼỀỀỂưăạảấầẩẫậắằẳẵặẹẻẽềềểỄỆỈỊỌỎỐỒỔỖỘỚỜỞỠỢỤỦỨỪễệỉịọỏốồổỗộớờởỡợụủứừỬỮỰỲỴÝỶỸửữựỳỵỷỹ\\s]+$/;
        if (regex_name.test(value)) {
            $(this).parent().children('.icon_error').css('display','none');
            $(this).parent().children('.icon_success').css('display','block');
            $('#snackbar-signedsim').css('visibility', 'hidden');
        }else{
            $('#snackbar-signedsim').css('visibility', 'visible');
            $('#snackbar-signedsim p').html('Họ tên phải là ký tự từ a-z !');
            $(this).parent().children('.icon_success').css('display','none');
            $(this).parent().children('.icon_error').css('display','block');
        }
    });
    $("#deprecate_phone").on("keyup",function(){
        var value= $(this).val();
        var regex_phone = /^0\d{9}$/;
        if (regex_phone.test(value)) {
            $(this).parent().children('.icon_error').css('display','none');
            $(this).parent().children('.icon_success').css('display','block');
            $('#snackbar-signedsim').css('visibility', 'hidden');
        }else{
            $(this).parent().children('.icon_success').css('display','none');
            $(this).parent().children('.icon_error').css('display','block');
        }
    });
    $("#deprecate_address").on("keyup",function(){
        var value= $(this).val();
        var regex_phone = /^0\d{9}$/;
        if (value !='') {
            $(this).parent().children('.icon_error').css('display','none');
            $(this).parent().children('.icon_success').css('display','block');
            $('#snackbar-signedsim').css('visibility', 'hidden');
        }else{
            $(this).parent().children('.icon_success').css('display','none');
            $(this).parent().children('.icon_error').css('display','block');
        }
    });

    $('#select-city').change(function () {
        $id_city = $(this).val();
        if($id_city !=''){
            $(this).parent().children('.icon_error').css('display','none');
            $(this).parent().children('.icon_success').css('display','block');
            $('#snackbar-signedsim').css('visibility', 'hidden');
        }else{
            $(this).parent().children('.icon_success').css('display','none');
            $(this).parent().children('.icon_error').css('display','block');
        }
    });


    $("#deprecate_email").on("keyup",function(){
        var value= $(this).val();
        var regex_email = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        if (value !='') {
            if(regex_email.test(value)){
                $(this).parent().children('.icon_error').css('display','none');
                $(this).parent().children('.icon_success').css('display','block');
                $('#snackbar-signedsim').css('visibility', 'hidden');
            }else{
                $(this).parent().children('.icon_success').css('display','none');
                $(this).parent().children('.icon_error').css('display','block');
            }
        }else{
            $(this).parent().children('.icon_success').css('display','none');
            $(this).parent().children('.icon_error').css('display','none');
        }
    });
    $("#deprecate_six").on("keyup",function(){
        var value= $(this).val();
        var regex_email = /^\d{0,6}$/;
        if(regex_email.test(value)){
            $(this).parent().children('.icon_error').css('display','none');
            $(this).parent().children('.icon_success').css('display','block');
            $('#snackbar-signedsim').css('visibility', 'hidden');
        }else{
            $(this).parent().children('.icon_success').css('display','none');
            $(this).parent().children('.icon_error').css('display','block');
        };
    });
    $("#deprecate_price").on("keyup",function(){
        var value= $(this).val();
        // var regex_price = /^[1-9]{1}[0-9]+$/;
        if(value !=""){
            $(this).parent().children('.icon_error').css('display','none');
            $(this).parent().children('.icon_success').css('display','block');
            $('#snackbar-signedsim p').html('Vui lòng nhập giá tiền!');
            $('#snackbar-signedsim').css('visibility', 'hidden');
        }else{
            $(this).parent().children('.icon_success').css('display','none');
            $(this).parent().children('.icon_error').css('display','block');
        };


            // skip for arrow keys
        // if(event.which >= 37 && event.which <= 40) return;

        // format number
        $(this).val(function(index, value) {
            return value
                .replace(/\D/g, "")
                .replace(/\B(?=(\d{3})+(?!\d))/g, ",")
                ;
        });


    });


    /* FORM CONTACT */
    $('#submitbt').click(function(){
        if(checkFormsubmit()){
            // document.form_register.submit();
        }
    });
});



function show_money(price){
    var number = price.toString();
    var format_money = "";
    while (parseInt(number) > 999) {
        format_money = "." + number.slice(-3) + format_money;
        number = number.slice(0, -3);
    }
    return result = number + format_money;
}


function checkFormsubmit()
{

    var deprecate_name = document.forms['form-default']['deprecate_name'].value;
    var deprecate_phone = document.forms['form-default']['deprecate_phone'].value;
    var deprecate_address = document.forms['form-default']['deprecate_address'].value;
    var signed_city = document.forms['form-default']['select-city'].value;
    var deprecate_email = document.forms['form-default']['deprecate_email'].value;
    // var deprecate_comment = document.forms['form-default']['deprecate_comment'].value;
    var deprecate_six = document.forms['form-default']['deprecate_six'].value;
    var deprecate_price = document.forms['form-default']['deprecate_price'].value;

    var filterEmail = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;



    if(deprecate_name == ''){
        $('#snackbar-signedsim').css('visibility', 'visible');
        $('#snackbar-signedsim p').html('Họ tên phải là ký tự từ a-z !');

        $('#deprecate_name').parent().children('.icon_error').css('display','block');
        $('#deprecate_name').addClass('focus-input');
        $('#deprecate_name').focus();
        return false;
    }
    else{
        var regex_name = /^[a-zA-Z ÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚĂĐĨŨƠàáâãèéêìíòóôõùúăđĩũơƯĂẠẢẤẦẨẪẬẮẰẲẴẶẸẺẼỀỀỂưăạảấầẩẫậắằẳẵặẹẻẽềềểỄỆỈỊỌỎỐỒỔỖỘỚỜỞỠỢỤỦỨỪễệỉịọỏốồổỗộớờởỡợụủứừỬỮỰỲỴÝỶỸửữựỳỵỷỹ\\s]+$/;
        if(regex_name.test(deprecate_name)==false){

            $('#snackbar-signedsim').css('visibility', 'visible');
            $('#snackbar-signedsim p').html('Họ tên phải là ký tự từ a-z !');

            $('#deprecate_name').parent().children('.icon_error').css('display','block');
            $('#deprecate_name').addClass('focus-input');
            $('#deprecate_name').focus();
            return false;
        }
    }
    $('#snackbar-signedsim').css('visibility', 'hidden');
    $('#deprecate_name').removeClass('focus-input');



    if(deprecate_phone == ''){
        $('#snackbar-signedsim').css('visibility', 'visible');
        $('#snackbar-signedsim p').html('Số điện thoại gồm 10 số, bắt đầu từ số 0 !');

        $('#deprecate_phone').parent().children('.icon_error').css('display','block');
        $('#deprecate_phone').addClass('focus-input');
        $('#deprecate_phone').focus();
        return false;
    }
    else{
        if(/^0\d{9}$/.test(deprecate_phone)==false){
            $('#snackbar-signedsim').css('visibility', 'visible');
            $('#snackbar-signedsim p').html('Số điện thoại gồm 10 số, bắt đầu từ số 0 !');

            $('#deprecate_phone').parent().children('.icon_error').css('display','block');
            $('#deprecate_phone').addClass('focus-input');
            $('#deprecate_phone').focus();
            return false;
        }
    }
    $('#snackbar-signedsim').css('visibility', 'hidden');
    $('#deprecate_phone').removeClass('focus-input');

    if(deprecate_address == ''){
        $('#snackbar-signedsim').css('visibility', 'visible');
        $('#snackbar-signedsim p').html('Quý khách chưa nhập địa chỉ !');

        $('#deprecate_address').parent().children('.icon_error').css('display','block');
        $('#deprecate_address').addClass('focus-input');
        $('#deprecate_address').focus();
        return false;
    }
    $('#snackbar-signedsim').css('visibility', 'hidden');
    $('#deprecate_address').removeClass('focus-input');

    if(signed_city ==''){
        $('#snackbar-signedsim').css('visibility', 'visible');
        $('#snackbar-signedsim p').html('Quý khách chưa chọn Tỉnh/TP !');

        $(this).parent().children('.icon_error').css('display','block');
        $(this).parent().children('.icon_success').css('display','none');
        $('#select-city').focus();
        return false;
    }
    $('#snackbar-signedsim').css('visibility', 'hidden');
    $(this).parent().children('.icon_success').css('display','none');
    $(this).parent().children('.icon_error').css('display','block');


    if(deprecate_email != ''){
        if(filterEmail.test(deprecate_email)==false){
            $('#snackbar-signedsim').css('visibility', 'visible');
            $('#snackbar-signedsim p').html('Quý khách nhập sai định dạng email !');

            $('#deprecate_email').parent().children('.icon_error').css('display','block');
            $('#deprecate_email').addClass('focus-input');
            $('#deprecate_email').focus();
            return false;
        }
    }
    $('#snackbar-signedsim').css('visibility', 'hidden');
    $('#deprecate_email').removeClass('focus-input');

    if(deprecate_six != ''){
        if(/^\d{0,6}$/.test(deprecate_six)==false){

            $('#snackbar-signedsim').css('visibility', 'visible');
            $('#snackbar-signedsim p').html('Quý khách nhập tối đa 6 số !');

            $('#deprecate_six').parent().children('.icon_error').css('display','block');
            $('#deprecate_six').addClass('focus-input');
            $('#deprecate_six').focus();
            return false;
        }
    }else{
        $('#deprecate_six').parent().children('.icon_error').css('display','block');
        $('#deprecate_six').addClass('focus-input');
        $('#deprecate_six').focus();
        return false;
    }
    $('#snackbar-signedsim').css('visibility', 'hidden');
    $('#deprecate_six').removeClass('focus-input');



    if(deprecate_price != '') {
        // if (/^[1-9]{1}[0-9]+$/.test(deprecate_price) == false) {
        //     $('#deprecate_price').parent().children('.icon_error').css('display','block');
        //     $('#deprecate_price').addClass('focus-input');
        //     $('#deprecate_price').focus();
        //     return false;
        // }
    }else{
        $('#snackbar-signedsim').css('visibility', 'visible');
        $('#snackbar-signedsim p').html('Quý khách nhập giá tiền !');

        $('#deprecate_price').parent().children('.icon_error').css('display','block');
        $('#deprecate_price').addClass('focus-input');
        $('#deprecate_price').focus();
        return false;
    }
    $('#snackbar-signedsim').css('visibility', 'hidden');
    $('#deprecate_price').removeClass('focus-input');


    document.forms['form-default'].submit();
}


function isNumber(event) {
    var keycode = event.keyCode;
    if(keycode >=48 && keycode<=57){
        return true;
    }
    return false;
}