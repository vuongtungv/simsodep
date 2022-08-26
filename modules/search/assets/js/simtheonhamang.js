$(document).ready(function () {
    // $(".cart-no-hover img").hover(function(){
    //     alert(123);
    //     $(this).attr('src', '/templates/default/images/sim_theo_nha_mang/content_cart_hover.svg');
    // }, function(){
    //     alert(456);
    //     $(this).attr('src', '/templates/default/images/sim_theo_nha_mang/content_cart.svg');
    // });
    
    
    var $i = 0;
    $(".cart-no-hover img").click(function() {
        $i++;
        if ($i % 2 != 0)
            $(".cart-no-hover img").attr('src', '/templates/default/images/sim_theo_nha_mang/content_cart_hover.svg');
        else {
            $(".cart-no-hover img").attr('src', '/templates/default/images/sim_theo_nha_mang/content_cart.svg');
        }
    });
});
