$(document).ready(function () {
    $('.pro-in-cart .delete-cart-ok').removeClass('add-cart');
    $('.left-content .delete-cart-ok').html('Xóa khỏi giỏ hàng');
    var url_root = $('#url_root').val();


    $(".top .icon_add-cart img").hover(function(){
        alert(123);
        $(this).attr('src','/templates/default/images/img_svg/sim_theo_nha_mang/content_cart_hover.svg');
    }, function(){
        src = $(this).parent().attr('cart');
        if(src != 'exit_cart'){
            $(this).attr('src','/templates/default/images/img_svg/sim_theo_nha_mang/content_cart.svg');
        }
    });


    // if($('.right-content .icon_add-cart').find(".icon_in_cart").length < 0) {
    //     $(".right-content .icon_add-cart img").hover(function(){
    //         $(this).attr('src','/templates/default/images/icon_in_cart.png');
    //     }, function(){
    //         $(this).attr('src','/templates/default/images/icon_sim.png');
    //     });
    // }

    $('.left-content .in_cart').html("Xóa khỏi giỏ hàng");
    $(".right-content .icon_in_cart img").attr("src","/templates/default/images/icon_in_cart.png");
});
