// submit_comment();
display_hidden_comment_form();

$(document).ready( function(){
	/* FORM CONTACT */

	var id = $('#record_id').val();
	var cmt_module = $('#_cmt_module').val();
	var cmt_view = $('#_cmt_view').val();
	var cmt_return = $('#_cmt_return').val();
	
	$("#_info_comment").load("/index.php?module=comments&view=comments&raw=1&id="+id+"&cmt_module="+cmt_module+"&cmt_view="+cmt_view+"&cmt_return="+cmt_return, {'page':0}, function() {
		// $("#1-page").addClass('active');
	});  //initial page number to load

});

function submit_comment()
{
	if(!notEmpty("cmt_content","Bạn phải nhập nội dung"))
		return false;
	if(!notEmpty("cmt_name","Bạn phải nhập họ tên"))
	{
		return false;
	}
	if(!notEmpty("cmt_email","Bạn phải email"))
		return false;
	if(!emailValidator("cmt_email","Email nhập không hợp lệ")){
		return false;
	}
	if(!notEmpty("txtCaptcha","Bạn phải nhập mã hiển thị"))
		return false;
    /* stop form from submitting normally */
	// event.preventDefault();

	/* get some values from elements on the page: */
 	url = $('#link_reply_form').val();
	/* Send the data using post */
	var posting = $.post( url, { 
		name: $('#cmt_name').val(), 
		email: $('#cmt_email').val(), 
		content: $('#cmt_content').val(), 
		record_id: $('#_cmt_record_id').val(), 
		parent_id: $('#parent_id').val(), 
		module: $('#_cmt_module').val(), 
		view: $('#_cmt_view').val(), 
		"return": $('#_cmt_return').val()

	} );
	var id = $('#record_id').val();
	var cmt_module = $('#_cmt_module').val();
	var cmt_view = $('#_cmt_view').val();
	var cmt_return = $('#_cmt_return').val();
	/* Alerts the results */

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
				posting.done(function( data ) {
				    $('html, body').animate({scrollTop:$('#_info_comment').position().top}, 'slow');
					// alert('Cảm ơn bạn đã gửi comment');
					$('#cmt_name').val('');
					$('#cmt_email').val('');
					$('#cmt_content').val('');
					$("#_info_comment").load("/index.php?module=comments&view=comments&raw=1&id="+id+"&cmt_module="+cmt_module+"&cmt_view="+cmt_view+"&cmt_return="+cmt_return, {'page':0}, function() {
						Alert.render('Cảm ơn bạn đã gửi comment');
						// $("#1-page").addClass('active');
                        
					});  //initial page number to load
				});
			}
		}
		
	});
	// posting.done(function( data ) {
	// 	// alert('Cảm ơn bạn đã gửi comment');
	// 	$('#cmt_name').val('');
	// 	$('#cmt_email').val('');
	// 	$('#cmt_content').val('');
	// 	$("#_info_comment").load("/index.php?module=comments&view=comments&raw=1&id="+id+"&cmt_module="+cmt_module+"&cmt_view="+cmt_view+"&cmt_return="+cmt_return, {'page':0}, function() {
	// 		// $("#1-page").addClass('active');
	// 	});  //initial page number to load
	// });
	
}



function submit_reply(comment_id){
	if(!notEmpty2('cmt_content_'+comment_id,'Nội dung','Bạn phải nhập nội dung')){
		return false;
	}
	 if(!notEmpty2("cmt_name_"+comment_id,'Họ tên',"Bạn phải nhập họ tên")){
	 	return false;
	 }
	 if(!notEmpty2('cmt_email_'+comment_id,'Email',"Bạn phải nhập email"))
	 	return false;
	 if(!emailValidator('cmt_email_'+comment_id,'Email không hợp lệ')){
	 	return false;
	 }
	
	// $('#comment_reply_form_'+comment_id).submit();
	 /* stop form from submitting normally */
	// event.preventDefault();

	/* get some values from elements on the page: */
	url = $('#link_reply_form_'+comment_id).val();
	// /* Send the data using post */
	var posting = $.post( url, { 
		name: $('#cmt_name_'+comment_id).val(), 
		email: $('#cmt_email_'+comment_id).val(), 
		content: $('#cmt_content_'+comment_id).val(), 
		record_id: $('#_cmt_record_id_'+comment_id).val(), 
		parent_id: $('#parent_id_'+comment_id).val(), 
		module: $('#_cmt_module_'+comment_id).val(), 
		view: $('#_cmt_view_'.comment_id).val(), 
		"return": $('#_cmt_return_'+comment_id).val()

	} );
	var id = $('#record_id').val();
	var cmt_module = $('#_cmt_module_'+comment_id).val();
	var cmt_view = $('#_cmt_view_'+comment_id).val();
	var cmt_return = $('#_cmt_return_'+comment_id).val();
	/* Alerts the results */
	posting.done(function( data ) {
		// alert('Cảm ơn bạn đã gửi comment');
        $('html, body').animate({scrollTop:$('#_info_comment').position().top}, 'slow');
		$('#cmt_content_'+comment_id).val('');
		$("#_info_comment").load("/index.php?module=comments&view=comments&raw=1&id="+id+"&cmt_module="+cmt_module+"&cmt_view="+cmt_view+"&cmt_return="+cmt_return, {'page':0}, function() {
			// $("#1-page").addClass('active');
            Alert.render('Cảm ơn bạn đã gửi comment');
		});  //initial page number to load
	});
}
function display_hidden_comment_form(){
	$('.button_reply').click(function(){
		$(this).parent().next().removeClass('hide');
		$(this).addClass('hide');
	});
	$('.button_reply_close').click(function(){
		$(this).parent().parent().parent().parent().addClass('hide');
		$(this).parent().parent().parent().parent().prev().children('a').removeClass('hide');
	});
}