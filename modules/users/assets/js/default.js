/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function () {

    $("#birthday").datepicker({
        clickInput: true,
        dateFormat: 'dd-mm-yy',
        changeMonth: true,
        numberOfMonths: 1,
        changeYear: true,
        showMonthAfterYear: true
    });

    $('input#name').on('keyup', function () {
        limitText(this, 32)
    });
    $('input#email').on('keyup', function () {
        limitText(this, 52)
    });
    $('input#telephone').on('keyup', function () {
        limitText(this, 11)
    });


    $("#date_from").datepicker({
        clickInput: true,
        dateFormat: 'yy-mm-dd',
        changeMonth: true,
        numberOfMonths: 1,
        changeYear: true,
        showMonthAfterYear: true,
         maxDate: new Date(),
    });
     $("#date_to").datepicker({
        clickInput: true,
        dateFormat: 'yy-mm-dd',
        changeMonth: true,
        numberOfMonths: 1,
        changeYear: true,
        showMonthAfterYear: true,
        maxDate: new Date(),
    });


    /* FORM CONTACT */
//    check_exist_username();

    /****** CHECK CAPTCHA ****/

    /****** Expert ******/
//    check_address();
//    show_hidden();
    $('.btn_show_list').click(function () {
        if (check_form_list_user()) {
            document.show_list_user.submit();
        }

    });

    $('.btn_excel').click(function () {
     
        document.show_list_user.submit();
        window.location.href = '/index.php?module=users&view=users&task=export&raw=1';

    })

    check_exist_email();
    check_exist_dcs();
    check_exist_cmt();


    $('#submitbt_user').click(function () {
   
        if (checkFormsubmit()) {
            var r = confirm("Sau khi click OK bạn không thể sửa trường Tên học viên và Tên đăng nhập.Vui lòng xác nhận lại thông tin!");
            if (r == true) {
                document.register_form_user.submit();
            } else {
                return;
            }

        }
    })
    $('#submitbt_user_update').click(function () {
        var check_email = $('#check_trung').val();
        var check_cmt = $('#check_trung_cmt').val();
        var check_dsc = $('#check_trung_dsc').val();

        if (checkFormsubmit_update()) {
            if (check_email != 1 && check_cmt != 1 && check_dsc !=1) {
                document.update_form_user.submit();
            }

        }
    })


});

function check_form_list_user() {

    var date_from=$('#date_from').val();
    var date_to=$('#date_to').val();

var date_1=new Date(date_from).getTime();
var date_2=new Date(date_to).getTime();

    // if (!notEmpty2("date_from", "Chọn thời gian", "Bạn chưa chọn thời gian lấy giữ liệu"))
    // {
    //     return false;
    // }
    // if (!notEmpty2("date_to", "Chọn thời gian", "Bạn chưa chọn thời gian lấy dữ liệu"))
    // {
    //     return false;
    // }

    if(date_1 > date_2){
          $("#err_text").text('Ngày bắt đầu phải nhỏ hơn ngày kết thúc!');
           return false;
    }

    return true;
}
//function invalid(element, helperMsg, type) {
//  //$("#" + element).parent().find('.label_error').prev().remove();
//  $("#" + element).parent().find('.label_error').remove();
//  //$("#" + element).parent().find('.label_success').prev().remove();
//  $("#" + element).parent().find('.label_success').remove();
//  $('<div class=\'label_error\'>' + helperMsg + '</div>').insertAfter($('#' + element).parent().children(':last'));
//  $("#" + element).addClass("redborder");
//  $("#" + element).focus();
//  // $('html, body').animate({
//  //     scrollTop: $('#' + element).position().top,
//  // }, 'slow');
//
//}
//function valid(element, helperMsg, type) {
//  $("#" + element).removeClass("redborder");
//  //$("#" + element).parent().find('.label_error').prev().remove();
//  $("#" + element).parent().find('.label_error').remove();
//  //$("#" + element).parent().find('.label_success').prev().remove();
//  $("#" + element).parent().find('.label_success').remove();
//}

