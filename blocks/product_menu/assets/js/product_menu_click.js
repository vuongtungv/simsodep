$(document).ready(function(){
	click_menu();
});	

function click_menu(){
	$('.h2_0').click(function(){
		var wrapper_child = $(this).next('ul');
		if(wrapper_child.hasClass('hiden')){
			wrapper_child.removeClass('hiden');
		}else{
			wrapper_child.addClass('hiden');
		}

	});
}
