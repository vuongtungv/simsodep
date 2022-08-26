$(document).ready(function($){
//	$('#megamenu').dcMegaMenu({
//		rowItems: '3',
//		speed: '1'
//	});
// 	pos_right_megamenu = $('#megamenu').offset().left+$('#megamenu').width();
// 	padding = 20;
// 	$('#megamenu .level_0').mouseover(function(){
// 		$(this).addClass('hover');
// 		e_left =  $(this).offset().left;
// 		hightlight_child = $(this).find('.highlight');
// 		if(hightlight_child){
// 			e_width =  hightlight_child.width();
// 			if((e_left + e_width ) < pos_right_megamenu ){
// 				hightlight_child.css('left',-150);
// 			}else{
// 				chil_left =  0 - e_left -  e_width + pos_right_megamenu - padding;
// 				hightlight_child.css('left',chil_left);
// 			}
// 		}
//
// 		$(this).find('.highlight').show();
//
// 	}).mouseout(function(){
// 		$(this).removeClass('hover');
// 		$(this).find('.highlight').hide();
// 	});


});

// $('.sub-menu-level2').hover(function () {
//     var height_lev = $(this).find('.level-4').height();
//     // var height_lev = $('.level-4').height();
//     $(this).css('height',height_lev);
// });


// $('.sub-menu-level1').hover(function () {
// 	$('.sub-menu-level2').hover(function () {
// 		var hi = $(this).find('.level-4').height();
// 		$(this).css('height',hi);
//     });
// });


$(".sub-menu-level1").hover(function(){
    $(this).find('.level-3').addClass('childen-he');
    // var he = $('.childen-he .sub-menu-level2').eq('0').height();
    // var he1 = $('.childen-he .sub-menu-level2').eq('1').height();
    $('.childen-he .sub-menu-level2').eq('0').addClass('st1');
    $('.childen-he .sub-menu-level2').eq('1').addClass('st2');
    var he = $('.st1 .level-4').height();
    var he1 = $('.st2 .level-4').height();
    // var he = $(this).find('.st1').height();
    // var he1 = $(this).find('.st2').height();
    $('.childen-he .sub-menu-level2').eq('0').css('height', he+25);
    $('.childen-he .sub-menu-level2').eq('1').css('height', he1+25);
    $(this).find('.level-3').css('height',he+he1+76);
}, function(){
    $('.childen-he .sub-menu-level2').eq('0').removeClass('st1');
    $('.childen-he .sub-menu-level2').eq('1').removeClass('st2');
    $(this).find('.level-3').removeClass('childen-he');
});

// $('.sub-menu-level1').hover(function () {
//     $(this).find('.level-3').addClass('childen-he');
//     var he = $('.childen-he .sub-menu-level2').eq('0').height();
//     var he1 = $('.childen-he .sub-menu-level2').eq('1').height();
//     $(this).find('.level-3').css('height',he+he1+71);
// });


