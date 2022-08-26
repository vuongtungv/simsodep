$(document).ready( function(){
	/* FORM CONTACT */
	$('#submitbt').click(function(){
		if(checkFormsubmit())
			document.contact.submit();
	})
	$('#resetbt').click(function(){
		document.contact.reset();
	})
    
    $('#submitbt_p').click(function(){
		if(checkFormsubmit_p())
			document.contact_popup.submit();
	})
    
	$('#resetbt_p').click(function(){
		document.contact_popup.reset();
	})
    
    $('a.open-switcher').click(function() {        
   	 var switchParent = $('#right');
    	if ( !switchParent.hasClass('active') ) {
    		switchParent.addClass('active');
            $('a.open-switcher').addClass('active');
            
    	} else {
    		switchParent.removeClass('active');
            $('a.open-switcher').removeClass('active');
            $('#right').css({ 'height': ($('.right-ct').height()) + 50 });
    	}
    });
    
});

	     
function checkFormsubmit()
{
	$('label.label_error').prev().remove();
	$('label.label_error').remove();
	email_new = $('#email_new').val();
     
    if(!notEmpty("contact_title","Bạn chưa nhập tiêu đề"))
	{
		return false;
	}
	if(!notEmpty("contact_name","Bạn chưa nhập họ và tên"))
	{
		return false;
	}
    if(!lengthMin("contact_name",6,'"Họ tên đầy đủ của bạn" phải 6 kí tự trở lên, vui lòng sửa lại!'))
	{
		return false;
	}
	if($(".select-no-group option:selected").val() == ''){
        invalid("contact_group",'Bạn phải chọn Nhóm đối tượng');
        return false;
    }
    if(!notEmpty("contact_email","Bạn chưa nhập Email")){
		return false;
	}
	if(!emailValidator("contact_email","Emal không đúng định dạng")){
		return false;
	}
    if(!notEmpty("contact_address","Bạn chưa nhập địa chỉ liên hệ"))
		return false; 
    if($(".select-no-parts option:selected").val() == ''){
        invalid("contact_parts",'Bạn phải chọn Bộ phận liên hệ');
        return false;
    }
    if(!notEmpty("message","Bạn chưa nhập nội dung liên hệ"))
	{
		return false;
	}
	if(!lengthRestriction("message",6,1000))
	{
		return false;
	}

	if(!notEmpty("txtCaptcha","Nhập mã bảo mật"))
		return false;
        
	$.ajax({url: "/index.php?module=users&task=ajax_check_captcha&raw=1",
		data: {txtCaptcha: $('#txtCaptcha').val()},
		dataType: "text",
		async: false,
		success: function(data) { 
			console.log(data);
			$('label.username_check').prev().remove();
			$('label.username_check').remove();
			if(data == '0'){
				invalid('txtCaptcha','Mã bảo mật là không chính xác.');
				alert('Captcha is incorrect');
				console.log('--------');
				return false;
			} else {
				valid('txtCaptcha');
				console.log('+++');
					document.contact.submit();
				return true;
			}
		}
	});
}

function checkFormsubmit_p()
{
	$('label.label_error').prev().remove();
	$('label.label_error').remove();
	email_new = $('#email_new').val();
     
	if(!notEmpty("contact_name_p","Bạn chưa nhập họ và tên"))
	{
		return false;
	}
    if(!notEmpty("contact_phone_p","Bạn chưa nhập số liên hệ"))
		return false;
        
	if(!isPhone("contact_phone_p","Bạn chưa nhập đúng định dạng"))
		return false;
    
    if(!notEmpty("contact_email_p","Bạn chưa nhập Email")){
		return false;
	}
	if(!emailValidator("contact_email_p","Emal không đúng định dạng")){
		return false;
	}
	if(!notEmpty("txtCaptcha_p","Nhập mã xác minh"))
		return false;
    
	$.ajax({url: "/index.php?module=users&task=ajax_check_captcha&raw=1",
		data: {txtCaptcha: $('#txtCaptcha_p').val()},
		dataType: "text",
		async: false,
		success: function(data) { 
			console.log(data);
			$('label.username_check').prev().remove();
			$('label.username_check').remove();
			if(data == '0'){
				invalid('txtCaptcha_p','Captcha là không chính xác.');
				alert('Captcha is incorrect');
				console.log('--------');
				return false;
			} else {
				valid('txtCaptcha_p');
				console.log('+++');
					document.contact_popup.submit();
				return true;
			}
		}
	});
}