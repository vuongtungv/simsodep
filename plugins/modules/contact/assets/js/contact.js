$(document).ready( function(){
	/* FORM CONTACT */
	$('#submitbt').click(function(){
		if(checkFormsubmit())
			document.contact.submit();
	})
	$('#resetbt').click(function(){
		document.contact.reset();
	})
    //googlemap_initialize();
});
//function changeCaptcha(){
//	var date = new Date();
//	var captcha_time = date.getTime();
//	$("#imgCaptcha").attr({src:root+'libraries/jquery/ajax_captcha/create_image.php?'+captcha_time});
//}	     
function checkFormsubmit()
{
	$('label.label_error').prev().remove();
	$('label.label_error').remove();
	email_new = $('#email_new').val();
    
    
	if(!notEmpty("contact_name","Bạn chưa nhập họ và tên"))
	{
		return false;
	}
    
    if(!notEmpty("contact_email","Bạn chưa nhập Email")){
		return false;
	}
	if(!emailValidator("contact_email","Emal không đúng định dạng")){
		return false;
	}
    
    if(!notEmpty("contact_phone","Bạn chưa nhập số liên hệ"))
		return false;
	if(!isPhone("contact_phone","Bạn chưa nhập đúng định dạng"))
		return false;
	
    
    if(!notEmpty("contact_title","Bạn chưa nhập tiêu đề thông điệp")){
	   	return false;
	}
    if(!notEmpty("message","Bạn hãy nhập nội dung thông điệp")){
	   	return false;
	}
	if(!notEmpty("txtCaptcha","Nhập mã xác minh"))
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
				invalid('txtCaptcha','Captcha là không chính xác.');
				alert('Captcha is incorrect');
				console.log('--------');
				return false;
			} else {
				valid('txtCaptcha');
//				$('<br/><div class=\'label_success username_check\'>'+'Bạn đã nhập đúng mã hiển thị'+'</div>').insertAfter($('#username').parent().children(':last'));
				//$('.button_area').html('<a class="button " href="javascript: void(0)"><span>&nbsp;Send&nbsp;</span></a><a id="resetbt" class="button" href="javascript: void(0)"><span>Làm lại</span></a>');
				console.log('+++');
					document.contact.submit();
				return true;
			}
		}
	});
}

//click_view_map(1);
//function click_view_map(){
//	$('.directCallData').click(function(){
//		var add_id=$(this).attr("lang");
//		load_map(add_id);
//	});
//}
//function load_map(add_id){
//	jQuery.fn.modalBox({ 
//		directCall : {
//			data : '<iframe src="'+root+'index.php?module=contact&task=map&id='+add_id+'&raw=1" height="350" width="900">	</iframe>',
//		},
//		setWidthOfModalLayer : 1000,
//	});
//}
//configAngleNews(1);
//function configAngleNews(){
//	if($('.image-share').length){
//		$("a[rel='example3']").colorbox({transition:"none", width:"800px", height:"550px"});
//	}
//}

//function googlemap_initialize() {
//	var latitude = $('#latitude').val();
//	var longitude = $('#longitude').val();
//	var more_info = $('#more_info').html();
//	var map = new GMap2(document.getElementById("map_canvas"));
//	map.addControl(new GSmallMapControl());
//	map.addControl(new GMapTypeControl());
//	map.setCenter(new GLatLng(latitude,longitude), 13);
//
//	// Our info window content
//	var infoTabs = [
//	  new GInfoWindowTab('sd',more_info),
//	  
//	];
//
//	// Place a marker in the center of the map and open the info window
//	// automatically
//	var marker = new GMarker(map.getCenter());
//	GEvent.addListener(marker, "click", function() {
//	  marker.openInfoWindowTabsHtml(infoTabs);
//	});
//	map.addOverlay(marker);
//	marker.openInfoWindowTabsHtml(infoTabs);
//}