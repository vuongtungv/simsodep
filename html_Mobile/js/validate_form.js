$(document).ready( function(){
    var fullname = document.forms['form_register']['fullname'].value;
    var email = document.forms['form_register']['email'].value;
    var phone = document.forms['form_register']['phone'].value;
    var city = document.forms['form_register']['select-city'].value;
    var id_card = document.forms['form_register']['id_card'].value;
    var code_prizes = document.forms['form_register']['code_prizes'].value;
    var txtCaptcha = document.forms['form_register']['txtCaptcha'].value;
    var filterEmail = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    var phoneno = /^\(?([0]{1})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{4})$/;
    if(fullname == ''){
        alert('Bạn chưa nhập họ và tên.');
        var fullname = document.getElementById("fullname");
        $('#fullname').addClass('validate_check');
        fullname.scrollIntoView({
            behavior: 'auto',
            block: 'center',
            inline: 'center',
        });
        return false;
    }
    $('#full_name').removeClass('validate_check');


    if(email == ''){
        alert('Bạn chưa nhập email.');
        var input_email = document.getElementById("input_email");
        $('#input_email').addClass('validate_check');
        input_email.scrollIntoView({
            behavior: 'auto',
            block: 'center',
            inline: 'center',
        });
        return false;
    }
    $('#input_email').removeClass('validate_check');
    if(!email.match(filterEmail)){
        alert('Email chưa đúng định dạng');
        var input_email = document.getElementById("input_email");
        $('#input_email').addClass('validate_check');
        input_email.scrollIntoView({
            behavior: 'auto',
            block: 'center',
            inline: 'center',
        });
        email.focus();
        return false;
    }
    $('#input_email').removeClass('validate_check');


    if(phone == ''){
        alert('Bạn chưa nhập số điện thoại.');
        var  input_phone= document.getElementById("input_phone");
        $('#input_phone').addClass('validate_check');
        input_phone.scrollIntoView({
            behavior: 'auto',
            block: 'center',
            inline: 'center',
        });
        return false;
    }
    phone = phone.replace(/\s+/g,''); // strip the white space

    if( /^0\d{9}$/.test(phone) ){
        // passed test
    }else{
        // did not pass, show error
        alert('Số điện thoại gồm 10 ký tự 0-9 và bắt đầu bằng số 0.');
        return false;
    }
    $('#input_phone').removeClass('validate_check');


    if(city == ''){
        alert('Bạn chưa nhập thành phố.');
        var input_city = document.getElementById("input_city");
        $('#input_city').addClass('validate_check');
        input_city.scrollIntoView({
            behavior: 'auto',
            block: 'center',
            inline: 'center',
        });
        return false;
    }
    $('#input_city').removeClass('validate_check');


    if(id_card == ''){
        alert('Bạn chưa nhập số CMND.');
        var id_card = document.getElementById("id_card");
        $('#id_card').addClass('validate_check');
        id_card.scrollIntoView({
            behavior: 'auto',
            block: 'center',
            inline: 'center',
        });
        return false;
    }
    $('#id_card').removeClass('validate_check');


    if(code_prizes == ''){
        alert('Bạn chưa nhập mã số dự thưởng.');
        var code_prizes = document.getElementById("code_prizes");
        $('#code_prizes').addClass('validate_check');
        code_prizes.scrollIntoView({
            behavior: 'auto',
            block: 'center',
            inline: 'center',
        });
        return false;
    }
    $('#code_prizes').removeClass('validate_check');
    code_prizes = code_prizes.replace(/\s+/g,''); // strip the white space

    if( /([A-Z]{3}[0-9]{7})$/.test(code_prizes) ){
        // passed test
        if(code_prizes.length !=10){
            alert('Mã số dự thưởng phải gồm 10 ký tự, bắt đầu bằng 3 chữ hoa và 7 số. ');
            return false;
        }
    }else{
        // did not pass, show error
        alert('Mã số dự thưởng phải gồm 10 ký tự, bắt đầu bằng 3 chữ hoa và 7 số. ');
        return false;
    }

});