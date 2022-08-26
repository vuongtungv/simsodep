$(document).ready( function(){
    $( "#signed_name" ).focusin(function() {
        $('.box-hover').css('display','none');
    });
    $("#signed_name").on("keyup",function(){
        $('.box-hover').css('display','none');
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
        };
    });

    $( "#signed_phone" ).focusin(function() {
        $('.box-hover').css('display','none');
    });
    $("#signed_phone").on("keyup",function(){
        $('.box-hover').css('display','none');
        var value= $(this).val();
        var regex_phone = /^0\d{9}$/;
        if (regex_phone.test(value)) {
            $(this).parent().children('.icon_error').css('display','none');
            $(this).parent().children('.icon_success').css('display','block');
            $('#snackbar-signedsim').css('visibility', 'hidden');
        }else{
            $(this).parent().children('.icon_success').css('display','none');
            $(this).parent().children('.icon_error').css('display','block');
        };
    });

    $( "#signed_address" ).focusin(function() {
        $('.box-hover').css('display','none');
    });
    $("#signed_address").on("keyup",function(){
        $('.box-hover').css('display','none');
        var value= $(this).val();
        var regex_phone = /^0\d{9}$/;
        if (value !='') {
            $(this).parent().children('.icon_error').css('display','none');
            $(this).parent().children('.icon_success').css('display','block');
            $('#snackbar-signedsim').css('visibility', 'hidden');
        }else{
            $(this).parent().children('.icon_success').css('display','none');
            $(this).parent().children('.icon_error').css('display','block');
        };
    });


    $('#select-city').change(function () {
        $('.box-hover').css('display','none');
        $id_city = $(this).val();
        if($id_city !=''){
            $(this).parent().children('.icon_error').css('display','none');
            $(this).parent().children('.icon_success').css('display','block');
        }else{
            $('#snackbar-signedsim').css('visibility', 'hidden');
            $(this).parent().children('.icon_success').css('display','none');
            $(this).parent().children('.icon_error').css('display','block');
        }
    });


    $( "#signed_email" ).focusin(function() {
        $('.box-hover').css('display','none');
    });
    $("#signed_email").on("keyup",function(){
        $('.box-hover').css('display','none');
        var value= $(this).val();
        var regex_email = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        if (value !='') {
            if(regex_email.test(value)){
                $(this).parent().children('.icon_error').css('display','none');
                $(this).parent().children('.icon_success').css('display','block');
            }else{
                $('#snackbar-signedsim').css('visibility', 'hidden');
                $(this).parent().children('.icon_success').css('display','none');
                $(this).parent().children('.icon_error').css('display','block');
            };
        }else{
            $(this).parent().children('.icon_success').css('display','none');
            $(this).parent().children('.icon_error').css('display','none');
        }
    });
    $( "#number_sim" ).focusin(function() {
        $('.box-hover').css('display','block');
    });
    $("#number_sim").on("keyup",function(){
        $var  = $('#number_sim').val();
        $('.reload-phone').html($var);
        var value= $(this).val();
        var regex = /^0\d{9}$/;
        if(regex.test(value)){
            $('#snackbar-signedsim').css('visibility', 'hidden');
            $(this).parent().children('.icon_error').css('display','none');
            $(this).parent().children('.icon_success').css('display','block');
        }else{
            // $('#snackbar-signedsim').css('visibility', 'visible');
            // $('#snackbar-signedsim p').html('Số điện thoại gồm 10 số, bắt đầu từ số 0 !');
            $(this).parent().children('.icon_success').css('display','none');
            $(this).parent().children('.icon_error').css('display','block');
        };
    });


    $( "#price_sell" ).focusin(function() {
        $('.box-hover').css('display','none');
    });
    $("#price_sell").on("keyup",function(){

        var value= $(this).val();
        // var regex = /^[1-9]{1}[0-9]+$/;
        if(value !=""){
            $(this).parent().children('.icon_error').css('display','none');
            $(this).parent().children('.icon_success').css('display','block');
        }else{
            $('#snackbar-signedsim').css('visibility', 'hidden');
            $(this).parent().children('.icon_success').css('display','none');
            $(this).parent().children('.icon_error').css('display','block');
        };

        // format number
        $(this).val(function(index, value) {
            return value
                .replace(/\D/g, "")
                .replace(/\B(?=(\d{3})+(?!\d))/g, ",")
                ;
        });

    });

    $( "#percent_brokers" ).focusin(function() {
        $('.box-hover').css('display','none');
    });
    $("#percent_brokers").on("keyup",function(){
        $('.box-hover').css('display','none');
        var value= $(this).val();
        var regex = /^(100|[1-9]?[0-9])$/;
        if(regex.test(value) && value>=15){
            $(this).parent().children('.icon_error').css('display','none');
            $(this).parent().children('.icon_success').css('display','block');
        }else{
            $('#snackbar-signedsim').css('visibility', 'hidden');
            $(this).parent().children('.icon_success').css('display','none');
            $(this).parent().children('.icon_error').css('display','block');
        };
    });
    $( "#signed_comment" ).focusin(function() {
        $('.box-hover').css('display','none');
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
    var signed_city = document.forms['form-default']['select-city'].value;
    var signed_email = document.forms['form-default']['signed_email'].value;
    var signed_number_sim = document.forms['form-default']['number_sim'].value;
    var signed_price_sell = document.forms['form-default']['price_sell'].value;
    var signed_percent_brokers = document.forms['form-default']['percent_brokers'].value;

    var filterEmail = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

    if(signed_name == ''){
        $('#snackbar-signedsim').css('visibility', 'visible');
        $('#snackbar-signedsim p').html('Họ tên phải là ký tự từ a-z !');

        $('#signed_name').parent().children('.icon_error').css('display','block');
        $('#signed_name').addClass('focus-input');
        $('#signed_name').focus();
        return false;
    }
    else{
        var regex_name = /^[a-zA-Z ÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚĂĐĨŨƠàáâãèéêìíòóôõùúăđĩũơƯĂẠẢẤẦẨẪẬẮẰẲẴẶẸẺẼỀỀỂưăạảấầẩẫậắằẳẵặẹẻẽềềểỄỆỈỊỌỎỐỒỔỖỘỚỜỞỠỢỤỦỨỪễệỉịọỏốồổỗộớờởỡợụủứừỬỮỰỲỴÝỶỸửữựỳỵỷỹ\\s]+$/;
        if(regex_name.test(signed_name)==false){
            $('#snackbar-signedsim').css('visibility', 'visible');
            $('#snackbar-signedsim p').html('Họ tên phải là ký tự từ a-z !');

            $('#signed_name').parent().children('.icon_error').css('display','block');
            $('#signed_name').addClass('focus-input');
            $('#signed_name').focus();
            return false;
        }
    }
    $('#snackbar-signedsim').css('visibility', 'hidden');
    $('#signed_name').removeClass('focus-input');


    if(signed_phone == ''){
        $('#snackbar-signedsim').css('visibility', 'visible');
        $('#snackbar-signedsim p').html('Số điện thoại gồm 10 số, bắt đầu từ số 0 !');
        $('#signed_phone').addClass("focus-input");
        $('#signed_phone').parent().children('.icon_error').css('display','block');
        $('#signed_phone').focus();
        return false;
    }
    else{
        if(/^0\d{9}$/.test(signed_phone)==false){
            $('#snackbar-signedsim').css('visibility', 'visible');
            $('#snackbar-signedsim p').html('Số điện thoại gồm 10 số, bắt đầu từ số 0 !');

            $('#signed_phone').parent().children('.icon_error').css('display','block');
            $('#signed_phone').addClass('focus-input');
            $('#signed_phone').focus();
            return false;
        }
    }
    $('#snackbar-signedsim').css('visibility', 'hidden');
    $('#signed_phone').removeClass('focus-input');



    if(signed_address == ''){
        $('#snackbar-signedsim').css('visibility', 'visible');
        $('#snackbar-signedsim p').html('Quý khách chưa nhập địa chỉ !');
        $('#signed_address').parent().children('.icon_error').css('display','block');
        $('#signed_address').addClass('focus-input');
        $('#signed_address').focus();
        return false;
    }
    $('#snackbar-signedsim').css('visibility', 'hidden');
    $('#signed_address').removeClass('focus-input');


    if(signed_city ==''){
        $('#snackbar-signedsim').css('visibility', 'visible');
        $('#snackbar-signedsim p').html('Quý khách chưa chọn Tỉnh/TP !');

        $(this).parent().children('.icon_error').css('display','none');
        $(this).parent().children('.icon_success').css('display','block');
        $('#select-city').focus();
        return false;
    }
    $('#snackbar-signedsim').css('visibility', 'hidden');
    $(this).parent().children('.icon_success').css('display','none');
    $(this).parent().children('.icon_error').css('display','block');

    if(signed_email != ''){
        if(filterEmail.test(signed_email)==false){

            $('#snackbar-signedsim').css('visibility', 'visible');
            $('#snackbar-signedsim p').html('Quý khách nhập sai định dạng email !');
            $('#signed_email').parent().children('.icon_error').css('display','block');
            $('#signed_email').addClass('focus-input');
            $('#signed_email').focus();
            return false;
        }
    }
    $('#snackbar-signedsim').css('visibility', 'hidden');
    $('#signed_email').removeClass('focus-input');


    if(signed_number_sim != ''){
        if(/^0\d{9}$/.test(signed_number_sim)==false){
            $('#snackbar-signedsim').css('visibility', 'visible');
            $('#snackbar-signedsim p').html('Số điện thoại gồm 10 số, bắt đầu từ số 0 !');
            $('#number_sim').parent().children('.icon_error').css('display','block');
            $('#number_sim').addClass('focus-input');
            $('#number_sim').focus();
            return false;
        }
    }else{
        $('#snackbar-signedsim').css('visibility', 'visible');
        $('#snackbar-signedsim p').html('Số điện thoại gồm 10 số, bắt đầu từ số 0 !');
        $('#number_sim').parent().children('.icon_error').css('display','block');
        $('#number_sim').addClass('focus-input');
        $('#number_sim').focus();
        return false;
    }
    $('#snackbar-signedsim').css('visibility', 'hidden');
    $('#number_sim').removeClass('focus-input');


    if(signed_price_sell != '') {
        // if (/^[1-9]{1}[0-9]+$/.test(signed_price_sell) == false) {
        //     $('#price_sell').parent().children('.icon_error').css('display','block');
        //     $('#price_sell').addClass('focus-input');
        //     $('#price_sell').focus();
        //     return false;
        // }
    }else{
        $('#snackbar-signedsim').css('visibility', 'visible');
        $('#snackbar-signedsim p').html('Vui lòng nhập giá tiền !');
        $('#price_sell').parent().children('.icon_error').css('display','block');
        $('#price_sell').addClass('focus-input');
        $('#number_sim').focus();
        return false;
    }
    $('#snackbar-signedsim').css('visibility', 'hidden');
    $('#price_sell').removeClass('focus-input');


    if(signed_percent_brokers != '') {
        if (/^(100|[1-9]?[0-9])$/.test(signed_percent_brokers) == false && signed_percent_brokers>=15) {
            $('#snackbar-signedsim').css('visibility', 'visible');
            $('#snackbar-signedsim p').html('Vui lòng nhập % ký gửi!');
            $('#percent_brokers').parent().children('.icon_error').css('display','block');
            $('#percent_brokers').addClass('focus-input');
            $('#percent_brokers').focus();
            return false;
        }
    }else{

        $('#snackbar-signedsim').css('visibility', 'visible');
        $('#snackbar-signedsim p').html('% tối thiểu cho môi giới từ 15% trở lên !');
        $('#percent_brokers').parent().children('.icon_error').css('display','block');
        $('#percent_brokers').addClass('focus-input');
        $('#percent_brokers').focus();
        return false;
    }
    $('#snackbar-signedsim').css('visibility', 'hidden');
    $('#percent_brokers').removeClass('focus-input');

    document.forms['form-default'].submit();
}


function isNumber(event) {
    var keycode = event.keyCode;
    if(keycode >=48 && keycode<=57){
        return true;
    }
    return false;
}