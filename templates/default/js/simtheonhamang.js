$(document).ready(function () {
    var $i = 0;
    $(".cart-no-hover img").click(function() {
        $i++;
        if ($i % 2 != 0)
            $(".cart-no-hover img").attr('src', '/templates/default/images/img_svg/sim_theo_nha_mang/content_cart_hover.svg');
        else {
            $(".cart-no-hover img").attr('src', '/templates/default/images/img_svg/sim_theo_nha_mang/content_cart.svg');
        }
    });
});
