$(document).ready( function(){
	/* FORM CONTACT */
	$('#submitbt_login').click(function(){
		if(checkFormsubmitLogin())
			document.login_form.submit();
	})
	//check_exist_username();
	$('#submitbt_register').click(function(){
		if(checkFormsubmitRegister())
			document.register_form.submit();
	})
	//check_exist_username();
	$('#submitbt_forget').click(function(){
		if(checkFormsubmitForget())
			document.forget_form.submit();
	})
	check_exist_username();
});
function checkFormsubmitLogin()
{
	$('label.label_error').prev().remove();
	$('label.label_error').remove();
	if(!notEmpty("email_login","Bạn phải nhập email"))
	{
		return false;
	}
	if(!emailValidator("email_login","Email nhập không hợp lệ")){
		return false;
	}
	if(!notEmpty("password_login","Hãy nhập mật khẩu")){
		return false;
	}
	return true;
}
function checkFormsubmitForget()
{
	$('label.label_error').prev().remove();
	$('label.label_error').remove();
	if(!notEmpty("email_forget","Bạn phải nhập email"))
	{
		return false;
	}
	if(!emailValidator("email_forget","Email nhập không hợp lệ")){
		return false;
	}
	return true;
}

function checkFormsubmitRegister()
{
	var remember = $('#remember').val();
	$('label.label_error').prev().remove();
	$('label.label_error').remove();
	if(!notEmpty("email_register","Bạn phải nhập email"))
	{
		return false;
	}
	if(!emailValidator("email_register","Email nhập không hợp lệ")){
		return false;
	}
	if(!notEmpty("password_register","Hãy nhập mật khẩu")){
		return false;
	}
	if(!madeCheckbox("remember","Bạn chưa chấp nhận điều khoản")){
		return false;
	}
	return true;
}

/* CHECK EXIST  USERNAME */
function check_exist_username(){
	$('#email_register').blur(function(){
		if($(this).val() != ''){
			if(!emailValidator("email_register","Email không đúng định dạng"))
				return false;
			$.ajax({
			type: "POST",	
			data: {email_register: $('#email_register').val()},
			url: root+"index.php?module=users&task=ajax_check_exist_username&raw=1",
			success: function(result) {
				if(result == 0){
					invalid('email_register','Tên truy nhập này đã tồn tại. Bạn hãy sử dụng tên truy cập khác');
				} else {
					valid('username_register');
					$('<br/><div class=\'label_success\'>'+'Tên truy nhập này được chấp nhận'+'</div>').insertAfter($('#email_register').parent().children(':last'));
				}
			}
		});
		}
	});
}