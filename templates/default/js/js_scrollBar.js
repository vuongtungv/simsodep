(function($){
    $(window).on("load",function(){

        $(".scroll-y").mCustomScrollbar({
            setHeight:300,
            theme:"dark-3"
        });
    });
})(jQuery);




    var emenu = $('#menu-top').offset().top;

    $(window).bind('scroll', function () {
        var scrollTop = $(window).scrollTop();
        // console.log(scrollTop);
        if(scrollTop>emenu+50){
            $('.warp-scroll').addClass('css_fix_top_menu');
        }else{
            $('.warp-scroll').removeClass('css_fix_top_menu');
        }
    });




    $('.dot-scroll').on('click',function () {
        $('.show-menu-scroll').toggle(300);
    });


    $(".show-menu-scroll").hover(function(){
        $('#oe_overlay_2').addClass('oe_overlay');
        $('#oe_overlay').addClass('oe_overlay');
    }, function(){
        $('#oe_overlay_2').removeClass('oe_overlay');
        $('#oe_overlay').removeClass('oe_overlay');
    });


