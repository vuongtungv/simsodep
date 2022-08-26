$('#myTab a').click(function (e) {
	 e.preventDefault();
	 $(this).tab('show');
});


// $('.right-content .pro-in-cart .delete-cart-ok').html('<img src="/templates/default/images/icon_in_cart.png" alt="" class="mCS_img_loaded">');


$(".top .icon_add-cart.add-cart img").hover(function(){
    $(this).attr('src','/templates/default/images/img_svg/sim_theo_nha_mang/content_cart_hover.svg');
}, function(){
    src = $(this).parent().attr('cart');
    if(src != 'exit_cart'){
        $(this).attr('src','/templates/default/images/img_svg/sim_theo_nha_mang/content_cart.svg');
    }
});

$(".pay_now_hover img").hover(function(){
    $(this).attr('src','/templates/default/images/img_svg/sim_theo_nha_mang/content_pay_hover.svg');
}, function(){
    $(this).attr('src','/templates/default/images/img_svg/sim_theo_nha_mang/content_pay.svg');
});