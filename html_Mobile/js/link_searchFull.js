$(document).ready(function () {
    var click = 0;
    var $height = document.body.clientHeight-183;
    $('.form-search').on("click",function () {
        click++;
        if(click %2 != 0){
            $('.click_search').css('display','none');
            $('.input_search').css('display','block');
            $('.icon_back').css('display','block');
            $('.help-onl').css('display','block');
            $('.menu-icon').css('display','none');
            $('.dots-icon').css('display','none');
            $('.cart-icon').css('display','none');
            $('.menu-top').addClass('full-search');
            $("#bg-opacity").addClass('bg-opacity');
            $('.menu-top .logo-menu').css('display','none');
            $('.menu-top .search-icon').css('width', '656px');
            $('head').append('<style>.bg-opacity:after{height: ' + $height + 'px;}</style>');
            $('.search-icon .form-search-full').slideDown('300');  
        }
        // else{
        //     $('.dots-icon').fadeIn('slow');
        //     $('.cart-icon').fadeIn('slow');
        //     $('.help-onl').fadeOut('slow');
        //     $('.menu-icon').fadeIn('slow');
        //     $('.icon_back').fadeOut('slow');
        //     $('.input_search').slideUp('slow');
        //     $('.click_search').slideDown('slow');
        //     $('.menu-top').removeClass('full-search');
        //     $('.search-icon .form-search-full').slideUp('slow');
        // }
    });





    $(".select_1").on("click", function (e) {
        $(".select_2 .options").slideUp('slow');
        $(".select_3 .options").slideUp('slow');
        $(".select_1 .options").slideToggle('slow');
        e.stopPropagation()
    });
    $(".select_1 .option").on("click", function () {
        $("#selected_1").attr("value", $(this).attr("value"));
        $(".value_1").text($(this).text());
        $(".select_1 .options").css('display', 'none !important');
    });
    $(".select_2").on("click", function (e) {
        $(".select_1 .options").slideUp('slow');
        $(".select_3 .options").slideUp('slow');
        $(".select_2 .options").slideToggle('slow');
        e.stopPropagation();
    });
    $(".select_2 .option").on("click", function () {
        $("#selected_2").attr("value", $(this).attr("value"));
        $(".value_2").text($(this).text());
        $(".select_2 .options").css('display', 'none !important');
    });
    $(".select_3").on("click", function (e) {
        $(".select_1 .options").slideUp('slow');
        $(".select_2 .options").slideUp('slow');
        $(".select_3 .options").slideToggle('slow');
        e.stopPropagation();
    });
    $(".select_3 .option").on("click", function () {
        $("#selected_3").attr("value", $(this).attr("value"));
        $(".value_3").text($(this).text());
        $(".select_3 .options").css('display', 'none !important');
    });


    $("#id-help").on("click", function () {
        $("#show-help").slideToggle(300);
    });

});