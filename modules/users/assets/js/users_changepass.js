function checkFormsubmit()
{
//	email_new = $('#email_new').val();
//	if(email_new.length ){
//		re_email_new = $('#re_email_new').val();
//		if(!emailValidator("email_new", "Bạn nhập không đúng định dạng email")){
//			return false;
//		}
//		if(email_new != re_email_new){
//			$('#msg_error').html('Email không khớp');
//			return false;
//		}
//	}
    $('label.label_error').prev().remove();
    $('label.label_error').remove();
//    if($('#text_pass_old').val()==''){
//        alert('Bạn phải nhập mật khẩu cũ');
//    }
    if (!notEmpty2("text_pass_old", "text_pass_old", "Bạn phải nhập mật khẩu cũ"))
    {
        return false;
    }
    if (!notEmpty2("text_pass_new", "text_pass_new", "Bạn chưa nhập mật khẩu mới"))
    {
        return false;
    }

    if (!lengthMin("text_pass_new", 8, "Mật khẩu ít nhất 8 ký tự, chứa ít nhất 1 kí tự số (0-9), và ít nhất 1 kí tự in Hoa(A-Z)"))
    {
        return false;
    }
    if (!minOneNumber("text_pass_new", "Mật khẩu ít nhất 8 ký tự, chứa ít nhất 1 kí tự số (0-9), và ít nhất 1 kí tự in Hoa(A-Z)!"))
    {
        return false;
    }
    if (!minOneChar("text_pass_new", "Mật khẩu ít nhất 8 ký tự, chứa ít nhất 1 kí tự số (0-9), và ít nhất 1 kí tự in Hoa(A-Z)!"))
    {
        return false;
    }
    if (!notEmpty2("text_re_pass_new", "text_re_pass_new", "Bạn chưa nhập xác nhận mật khẩu mới"))
    {
        return false;
    }
        $pass_new = $('#text_pass_new').val();
    $pass_re = $('#text_re_pass_new').val();

    if ($pass_new != $pass_re) {
        $("#valid_pass").text('Xác nhận mật khẩu chưa trùng nhau!');
        $('#text_re_pass_new').focus();
        return false;
    }
            if (!notEmpty2("capcha", "capcha", "Bạn chưa nhập Mã Xác Minh"))
    {
        return false;
    }


//    if (checkMatchPass_2("text_pass_new", "text_re_pass_new", "Mật khẩu mới không khớp"))
//    {
//        return false;
//    }

    return true;
}