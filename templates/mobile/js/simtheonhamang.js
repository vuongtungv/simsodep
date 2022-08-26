$(document).ready(function () {
    var $i = 0;
    $(".cart-no-hover img").click(function() {
        $i++;
        if ($i % 2 != 0)
            $(".cart-no-hover img").attr('src', 'images/icon-hover-01.png');
        else {
            $(".cart-no-hover img").attr('src', 'images/icon-no-hover-01.png');
        }
    });
});
