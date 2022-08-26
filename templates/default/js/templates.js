
$(function(){
    // bind change event to select
    $('.select_location').on('change', function () {
        var url = $(this).val(); // get selected value
        if (url) { // require a URL
            window.location = url; // redirect
        }
        return false;
    }); 

    $('.check-filter').on('click', function () {
        var url = $(this).attr('data'); // get selected value
        if (url) { // require a URL
            window.location = url; // redirect
        }
        return false;
    });

  });

function update_cart(sim,id,price,network,cat,point,button,url) {
    root = $('#root').val();
    $.ajax({
        async: true,
        url: root+"index.php?module=home&view=home&task=update_cart&raw=1",
        data: {id:id, sim:sim, price:price, network:network, cat:cat, point:point, button:button}
    });
// window.location=url;
}

function action_cart(sim,id,price,network,cat,point,button,el) {
    root = $('#root').val();
    cart = $(el).attr("cart");
    type = $(el).attr("type");
    if (type == 'list') {
        if (cart == 'no_cart') {
            alert("Thêm vào giỏ hàng thành công.");
            $(el).attr("cart","exit_cart");
            $(el).attr("title","Xóa khỏi giỏ hàng");
            $(el).children().attr("src",root+"templates/default/images/img_svg/sim_theo_nha_mang/content_cart_hover.svg");
        }else{
            alert("Xóa khỏi giỏ hàng.");
            $(el).attr("cart","no_cart");
            $(el).attr("title","Thêm vào giỏ hàng");
            $(el).children().attr("src",root+"templates/default/images/img_svg/sim_theo_nha_mang/content_cart.svg");
        }
    }
    if (type == 'block2') {
        if (cart == 'no_cart') {
            alert("Thêm vào giỏ hàng thành công.");
            $(el).attr("cart","exit_cart");
            $(el).attr("title","Xóa khỏi giỏ hàng");
            $(el).children().attr("src",root+"templates/default/images/img_svg/sim_theo_nha_mang/content_cart_hover.svg");
        }else{
            alert("Xóa khỏi giỏ hàng.");
            $(el).attr("cart","no_cart");
            $(el).attr("title","Thêm vào giỏ hàng");
            $(el).children().attr("src",root+"templates/default/images/img_svg/sim_theo_nha_mang/content_cart.svg");
        }
    }
    if (type == 'block1') {
        if (cart == 'no_cart') {
            alert("Thêm vào giỏ hàng thành công.");
            $(el).attr("cart","exit_cart");
            $(el).attr("title","Xóa khỏi giỏ hàng");
            $(el).html("Xóa khỏi giỏ hàng");
        }else{
            alert("Xóa khỏi giỏ hàng.");
            $(el).attr("cart","no_cart");
            $(el).attr("title","Thêm vào giỏ hàng");
            $(el).html("Thêm vào giỏ hàng");
        }
    }
    root = $('#root').val();
    $.ajax({
        async: true,
        url: root+"index.php?module=home&view=home&task=action_cart&raw=1",
        data: {id:id, sim:sim, price:price, network:network, cat:cat, point:point, button:button},
        dataType: "json",
            success: function (result) {
                $('.icon-cart span').show();
                $('.icon-cart span').html(result.quantity);
                $('#scroll_cart').html(result.quantity);
                $('.table-cart tbody').html(result.list);
                $('#total_cart').html(result.total);
            }
    });
}

function buy_cart(sim,id,price,network,cat,point,button,el) {
    alert("Thêm vào giỏ hàng thành công.");
    root = $('#root').val();
    $(el).children().attr("src",root+"templates/default/images/img_svg/sim_theo_nha_mang/content_cart_hover.svg");
    $(el).attr("title","Xóa khỏi giỏ hàng");
    $.ajax({
        async: true,
        url: root+"index.php?module=home&view=home&task=buy_cart&raw=1",
        data: {id:id, sim:sim, price:price, network:network, cat:cat, point:point, button:button}
    });
}

function delete_cart(sim,el) {
    alert("Xóa sim khỏi giỏ hàng thành công.");
    root = $('#root').val();
    $(el).children().attr("src",root+"templates/default/images/img_svg/sim_theo_nha_mang/content_cart.svg");
    $(el).attr("title","Thêm vào giỏ hàng");
    $.ajax({
        async: true,
        url: root+"index.php?module=home&view=home&task=delete_cart&raw=1",
        data: {sim:sim}
    });
}

