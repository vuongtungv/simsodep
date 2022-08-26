// var emenu = $('#menu-top').offset().top;
$(document).ready(function () {
    $click = 0;
    $he = $('.promotion-information').height();
    if($he == null){
        $he = 0;
    }

    $(window).bind('scroll', function () {
        scrollTop = $(window).scrollTop();
        $('.show-show').css('top', 549 + $he - scrollTop);
    });


    var Browser = navigator.userAgent;
    console.log(Browser);
    if (Browser.indexOf('MSIE') >= 0){
        Browser = 'MSIE';
    }
    else if (Browser.indexOf('Firefox') >= 0){
        Browser = 'Firefox';
    }
    else if (Browser.indexOf('Edge') >= 0){
        Browser = 'Edge';
    }
    else if (Browser.indexOf('coc_coc_browser') >= 0){
        Browser = 'CocCoc';
    }
    else if (Browser.indexOf('Chrome') >= 0){
        Browser = 'Chrome';
    }
    else if (Browser.indexOf('Safari') >= 0){
        Browser = 'Safari';
    }

    else if (Browser.indexOf('Opera') >= 0){
        Browser = 'Opera';
    }
    else{
        Browser = 'UNKNOWN';
    }
    // alert(Browser);
    if(Browser == 'UNKNOWN'){
        $('#search-birthday').addClass('IE-search-birthday');
    }



    $('#advanced-search').click(function () {
        $.ajax({
            type: 'POST',
            url: 'index.php?module=home&view=home&task=toggle_advanced_search&raw=1',
            success: function (data) {
                if(data==1){ // hidden advanced_search
                    $('#input_value_advanced_search').val('1');
                    // if(Browser == 'Chrome' || Browser == 'CocCoc'){
                    //     $(window).bind('scroll', function () {
                    //         scrollTop = $(window).scrollTop();
                    //         $('.show-show').css('top', 549 + $he - scrollTop);
                    //     });
                    // }else{
                    //     $(window).bind('scroll', function () {
                    //         scrollTop = $(window).scrollTop();
                    //         $('.show-show').css('top', 674 + $he - scrollTop);
                    //     });
                    // }
                    $(window).bind('scroll', function () {
                        scrollTop = $(window).scrollTop();
                        $('.show-show').css('top', 674 + $he - scrollTop);
                    });

                }else{ //show advanced_search
                    $('#input_value_advanced_search').val('0');
                    // if(Browser == 'Chrome' || Browser == 'CocCoc') {
                    //     $(window).bind('scroll', function () {
                    //         scrollTop = $(window).scrollTop();
                    //         $('.show-show').css('top', 674 + $he - scrollTop);
                    //     });
                    // }else{
                    //     $(window).bind('scroll', function () {
                    //         scrollTop = $(window).scrollTop();
                    //         $('.show-show').css('top', 549 + $he - scrollTop);
                    //     });
                    // }
                    $(window).bind('scroll', function () {
                        scrollTop = $(window).scrollTop();
                        $('.show-show').css('top', 549 + $he - scrollTop);
                    });
                }
            }
        });
        // var input_value_advanced_search = $('#input_value_advanced_search').val();
        // if(input_value_advanced_search == '1'){
        //     //hidden
        //     alert('hidden_advance');
        //     $(window).bind('scroll', function () {
        //         scrollTop = $(window).scrollTop();
        //         $('.show-show').css('top', 674 + $he - scrollTop);
        //     });
        //
        // }
        // if(input_value_advanced_search == '0'){
        //     alert('show_advance');
        //     // show
        //     $(window).bind('scroll', function () {
        //         scrollTop = $(window).scrollTop();
        //         $('.show-show').css('top', 549 + $he - scrollTop);
        //     });
        // }
    });

    $( ".list-sim .add-cart" ).hover(
        function() {
            $( this ).find('.img-no-hover').attr('src','/templates/default/images/img_svg/sim_theo_nha_mang/content_cart_hover.svg');
        }, function() {
            $( this ).find('.img-no-hover').attr('src','/templates/default/images/img_svg/sim_theo_nha_mang/content_cart.svg');
        }
    );
    // $( ".right-content .add-cart" ).hover(
    //     function() {
    //         $( this ).find('img').attr('src','/templates/default/images/icon_in_cart.png');
    //     }, function() {
    //         $( this ).find('img').attr('src','/templates/default/images/icon_sim.png');
    //     }
    // );


    // js đổ nền menu home no_scrool
    $( "#menu-top .first_li").hover(
        function() {
            $('.hover-opa .menu_opacity').css('display','block');
            $('#menu-top').addClass('bg-show');
        }, function() {
            $('.hover-opa .menu_opacity').css('display','none');
            $('#menu-top').removeClass('bg-show');
        }    
    );


});
