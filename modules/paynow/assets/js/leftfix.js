$(window).load(function(){	
	_sidebar = $(".left_fix");	
	if($(_sidebar).length>0){
		_window = $(window);
		sidebarTop = $(_sidebar).position().top;
		sidebarHeight = $(_sidebar).height();
		_footer = $("#block-85");
		/** Thuc thi **/
		$(_sidebar).addClass('fixed');
		$(_window).scroll(function(event) {
			footerTop = $(_footer).position().top;
			scrollTop =$(_window).scrollTop();
			topPosition = Math.max(0, sidebarTop - scrollTop);
			topPosition = Math.min(topPosition, (footerTop - scrollTop) - sidebarHeight);
			$(_sidebar).css('top', topPosition);
		});
	}
});