$(document).ready(function () {

    $('[data-toggle="tooltip"]').tooltip();

        $(".shopcart").click(function (e) {
        $(".show-cart").toggle(300)     ;
        $('.show-show').hide(300);
        $('.select-prices .options').hide(300);
        $('.ver2').hide(300);
        $('#search-guide').css('display','none');
        if ( !$(e.target).hasClass('show-cart')) {
            $(".form_wrapper").hide();
        }
        e.stopPropagation();
    });
    $(document).click(function(e) {
        $('.show-cart').hide('300');
        e.stopPropagation();
    });

    // choose nhà mạng
    $(".select-options").click(function(e) {
        $(".select-prices .options").hide();
        $(".select-type .options").hide();
        $(".show-show").css('display','none');
        $('.ver2').hide(300);
        $(".show-cart").hide();
        $('#search-guide').hide();
        $(".sim-name .options").hide();
        $('.quick-net .options').hide();
        $('.quick-first .options').hide();

        $(".select-options .options").toggle('300');
        e.stopPropagation();
    });
    $(".select-options .option").on("click", function () {
        $("#selected-value").attr("value", $(this).attr("value"));
        $(".value").text($(this).text());

        $(".select-options .options").css('display', 'none !important');
        check_active();
    });
    $(document).click(function(e) {
        $('.select-options .options').hide('300');
        e.stopPropagation();
    });


    // Choose Price
    $(".select-prices").click(function(e) {
        $('.select-options .options').hide();
        $(".select-type .options").hide();
        $(".show-show").css('display','none');
        $(".show-cart").hide();
        $('#search-guide').hide();
        $(".sim-name .options").hide();
        $('.quick-net .options').hide();
        $('.quick-first .options').hide();
        $('.ver2').hide(300);

        $(".select-prices .options").toggle('300');
        e.stopPropagation();
        // var icon = $(this).find("i");
        // icon.toggleClass("glyphicon-chevron-down glyphicon-chevron-up");
    });
    $(".select-prices .option").click(function(e) {
        $("#selected-price").attr("value", $(this).attr("value"));
        $(".value-price").text($(this).text());
        $('.img_search_ic').attr('src','/templates/default/images/icon_search_hover.png');
        $('#submit_search i').css('color','#3478f7 ');
        $(".select-prices .options").css('display', 'none !important');
    });
    $(document).click(function(e) {
        $('.select-prices .options').hide('300');
        e.stopPropagation();
    });


    // sim type
    $cl = 0 ;
    $(".select-type").on("click", function (e) {
        $cl++;
        $(".show-show").css('display','none');
        $('.ver2').hide(300);
        $('.select-options .options').hide();
        $(".select-prices .options").hide();
        $(".show-cart").hide();
        $('#search-guide').hide();
        $(".sim-name .options").hide();
        $('.quick-net .options').hide();
        $('.quick-first .options').hide();
        if($cl %2 != 0){
            // $(".select-type .ver2").css('display','block');
            $("#options_choose_type").addClass('show-op');
            $('.ver2').show(300);
        }
        else{
            // $(".select-type .ver2").hide('display','none !important');
            $("#options_choose_type").addClass('show-op');
            $('.ver2').hide(300);
        }



        // $('.ver2').toggle(300);



        e.stopPropagation();
        // var icon = $(this).find("i");
        // icon.toggleClass("glyphicon-chevron-down glyphicon-chevron-up");
    });
    $( "body").mousedown(function( e ) {
        // var ele = event.target.className;
        var ele = event.target.className || event.target.id;
        if(ele !='option' && ele !='mCustomScrollBox mCS-dark-3 mCSB_vertical mCSB_inside' && ele !='mCSB_dragger' && ele != 'mCSB_dragger_bar' && ele !='mCSB_draggerRail' && ele !='mCSB_draggerContainer' && ele !=''){
            // $("#options_choose_type").css('display','none');
            $('.ver2.options').hide('300');
        }
    });
    $(".ver2 .option").on("click", function () {
        // $('.select-type .options').removeClass('abc');
        $("#selected-type").attr("value", $(this).attr("value"));
        $(".value-type").text($(this).text());

        $("#options_choose_type").css('display','none');

        check_active();
    });







    // Hiển thị gợi í khi search
    $click = 0;
    $("#text-search").on("click",function (e) {
        $click++;
        $('#options_choose_type').hide();
        // $("#search-guide").css("display", "block");
        $('.select-options .options').hide();
        $(".select-prices .options").hide();
        $(".select-type .options").hide();
        $(".show-cart").hide();
        $(".sim-name .options").hide();
        $('.quick-net .options').hide();
        $('.quick-first .options').hide();
        $('#submit_search i').css('color','#3478f7 ');

        if($click %2 !=0){
            $('html, body').animate({scrollTop:296}, 'slow');
            $("#search-guide").show('300');
            $('.show-show').css('display', 'block');
            // $(window).bind('scroll', function () {
            //     scrollTop = $(window).scrollTop();
            //     $('.show-show').css('top', 593 - scrollTop);
            // });
        }
        else{
            $('html, body').animate({scrollTop:298}, 'slow');
            $("#search-guide").hide('300');
            $('.show-show').css('display', 'none');
        }

        e.stopPropagation();
    });
    $(document).click(function(e) {
        $('#search-guide').hide('300');
        $('.show-show').css('display', 'none');
        $('#submit_search i').css('color','#888888');
        e.stopPropagation();
    });

    // close-promotion top
    $(".close-promo").click(function () {
        $('.promotion-information').hide('300');
    });


    $('.text-search').on('keyup',function () {
        $text = $('.text-search').val();
        $('#text_sea').val($text);
        check_active();
    });
    $('#to_price').on('keyup',function () {
        $to_price = $('#to_price').val();
        $('#text_to_price').val($to_price);
        check_active();
    });


    $('#form_price').on('keyup',function () {
        $form_price = $('#form_price').val();
        $('#text_form_price').val($form_price);
        check_active();
    });




    // day month year 2
    $sd2 = 0;
    $(".select-day-2").on("click", function (e) {
        $sd2++;
        $(".ver5").hide('300');
        $(".ver6").hide('300');


        $('.select-year-2 .date-x').attr('src','/templates/default/images/img_svg/trangchu/down_menu.svg');
        $('.select-month-2 .date-x').attr('src','/templates/default/images/img_svg/trangchu/down_menu.svg');
        if($sd2 %2 !=0){
            $(".ver4.options").show('300');
            $(this).find('.date-x').attr('src','/templates/default/images/img_svg/thanh_toan/delete.svg')
        }else{
            $(".ver4.options").hide('300');
            $(this).find('.date-x').attr('src','/templates/default/images/img_svg/trangchu/down_menu.svg')
        }
        e.stopPropagation();
        // var icon = $(".select-dropdown-icon i");
        // icon.removeClass("fa fa-angle-down");
        // icon.addClass("fa fa-times");
    });
    $( "body").mousedown(function( e ) {
        // var ele = event.target.className;
        var ele = event.target.className || event.target.id;
        if(ele !='option' && ele !='mCustomScrollBox mCS-dark-3 mCSB_vertical mCSB_inside' && ele !='mCSB_dragger' && ele != 'mCSB_dragger_bar' && ele !='mCSB_draggerRail' && ele !='mCSB_draggerContainer' && ele !=''){
            $('.ver4.options').hide('300');
            $('.select-day-2 .date-x').attr('src','/templates/default/images/img_svg/trangchu/down_menu.svg');
            $('.select-year-2 .date-x').attr('src','/templates/default/images/img_svg/trangchu/down_menu.svg');
            $('.select-month-2 .date-x').attr('src','/templates/default/images/img_svg/trangchu/down_menu.svg');
        }
    });
    $(".ver4 .option").on("click", function () {
        $("#selected-day-2").attr("value", $(this).attr("value"));
        $(".value-day-2").text($(this).text());
        $(".ver4").css('display', 'none');

        $('.select-day-2 .date-x').attr('src','/templates/default/images/img_svg/trangchu/down_menu.svg');
        $('.select-year-2 .date-x').attr('src','/templates/default/images/img_svg/trangchu/down_menu.svg');
        $('.select-month-2 .date-x').attr('src','/templates/default/images/img_svg/trangchu/down_menu.svg');
    });
    // $(document).click(function(e) {
    //     $('.select-day-2 .options').hide('300');
    //     $('.select-day-2 .date-x').attr('src','/templates/default/images/down_pro.png');
    //     $('.select-year-2 .date-x').attr('src','/templates/default/images/down_pro.png');
    //     $('.select-month-2 .date-x').attr('src','/templates/default/images/down_pro.png');
    //     e.stopPropagation();
    // });

    $sm2 = 0;
    $(".select-month-2").on("click", function (e) {
        $sm2++;
        $(".ver4").hide('300');
        $(".ver6").hide('300');


        $('.select-day-2 .date-x').attr('src','/templates/default/images/img_svg/trangchu/down_menu.svg');
        $('.select-year-2 .date-x').attr('src','/templates/default/images/img_svg/trangchu/down_menu.svg');
        if($sm2 %2 !=0){
            $(".ver5").show('300');
            $(this).find('.date-x').attr('src','/templates/default/images/img_svg/thanh_toan/delete.svg')
        }else{
            $(".ver5").hide('300');
            $(this).find('.date-x').attr('src','/templates/default/images/img_svg/trangchu/down_menu.svg')
        }
        e.stopPropagation();
    });
    $( "body").mousedown(function( e ) {
        // var ele = event.target.className;
        var ele = event.target.className || event.target.id;
        if(ele !='option' && ele !='mCustomScrollBox mCS-dark-3 mCSB_vertical mCSB_inside' && ele !='mCSB_dragger' && ele != 'mCSB_dragger_bar' && ele !='mCSB_draggerRail' && ele !='mCSB_draggerContainer' && ele !=''){
            $('.ver5.options').hide('300');
            $('.select-day-2 .date-x').attr('src','/templates/default/images/img_svg/trangchu/down_menu.svg');
            $('.select-year-2 .date-x').attr('src','/templates/default/images/img_svg/trangchu/down_menu.svg');
            $('.select-month-2 .date-x').attr('src','/templates/default/images/img_svg/trangchu/down_menu.svg');
        }
    });
    $(".ver5 .option").on("click", function () {
        $("#selected-month-2").attr("value", $(this).attr("value"));
        $(".value-month-2").text($(this).text());
        $(".ver5.options").css('display', 'none');
        $('.select-day-2 .date-x').attr('src','/templates/default/images/img_svg/trangchu/down_menu.svg');
        $('.select-year-2 .date-x').attr('src','/templates/default/images/img_svg/trangchu/down_menu.svg');
        $('.select-month-2 .date-x').attr('src','/templates/default/images/img_svg/trangchu/down_menu.svg');
    });
    // $(document).click(function(e) {
    //     $('.select-month-2 .options').hide('300');
    //
    //     $('.select-month-2 .date-x').attr('src','/templates/default/images/down_pro.png');
    //     $('.select-day-2 .date-x').attr('src','/templates/default/images/down_pro.png');
    //     $('.select-year-2 .date-x').attr('src','/templates/default/images/down_pro.png');
    //     e.stopPropagation();
    // });
    $sy2=0;
    $(".select-year-2").on("click", function (e) {
        $sy2++;
        $(".ver4").hide('300');
        $(".ver5.options").hide('300');


        $('.select-day-2 .date-x').attr('src','/templates/default/images/img_svg/trangchu/down_menu.svg');
        $('.select-month-2 .date-x').attr('src','/templates/default/images/img_svg/trangchu/down_menu.svg');
        if($sy2 %2 !=0){
            $(".ver6.options").show('300');
            $(this).find('.date-x').attr('src','/templates/default/images/img_svg/thanh_toan/delete.svg')
        }else{
            $(".ver6.options").hide('300');
            $(this).find('.date-x').attr('src','/templates/default/images/img_svg/trangchu/down_menu.svg')
        }
        e.stopPropagation();
        // var icon = $(".select-dropdown-icon i");
        // icon.removeClass("fa fa-angle-down");
        // icon.addClass("fa fa-times");
    });
    $( "body").mousedown(function( e ) {
        // var ele = event.target.className;
        var ele = event.target.className || event.target.id;
        if(ele !='option' && ele !='mCustomScrollBox mCS-dark-3 mCSB_vertical mCSB_inside' && ele !='mCSB_dragger' && ele != 'mCSB_dragger_bar' && ele !='mCSB_draggerRail' && ele !='mCSB_draggerContainer' && ele !=''){
            $('.ver6.options').hide('300');
            $('.select-day-2 .date-x').attr('src','/templates/default/images/img_svg/trangchu/down_menu.svg');
            $('.select-year-2 .date-x').attr('src','/templates/default/images/img_svg/trangchu/down_menu.svg');
            $('.select-month-2 .date-x').attr('src','/templates/default/images/img_svg/trangchu/down_menu.svg');
        }
    });
    $(".ver6 .option").on("click", function () {
        $("#selected-year-2").attr("value", $(this).attr("value"));
        $(".value-year-2").text($(this).text());
        $(".ver6").css('display', 'none');

        $('.select-day-2 .date-x').attr('src','/templates/default/images/img_svg/trangchu/down_menu.svg');
        $('.select-year-2 .date-x').attr('src','/templates/default/images/img_svg/trangchu/down_menu.svg');
        $('.select-month-2 .date-x').attr('src','/templates/default/images/img_svg/trangchu/down_menu.svg');
    });
    // $(document).click(function(e) {
    //     $('.select-year-2 .options').hide('300');
    //     $('.select-day-2 .date-x').attr('src','/templates/default/images/down_pro.png');
    //     $('.select-year-2 .date-x').attr('src','/templates/default/images/down_pro.png');
    //     $('.select-month-2 .date-x').attr('src','/templates/default/images/down_pro.png');
    //     e.stopPropagation();
    // });


    // Tìm kiếm nhanh
    $(".quick-net").on("click", function (e) {
        $('.select-options .options').hide();
        $(".select-prices .options").hide();
        $(".select-type .options").hide();
        $(".show-cart").hide();
        $('#search-guide').hide();
        $(".sim-name .options").hide();
        $('.quick-first .options').hide();
        $(".quick-net .options").toggle('300');
        var icon = $(this).find("i");
        icon.toggleClass("fa-angle-down fa-times");
        e.stopPropagation();
    });
    $(".quick-net .option").on("click", function () {
        $("#quicked-net").attr("value", $(this).attr("value"));
        $(".value-quick-net").text($(this).text());
        $(".quick-net .options").css('display', 'none !important');
    });
    $(document).click(function(e) {
        $('.quick-net .options').hide('300');
        var icon = $('.quick-net').find("i");
        icon.removeClass('fa-times');
        icon.addClass('fa-angle-down');
        e.stopPropagation();
    });
    $(".quick-first").on("click", function (e) {
        $('.select-options .options').hide();
        $(".select-prices .options").hide();
        $(".select-type .options").hide();
        $(".show-cart").hide();
        $('#search-guide').hide();
        $(".sim-name .options").hide();
        $('.quick-net .options').hide();
        $(".quick-first .options").toggle('300');
        var icon = $(this).find("i");
        icon.toggleClass("fa-angle-down fa-times");
        e.stopPropagation();
    });
    $(".quick-first .option").on("click", function () {
        $("#quicked-first").attr("value", $(this).attr("value"));
        $(".value-quick-first").text($(this).text());
        $(".quick-first .options").css('display', 'none !important');
    });
    $(document).click(function(e) {
        $('.quick-first .options').hide('300');
        var icon = $('.quick-first').find("i");
        icon.removeClass('fa-times');
        icon.addClass('fa-angle-down');
        e.stopPropagation();
    });
    $(".select-paymethod").on("click", function (e) {
        $(".select-paymethod .options").toggle('300');
        e.stopPropagation();
        // var icon = $(this).find("i");
        // icon.toggleClass("fa-angle-down fa-times");
    });
    $(".select-paymethod .option").on("click", function () {
        $("#selected-paymethod").attr("value", $(this).attr("value"));
        $(".value-paymethod").text($(this).text());
        $(".select-paymethod .options").css('display', 'none !important');
    });
    $(document).click(function(e) {
        $('.select-paymethod .options').hide('300');
        e.stopPropagation();
    });


    // choose phân trang
    $(".show-pagination .show-value").on("click", function (e) {

        hidden_ds_in_sim();

        $(".show-pagination .options").toggle('300');
        e.stopPropagation();
        var icon = $(this).find("i");
        icon.toggleClass("fa-angle-down fa-times-x");
    });
    $(".show-pagination .option").on("click", function () {
        $("#selected-pagination").attr("value", $(this).attr("value"));
        $(".value-pagination").text($(this).text());
        $(".show-pagination .options").css('display', 'none !important');
    });
    $(document).click(function(e) {
        $('.show-pagination .options').hide('300');
        $('.show-pagination i').removeClass('fa-times-x');
        $('.show-pagination i').addClass('fa-angle-down');
        // icon.removeClass("fa-times-x");
        // icon.addClass("fa-angle-down");
        e.stopPropagation();
    });



    // select trong dnah sách sim

    $(".show-sim-head .show-value").on("click", function (e) {
        $(".show-sim-head .options").toggle('300');

        $(".show-sim-type .img_dotss").removeClass('close-x-dots');
        $(".show-sim-price .img_dotss").removeClass('close-x-dots');
        $(".selected-network-sim .img_dotss").removeClass('close-x-dots');

        $('.show-pagination .options').hide('300');
        $('.show-pagination .show-value i').removeClass('fa-times-x');
        $('.show-pagination .show-value i').addClass('fa-angle-down');


        $(".selected-network-sim .options").hide('300');
        $(".show-sim-type .options").hide('300');
        $(".show-sim-price .options").hide('300');
        var icon = $(this).find(".img_dotss");
        icon.toggleClass("close-x-dots");



        e.stopPropagation();
    });
    // $(document).click(function(e) {
    //     $('.show-sim-head .options').hide('300');
    //     $(".show-sim-type .img_dotss").removeClass('close-x-dots');
    //     $(".show-sim-head .img_dotss").removeClass('close-x-dots');
    //     $(".show-sim-price .img_dotss").removeClass('close-x-dots');
    //     $(".selected-network-sim .img_dotss").removeClass('close-x-dots');
    //     e.stopPropagation();
    // });

    $(".show-sim-price .show-value").on("click", function (e) {
        $(".show-sim-price .options").toggle('300');

        $(".show-sim-type .img_dotss").removeClass('close-x-dots');
        $(".show-sim-head .img_dotss").removeClass('close-x-dots');
        $(".selected-network-sim .img_dotss").removeClass('close-x-dots');

        $('.show-pagination .options').hide('300');
        $('.show-pagination .show-value i').removeClass('fa-times-x');
        $('.show-pagination .show-value i').addClass('fa-angle-down');

        $(".selected-network-sim .options").hide('300');
        $(".show-sim-type .options").hide('300');
        $(".show-sim-head .options").hide('300');
        var icon = $(this).find(".img_dotss");
        icon.toggleClass("close-x-dots");
        e.stopPropagation();
    });
    // $(".show-sim-price .show-value span .fa.fa-times").on("click", function () {
    //     $(".show-sim-price .options").hide('300');
    // });
    // $(document).click(function(e) {
    //     $('.show-sim-price .options').hide('300');
    //     $(".show-sim-type .img_dotss").removeClass('close-x-dots');
    //     $(".show-sim-head .img_dotss").removeClass('close-x-dots');
    //     $(".show-sim-price .img_dotss").removeClass('close-x-dots');
    //     $(".selected-network-sim .img_dotss").removeClass('close-x-dots');
    //     e.stopPropagation();
    // });


    $sst = 0;
    $(".show-sim-type .show-value").click(function (e) {
        // $sst++;
        // var icon = $(this).find(".img_dotss");
        // if($sst%2 !=0){
        //     $(".show-sim-type .options").show('300');
        //     // $(this).find(".img_dotss").addClass('close-x-dots');
        //     icon.addClass('close-x-dots');
        // }else{
        //     $(".show-sim-type .options").hide('300');
        //     // $(this).find(".img_dotss").removeClass('close-x-dots');
        //     icon.removeClass('close-x-dots');
        // }
        $(".show-sim-type .options").toggle('300');

        $(".show-sim-head .img_dotss").removeClass('close-x-dots');
        $(".show-sim-price .img_dotss").removeClass('close-x-dots');
        $(".selected-network-sim .img_dotss").removeClass('close-x-dots');

        $('.show-pagination .options').hide('300');
        $('.show-pagination .show-value i').removeClass('fa-times-x');
        $('.show-pagination .show-value i').addClass('fa-angle-down');

        $(".selected-network-sim .options").hide('300');
        $(".show-sim-head .options").hide('300');
        $(".show-sim-price .options").hide('300');

        var icon = $(this).find(".img_dotss");
        icon.toggleClass("close-x-dots");
        e.stopPropagation();
    });


    $(".selected-network-sim .show-value").on("click", function (e) {
        $(".show-sim-type .options").hide('300');



        $(".show-sim-type .img_dotss").removeClass('close-x-dots');
        $(".show-sim-head .img_dotss").removeClass('close-x-dots');
        $(".show-sim-price .img_dotss").removeClass('close-x-dots');

        $('.show-pagination .options').hide('300');
        $('.show-pagination .show-value i').removeClass('fa-times-x');
        $('.show-pagination .show-value i').addClass('fa-angle-down');

        $(".selected-network-sim .options").toggle('300');
        $(".show-sim-head .options").hide('300');
        $(".show-sim-price .options").hide('300');
        var icon = $(this).find(".img_dotss");
        icon.toggleClass("close-x-dots");
        e.stopPropagation();
    });
    // $(".selected-network-sim .show-value span .fa.fa-times").on("click", function () {
    //     $(".selected-network-sim .options").hide('300');
    // });
    // $(document).click(function(e) {
    //     $('.selected-network-sim .options').hide('300');
    //     $(".show-sim-type .img_dotss").removeClass('close-x-dots');
    //     $(".show-sim-head .img_dotss").removeClass('close-x-dots');
    //     $(".show-sim-price .img_dotss").removeClass('close-x-dots');
    //     $(".selected-network-sim .img_dotss").removeClass('close-x-dots');
    //     e.stopPropagation();
    // });
    $(document).mousedown(function( e ) {
        // var ele = event.target.className;
        var ele = event.target.className || event.target.id;
        // alert(ele);
        // if(ele == ''){
        //
        // }
        if(ele =='container breadcrumb breadcrumb-link' || ele =='opacity-body' || ele =='height-scroll' || ele =='title' || ele =='reviews-sim' || ele =='container list-sim' || (ele !='p-dots' && ele =='' && ele !='options' && ele !='mCustomScrollbar' && ele !='option' && ele !='mCustomScrollBox mCS-dark-3 mCSB_vertical mCSB_inside' && ele !='mCSB_dragger' && ele != 'mCSB_dragger_bar' && ele !='mCSB_draggerRail' && ele !='mCSB_draggerContainer')){
            hidden_ds_in_sim();
        }
    });
    function hidden_ds_in_sim(){
        $('.show-sim-head .options').hide('300');
        $('.show-sim-price .options').hide('300');
        $('.selected-network-sim .options').hide('300');
        $('.show-sim-type .options').hide('300');

        $(".show-sim-type .img_dotss").removeClass('close-x-dots');
        $(".show-sim-head .img_dotss").removeClass('close-x-dots');
        $(".show-sim-price .img_dotss").removeClass('close-x-dots');
        $(".selected-network-sim .img_dotss").removeClass('close-x-dots');
    }


    // Ký gửi sim
    $(".show-hover .input-text").click(function () {
        // $(".show-hover .input-text").css('margin-bottom', '11px');
        $(".box-hover").toggle('500');
        $(document).mouseup(function (e){

            var container = $("#YOUR_TARGETED_ELEMENT_ID");

            if (!container.is(e.target) && container.has(e.target).length === 0){

                container.fadeOut();

            }
        });
    });








    // Hiển thị tìm kiếm nâng cao
    var advanced_search =0;
    $("#advanced-search").on("click",function () {
        // $("#search-guide").css("display", "block");
        advanced_search+=1;
        if(advanced_search %2 != 0){
            $(".search_bg-lv5").slideDown('300');
        }else{
            $(".search_bg-lv5").slideUp('300');

        }
    });



    // $.ajax(
    //
    // );
    // var select_options = $('#selected-value').val();
    // var select_type = $('#selected-type').val();
    // var selected_price = $('#selected-price').val();
    // var text_search = $('#text-search').val();
    // var total_button_sim = $('#total-button-sim').val();
    // var total_score_sim = $('#total-score-sim').val();
    // if(select_options !='' || select_type !='' || selected_price !='' || text_search!='' || total_button_sim !='' || total_score_sim !=''){
    //     $('#submit_search i').css('color','#3478f7 ');
    // }

    $("#total-button-sim").on("keyup",function(){
        var value= $(this).val();
        $('#in_nut').val(value);
        check_active();
    });
    $("#total-score-sim").on("keyup",function(){
        var value= $(this).val();
        $('#in_diem').val(value);
        check_active();
    });

    var $checkPrice = 0;
    $(".search_bg-lv4 .checkcontainer").click(function () {
        $checkPrice++;
        if($checkPrice >=0){
            $('#check_price').val('true');
        }else{
            $('#check_price').val('false');
        }
        check_active();
    });

    var $InputPlace0 = 0, $InputPlace1 = 0,$InputPlace2 = 0,$InputPlace3 = 0,$InputPlace4 = 0,$InputPlace5 = 0,$InputPlace6 = 0,$InputPlace7 = 0,$InputPlace8 = 0,$InputPlace9 = 0 ;

    $(".custom-checkbox #InputPlace0").click(function () {
        $InputPlace0++;
        if($InputPlace0 %2==0 && $InputPlace1 %2==0 && $InputPlace2 %2==0 && $InputPlace3 %2==0 && $InputPlace4 %2==0 && $InputPlace5 %2==0 && $InputPlace6 %2==0 && $InputPlace7 %2==0 && $InputPlace8 %2==0 && $InputPlace9 %2==0){
            $('#inc_num').val('false');
        }else{
            $('#inc_num').val('true');
        }
        check_active();
    });
    $(".custom-checkbox #InputPlace1").click(function () {
        $InputPlace1++;
        if($InputPlace0 %2==0 && $InputPlace1 %2==0 && $InputPlace2 %2==0 && $InputPlace3 %2==0 && $InputPlace4 %2==0 && $InputPlace5 %2==0 && $InputPlace6 %2==0 && $InputPlace7 %2==0 && $InputPlace8 %2==0 && $InputPlace9 %2==0){
            $('#inc_num').val('false');
        }else{
            $('#inc_num').val('true');
        }
        check_active();
    });
    $(".custom-checkbox #InputPlace2").click(function () {
        $InputPlace2++;
        if($InputPlace0 %2==0 && $InputPlace1 %2==0 && $InputPlace2 %2==0 && $InputPlace3 %2==0 && $InputPlace4 %2==0 && $InputPlace5 %2==0 && $InputPlace6 %2==0 && $InputPlace7 %2==0 && $InputPlace8 %2==0 && $InputPlace9 %2==0){
            $('#inc_num').val('false');
        }else{
            $('#inc_num').val('true');
        }
        check_active();
    });
    $(".custom-checkbox #InputPlace3").click(function () {
        $InputPlace3++;
        if($InputPlace0 %2==0 && $InputPlace1 %2==0 && $InputPlace2 %2==0 && $InputPlace3 %2==0 && $InputPlace4 %2==0 && $InputPlace5 %2==0 && $InputPlace6 %2==0 && $InputPlace7 %2==0 && $InputPlace8 %2==0 && $InputPlace9 %2==0){
            $('#inc_num').val('false');
        }else{
            $('#inc_num').val('true');
        }
        check_active();
    });
    $(".custom-checkbox #InputPlace4").click(function () {
        $InputPlace4++;
        if($InputPlace0 %2==0 && $InputPlace1 %2==0 && $InputPlace2 %2==0 && $InputPlace3 %2==0 && $InputPlace4 %2==0 && $InputPlace5 %2==0 && $InputPlace6 %2==0 && $InputPlace7 %2==0 && $InputPlace8 %2==0 && $InputPlace9 %2==0){
            $('#inc_num').val('false');
        }else{
            $('#inc_num').val('true');
        }
        check_active();
    });
    $(".custom-checkbox #InputPlace5").click(function () {
        $InputPlace5++;
        if($InputPlace0 %2==0 && $InputPlace1 %2==0 && $InputPlace2 %2==0 && $InputPlace3 %2==0 && $InputPlace4 %2==0 && $InputPlace5 %2==0 && $InputPlace6 %2==0 && $InputPlace7 %2==0 && $InputPlace8 %2==0 && $InputPlace9 %2==0){
            $('#inc_num').val('false');
        }else{
            $('#inc_num').val('true');
        }
        check_active();
    });
    $(".custom-checkbox #InputPlace6").click(function () {
        $InputPlace6++;
        if($InputPlace0 %2==0 && $InputPlace1 %2==0 && $InputPlace2 %2==0 && $InputPlace3 %2==0 && $InputPlace4 %2==0 && $InputPlace5 %2==0 && $InputPlace6 %2==0 && $InputPlace7 %2==0 && $InputPlace8 %2==0 && $InputPlace9 %2==0){
            $('#inc_num').val('false');
        }else{
            $('#inc_num').val('true');
        }
        check_active();
    });
    $(".custom-checkbox #InputPlace7").click(function () {
        $InputPlace7++;
        if($InputPlace0 %2==0 && $InputPlace1 %2==0 && $InputPlace2 %2==0 && $InputPlace3 %2==0 && $InputPlace4 %2==0 && $InputPlace5 %2==0 && $InputPlace6 %2==0 && $InputPlace7 %2==0 && $InputPlace8 %2==0 && $InputPlace9 %2==0){
            $('#inc_num').val('false');
        }else{
            $('#inc_num').val('true');
        }
        check_active();
    });
    $(".custom-checkbox #InputPlace8").click(function () {
        $InputPlace8++;
        if($InputPlace0 %2==0 && $InputPlace1 %2==0 && $InputPlace2 %2==0 && $InputPlace3 %2==0 && $InputPlace4 %2==0 && $InputPlace5 %2==0 && $InputPlace6 %2==0 && $InputPlace7 %2==0 && $InputPlace8 %2==0 && $InputPlace9 %2==0){
            $('#inc_num').val('false');
        }else{
            $('#inc_num').val('true');
        }
        check_active();
    });
    $(".custom-checkbox #InputPlace9").click(function () {
        $InputPlace9++;
        if($InputPlace0 %2==0 && $InputPlace1 %2==0 && $InputPlace2 %2==0 && $InputPlace3 %2==0 && $InputPlace4 %2==0 && $InputPlace5 %2==0 && $InputPlace6 %2==0 && $InputPlace7 %2==0 && $InputPlace8 %2==0 && $InputPlace9 %2==0){
            $('#inc_num').val('false');
        }else{
            $('#inc_num').val('true');
        }
        check_active();
    });

    function check_active() {
        var text_form_price = $('#text_form_price').val();
        var text_to_price = $('#text_to_price').val();
        var text_sea = $('#text_sea').val();
        var check_price = $('#check_price').val();
        var in_nut = $('#in_nut').val();
        var in_diem = $('#in_diem').val();
        // check active btn search
        if( ( $('#selected-value').val()!='' && $('#selected-value').val()!='all' ) ||
            ( $('#selected-type').val()!='' && $('#selected-type').val()!='all' )
            ||  text_form_price !='' || text_to_price !=''
            || text_sea !='' || check_price =='true' || in_nut !='' || in_diem !=''
            || $('#inc_num').val() =='true'
        ){
            $('#submit_search .img_search_ic').attr('src','/templates/default/images/img_svg/trangchu/search_blue.svg');
            $('#submit_search').addClass('btn-search-active');
        }else{
            $('#submit_search .img_search_ic').attr('src','/templates/default/images/img_svg/trangchu/search.svg');
            $('#submit_search').removeClass('btn-search-active');
        }
    }

    $("#submit_search").hover(function(){
        $(this).addClass('hover_active');
        $('#submit_search .img_search_ic').attr('src','/templates/default/images/img_svg/trangchu/search_white.svg');
    }, function(){
        $(this).removeClass("hover_active");
        $('#submit_search .img_search_ic').attr('src','/templates/default/images/img_svg/trangchu/search.svg');
        check_active();
    });





    var ecart = $('.icon-cart').offset().top;
    $(window).bind('scroll', function () {
        var scrollTop = $(window).scrollTop();
        // console.log(scrollTop);
        if(scrollTop>ecart){
            // $('.shopcart').addClass('fix-shopcart');
            $('.products_cart').css('display','block');
            // $('.show-cart').addClass('fix-show-cart');
        }else{
            $('.shopcart').removeClass('fix-shopcart');
            $('.products_cart').css('display','none');
            // $('.show-cart').removeClass('fix-show-cart');
        }
    });



    $Itemid = $('#Itemid').val();
    if($Itemid != 1){
        var etop = $('#sim_search_wrap').offset().top;
        $('html, body').animate({scrollTop:etop-50+248}, 'slow');
    }




    function browserName(){
        var Browser = navigator.userAgent;
        if (Browser.indexOf('MSIE') >= 0){
            Browser = 'MSIE';
        }
        else if (Browser.indexOf('Firefox') >= 0){
            Browser = 'Firefox';
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
        return Browser;
    }
    if(browserName()== 'Safari'){
        $('#sim_search_wrap .icon-search').addClass('btn-search-safari');
        $('#sim_search_wrap .icon-search').addClass('btn-search-safari');
        $('.header-scroll').addClass('header-scroll-safari');
    }








});