//If the length of the element's string is 0 then display helper message
function notEmpty(elemid, helperMsg) {
  elem = $('#' + elemid);
  var val_elem = elem.val();

  if (!val_elem || val_elem.length == 0) {
    invalid(elemid, helperMsg);
    elem.focus(); // set the focus to this input
    return false;
  } else {
    valid(elemid);
    return true;
  }
}

function checkFormsubmit()
{

    $('label.label_error').prev().remove();
    $('label.label_error').remove();
    email_new = $('#email_new').val();
//    if (!notEmpty2("username", "Nhập username", "Bạn chưa nhập tên đăng nhập"))
//    {
//        return false;
//    }

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


    if (!notEmpty("name", "Bạn chưa nhập họ tên "))
    {
        return false;
    }
    //không chứa ký tự đặc biệt
    re = /[~`!#$%\^&*+=[\]\\';,/{}|\\":<>\?]/;
    if (re.test($("#name").val())) {
        $("#valid_name").text('Trường này chỉ cho phép nhập các kí tự từ 0-9 và từ A-Z');
        $('#name').focus();
        return false;
    } else {
        $("#valid_name").text('');
    }

//  if (!notEmpty2("dcs_code", "Nhập mã dcs_code", "Bạn chưa nhập mã DCS Code"))
//    {
//        return false;
//    }
    //check kí tư đặc biệt code
//    re = /[~`!#$%\^&*+=[\]\\';,/{}|\\":<>\?]/;
//    if (re.test($("#dcs_code").val())) {
//        $("#valid_code").text('Mã DCS Code không được chứa kí tự đặc biệt');
//        $('#dcs_code').focus();
//        return false;
//    } else {
//        $("#valid_code").text('');
//    }
//    //DCS không nhập quá 225 kí tự
//    if (!lengthMax("dcs_code", 225, "Trường này chỉ cho phép nhập không quá 225 kí tự"))
//    {
//        $('#dcs_code').focus();
//        return false;
//    }

    if (!notEmpty("cmt", "Bạn chưa nhập số CMT"))
    {
        return false;
    }
    if (!isPhone("cmt", "Bạn nhập số cmt không hợp lệ.")) {
        $('#cmt').focus();
        return false;
    }

    if (!lengthMin("cmt", 9, "Số CMT phải lớn hơn 9 ký tự "))
    {
        $('#cmt').focus();
        return false;
    }
    if (!lengthMax("cmt", 13, "Trường này chỉ cho phép nhập 12 kí tự"))
    {
        $('#cmt').focus();
        return false;
    }


    if (!notEmpty("email", "Hãy nhập email")) {
        return false;
    }
    if (!emailValidator("email", "Email nhập không hợp lệ")) {
        return false;
    }
    if (!notEmpty("telephone","Bạn chưa nhập số điện thoại"))
    {
        $('#telephone').focus();
        return false;
    }
    if (!isPhone("telephone", "Bạn nhập số điện thoại không hợp lệ.")) {
        $('#telephone').focus();
        return false;
    }
    if (!lengthMin("telephone", 10, "Bạn nhập số điện thoại không hợp lệ"))
    {
        $('#telephone').focus();
        return false;
    }
    if (!lengthMax("telephone", 13, "Trường này chỉ cho phép nhập 12 kí tự"))
    {
        $('#telephone').focus();
        return false;
    }

    if (!isPhone("telephone", "Bạn nhập số điện thoại không hợp lệ"))
        return false;

    if ($('#position').val() == 0) {
        $("#valid_position").text('Bạn chưa chọn chức vụ');
        $('#position').focus();
        return false;
    }
    return true;
}
function checkFormsubmit_update()
{
    $('label.label_error').prev().remove();
    $('label.label_error').remove();
    email_new = $('#email_new').val();

    $pass_new = $('#password').val();
    $pass_re = $('#re-password').val();
    $pass_old = $('#password_hidden').val();

    if ($pass_new != $pass_old || $pass_re != $pass_old) {

        if ($pass_new == '') {
            $("#valid_pass").text('Bạn chưa nhập password!');
            $('#password').focus();
            return false;
        }
        if ($('#password').val().length <= 8) {
            $("#valid_pass").text('Mật khẩu ít nhất 8 ký tự!');
            $('#password').focus();
            return false;
        }
        re = /[0-9]/;
        if (!re.test($("#password").val())) {
            $("#valid_pass").text('Mật khẩu phải chứa ít nhất một chữ số (0-9)!');
            $('#password').focus();
            return false;
        } else {
            $("#valid_pass").text('');
        }
        re = /[A-Z]/;
        if (!re.test($("#password").val())) {
            $("#valid_pass").text('Mật khẩu phải chứa ít nhất một ký tự in hoa(A-Z)!');
            $('#password').focus();
            return false;
        } else {
            $("#valid_pass").text('');
        }
        re = /[~`!#$%\^&*+=[\]\\';,/{}|\\":<>\?]/;
        if (!re.test($("#password").val())) {
            $("#valid_pass").text('Mật khẩu phải có ít nhất một ký tự đặc biệt (*&...)');
            $('#password').focus();
            return false;
        } else {
            $("#valid_pass").text('');
        }

        if ($pass_new != $pass_re) {
            $("#valid_pass").text('Xác nhận mật khẩu chưa trùng nhau!');
            $('#re-password').focus();
            return false;
        }


    }

//if (!notEmpty2("dcs_code", "Nhập mã dcs_code", "Bạn chưa nhập mã DCS Code"))
//    {
//        return false;
//    }
    //check kí tư đặc biệt code
    re = /[~`@!#$%\^&*+=[\]\\';,/{}|\\":<>\?]/;
    if (re.test($("#dcs_code").val())) {
        $("#valid_code").text('Mã DCS Code không được chứa kí tự đặc biệt');
        $('#dcs_code').focus();
        return false;
    } else {
//        $("#valid_code").text('');
    }
    //DCS không nhập quá 225 kí tự

    if (!notEmpty2("cmt", "Nhập mã cmt", "Bạn chưa nhập số CMT"))
    {
        return false;
    }
    if (!isPhone("cmt", "Bạn nhập số cmt không hợp lệ.")) {
        $('#cmt').focus();
        return false;
    }

    if (!lengthMin("cmt", 9, "Số CMT phải lớn hơn 9 ký tự "))
    {
        $('#cmt').focus();
        return false;
    }
    if (!lengthMax("cmt", 13, "Trường này chỉ cho phép nhập 12 kí tự"))
    {
        $('#cmt').focus();
        return false;
    }

    if (!notEmpty2("telephone", "Nhập số điện thoại", "Bạn chưa nhập số điện thoại"))
    {
        $('#telephone').focus();
        return false;
    }
    if (!notEmpty("email", "Hãy nhập email")) {
        return false;
    }
    if (!emailValidator("email", "Email không đúng định dạng")) {
        return false;
    }

    if (!isPhone("telephone", "Bạn nhập số điện thoại không hợp lệ"))
        return false;

    return true;
}
/* CHECK EXIST  DCS */
function check_exist_dcs() {
    $user_id = $('#id_user').val();
    $('#dcs_code').blur(function () {
        if ($(this).val() != '') {
            $.ajax({url: "/index.php?module=users&task=ajax_check_exist_dcs&raw=1",
                data: {code_dcs: $(this).val(), id: $user_id},
                dataType: "text",
                success: function (result) {
                    $('label.username_check').prev().remove();
                    $('label.username_check').remove();
                    if (result == 0) {
                        $('#email_succes').text('');
                        $('#valid_code').html('DCS code bị trùng. Bạn vui lòng nhập DCS code khác!');
                        $("#check_trung_dsc").val("1");
                        $('#dcs_code').focus();
                        return false;
                        //    invalid('email', 'Email này đã tồn tại. Bạn hãy sử dụng email khác');

                    } else {
                        $('#valid_code').text('');
                         $("#check_trung_dsc").val("0");
//                            $('#code_error').text('Tên đăng nhập này được chấp nhận!!');
//                        valid('email');
//                        $('<br/><div id=\'email_error\' class=\'label_success username_check\'>' + 'Tên truy nhập này được chấp nhận' + '</div>').insertAfter($('#email').parent().children(':last'));
                    }
                }
            });
        }
    });
}

/* CHECK EXIST  USERNAME */
function check_exist_cmt() {
    $user_id = $('#id_user').val();
    $('#cmt').blur(function () {
        if ($(this).val() != '') {
            $.ajax({url: root + "index.php?module=users&task=ajax_check_exist_cmt&raw=1",
                data: {cmt: $(this).val(), id: $user_id},
                dataType: "text",
                success: function (result) {
                    $('label.username_check').prev().remove();
                    $('label.username_check').remove();
                    if (result == 0) {
                        invalid('cmt', 'Bạn đã nhập trùng số CMT. Bạn vui lòng kiểm tra lại');
                        $("#check_trung_cmt").val("1");
                        $('#cmt').focus();
                        return false;
                    } else {
                        $('#valid_cmt').html('');
                        $("#check_trung_cmt").val("0");
                    }
                }
            });
        }
    });
}
function check_exist_username() {
    $user_id = $('#id_user').val();
    $('#username').blur(function () {
        if ($(this).val() != '') {
            $.ajax({url: root + "index.php?module=users&task=ajax_check_exist_username&raw=1",
                data: {username: $(this).val(), id: $user_id},
                dataType: "text",
                success: function (result) {
                    $('label.username_check').prev().remove();
                    $('label.username_check').remove();
                    if (result == 0) {
                        $('#check_validate').html('Tên truy nhập này đã tồn tại. Bạn hãy sử dụng tên truy cập khác');
                        //   invalid('username', 'Tên truy nhập này đã tồn tại. Bạn hãy sử dụng tên truy cập khác');
                    } else {
                        $('#check_validate').html('');
                    }
                }
            });
        }
    });
}
/* CHECK EXIST EMAIL  */
function check_exist_email() {
    $user_id = $('#id_user').val();
    $('#email').blur(function () {
        if ($(this).val() != '') {
            if (!emailValidator("email", "Email không đúng định dạng"))
                return false;
            $.ajax({url: root + "index.php?module=users&task=ajax_check_exist_email&raw=1",
                data: {email: $(this).val(), id: $user_id},
                dataType: "text",
                success: function (result) {
                    $('label.email_check').prev().remove();
                    $('label.email_check').remove();
                    if (result == 0) {
                        invalid('email', 'Email này đã tồn tại. Bạn hãy sử dụng email khác');
                        $("#check_trung").val("1");
                        $('#email').focus();
                        return false;
                    } else {
                        $("#check_trung").val("0");
                    }
                }
            });
        }
    });
}

function show_hidden() {
    $('.show-hidden-register').click(function () {
        var stt = $(this).attr('lang');
        if ($('#hidden-professional' + stt).css('display') == 'block') {
            $('#hidden-professional' + stt).css('display', 'none');
            $(this).removeClass('bottom-collapse');
            $(this).addClass('bottom-expand');
        } else {
            $('#hidden-professional' + stt).css('display', 'block');
            $(this).removeClass('bottom-expand');
            $(this).addClass('bottom-collapse');
        }
    });
}
function limitText(field, maxChar) {
    var ref = $(field),
            val = ref.val();
    if (val.length >= maxChar) {
        ref.val(function () {
            console.log(val.substr(0, maxChar))
            return val.substr(0, maxChar);
        });
    }
}