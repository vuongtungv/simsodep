/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function () {

    $('#submit_login').click(function () {
        if (checkFormsubmit())
            document.login_form.submit();
    });

    $('.login_form').keypress(function (e) {
        if (e.which == 13) {
            if (checkFormsubmit())
                document.login_form.submit();
        }
    }); 

       $('.link_login').click(function () {
            if (validateForgot_1())
                document.frm_forget_pass.submit();
    });

     $('#update_pass').click(function () {

            if (validateForgot_pass())
                document.frm_up_pass.submit();
    });


});

function checkFormsubmit()
{

    $('label.label_error').prev().remove();
    $('label.label_error').remove();
    email_new = $('#email_new').val();

//    if (!notEmpty2("user_username", "Nhập username", "Bạn chưa nhập tên đăng nhập"))
//    {
//        return false;
//    }
    if ($('#user_username').val() == '') {
        alert('Bạn chưa nhập tên đăng nhập.');
        $('#username').focus();
        return false;
    }
//    if (!notEmpty2("user_password", "password", "Bạn chưa nhập password"))
//    {
//        return false;
//    }
      if ($('#user_password').val() == '') {
        alert('Bạn chưa nhập password.');
        $('#username').focus();
        return false;
    }
    
    return true;
}
function validateForgot() {

    if ($('#username').val() == '') {
        alert('Bạn vui lòng nhập tên đăng nhập hoặc email.');
        $('#username').focus();
        return false;
    }

    var $data = $('form#frm_forget_pass').submit();
    $.ajax({
        type: 'POST',
        dataType: 'json',
        url: '/index.php?module=users&task=forget_save',
        data: $data,
        success: function (data) {
            console.log(data);
//            Boxy.alert(data.message, function () {
            if (data.error == false) {
                alert('Yêu cầu đã được gửi đi. Vui lòng kiểm tra email để thực hiện bước tiếp theo.');
                //$(window.location).attr('href', data.redirect);
            }
//            }, {title: 'Thông báo.', afterShow: function () {
//                    $('#boxy_button_OK').focus();
//                }});
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
//            Boxy.alert('Có lỗi trong quá trình đưa lên máy chủ. Xin bạn vui lòng kiểm tra lại kết nối.', function () {
//            }, {title: 'Thông báo.', afterShow: function () {
//                    $('#boxy_button_OK').focus();
//                }});
        }
    });
    return false;
}

function validateForgot_1() {
   if ($('#username').val() == '') {
        alert('Bạn vui lòng nhập tên đăng nhập hoặc email.');
        $('#username').focus();
        return false;
    }
    return true;
}

function validateForgot_pass() {

if (!notEmpty("activated_code", "Bạn vui lòng nhập mã bảo mật"))
    {
        return false;
    }

  if (!notEmpty("password", "Bạn chưa nhập password"))
    {
        return false;
    }
        if (!lengthMin("password", 8, "Mật khẩu ít nhất 8 ký tự, chứa ít nhất 1 kí tự số (0-9), và ít nhất 1 kí tự in Hoa(A-Z)"))
    {
        return false;
    }
    if (!minOneNumber("password", "Mật khẩu ít nhất 8 ký tự, chứa ít nhất 1 kí tự số (0-9), và ít nhất 1 kí tự in Hoa(A-Z)!"))
    {
        return false;
    }
    if (!minOneChar("password", "Mật khẩu ít nhất 8 ký tự, chứa ít nhất 1 kí tự số (0-9), và ít nhất 1 kí tự in Hoa(A-Z)!"))
    {
        return false;
    }
    re = /[~`!#$%\^&*+=[\]\\';,/{}|\\":<>\?]/;
    if (!re.test($("#password").val())) {
        $("#valid_pass").text('Mật khẩu phải có ít nhất một ký tự đặc biệt (*&...)');
        $('#password').focus();
        return false;
    } else {
        $("#valid_pass").text('');
    }

    if(!checkMatchPass_2('password','repassword','Mật khẩu mới không trùng nhau')){
        return false;
    }


    return true;
}