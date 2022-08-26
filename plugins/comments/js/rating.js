submit_comment();
function submit_comment()
{
	$('#submitbt').click(function(){
		if(!notEmpty("name","Bạn phải nhập tên"))
			return false;
		if(!notEmpty("text","Bạn phải nhập nội dung"))
			return false;
		$.ajax({url: "/index.php?module=users&task=ajax_check_captcha&raw=1",
			data: {
				txtCaptcha: $('#txtCaptcha').val()
				},
			dataType: "text",
			async: false,
			success: function(result) {
				$('label.username_check').prev().remove();
				$('label.username_check').remove();
				if(result == 0){
					invalid('txtCaptcha','Bạn nhập sai mã hiển thị');
					return false;
				} else {
					valid('txtCaptcha');
						$('.button_area').html('<a class="button " href="javascript: void(0)"><span>Đăng đánh giá</span></a>');
						document.comment_add_form.submit();
					return true;
				}
			}
			
		});

	});
	
}
function check_login($value){
	if($value == 0)
	{
		alert("Bạn phải đăng nhập thì mới được sử dụng chức năng này.");
		$( "#comment_form" ).addClass( "hide" );
		return ;
	}else if($value == 1){
		$( "#comment_form" ).removeClass( "hide" );
		return ;
	}
	
}