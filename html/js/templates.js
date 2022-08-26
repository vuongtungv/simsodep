$(document).ready(function () {

    $('[data-toggle="tooltip"]').tooltip();

    $(".shopcart").click(function (e) {
        $(".show-cart").toggle(300);
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
    });
    $(document).click(function(e) {
        $('.select-options .options').hide('300');
        e.stopPropagation();
    });


    // Choose Price
    $(".select-prices").click(function(e) {
        $('.select-options .options').hide();
        $(".select-type .options").hide();
        $(".show-cart").hide();
        $('#search-guide').hide();
        $(".sim-name .options").hide();
        $('.quick-net .options').hide();
        $('.quick-first .options').hide();


        $(".select-prices .options").toggle('300');
        e.stopPropagation();
        // var icon = $(this).find("i");
        // icon.toggleClass("glyphicon-chevron-down glyphicon-chevron-up");
    });
    $(".select-prices .option").click(function(e) {
        $("#selected-price").attr("value", $(this).attr("value"));
        $(".value-price").text($(this).text());
        $(".select-prices .options").css('display', 'none !important');
    });
    $(document).click(function(e) {
        $('.select-prices .options').hide('300');
        e.stopPropagation();
    });


    // sim type
    $(".select-type").on("click", function (e) {
        $('.select-options .options').hide();
        $(".select-prices .options").hide();
        $(".show-cart").hide();
        $('#search-guide').hide();
        $(".sim-name .options").hide();
        $('.quick-net .options').hide();
        $('.quick-first .options').hide();
        $(".select-type .options").toggle('300');
        e.stopPropagation();
        // var icon = $(this).find("i");
        // icon.toggleClass("glyphicon-chevron-down glyphicon-chevron-up");
    });
    $(".select-type .option").on("click", function () {
        $("#selected-type").attr("value", $(this).attr("value"));
        $(".value-type").text($(this).text());
        $(".select-type .options").css('display', 'none !important');
    });
    $(document).click(function(e) {
        $('.select-type .options').hide('300');
        e.stopPropagation();
    });

    // Hiển thị gợi í khi search
    $("#text-search").on("click",function (e) {
        // $("#search-guide").css("display", "block");
        $('.select-options .options').hide();
        $(".select-prices .options").hide();
        $(".select-type .options").hide();
        $(".show-cart").hide();
        $(".sim-name .options").hide();
        $('.quick-net .options').hide();
        $('.quick-first .options').hide();
        $("#search-guide").toggle('300');
        e.stopPropagation();
    });
    $(document).click(function(e) {
        $('#search-guide').hide('300');
        e.stopPropagation();
    });

    // close-promotion top
    $(".close-promo").click(function () {
        $('.promotion-information').hide('300');
    });













    // register sim
    $(".sim-name").on("click", function (e) {
        $('.select-year .options').hide('300');
        $('.select-month .options').hide('300');
        $('.select-day .options').hide('300');
        $(".sim-name .options").toggle('300');
        e.stopPropagation();
        // var icon = $(".select-dropdown-icon i");
        // icon.removeClass("fa fa-angle-down");
        // icon.addClass("fa fa-times");
    });
    $(".sim-name .option").on("click", function () {
        $("#selected-sim-name").attr("value", $(this).attr("value"));
        $(".value-type").text($(this).text());
        $(".select-type .options").css('display', 'none !important');
    });
    $(document).click(function(e) {
        $('.sim-name .options').hide('300');
        e.stopPropagation();
    });


    // Ngày tháng năm
    $(".select-day").on("click", function (e) {
        $('.sim-name .options').hide('300');
        $(".select-month .options").hide('300');
        $(".select-year .options").hide('300');
        $(".select-day .options").toggle('300');
        e.stopPropagation();
        // var icon = $(".select-dropdown-icon i");
        // icon.removeClass("fa fa-angle-down");
        // icon.addClass("fa fa-times");
    });
    $(".select-day .option").on("click", function () {
        $("#selected-day").attr("value", $(this).attr("value"));
        $(".value-day").text($(this).text());
        $(".select-day .options").css('display', 'none !important');
    });
    $(document).click(function(e) {
        $('.select-day .options').hide('300');
        e.stopPropagation();
    });

    $(".select-month").on("click", function (e) {
        $('.sim-name .options').hide('300');
        $(".select-day .options").hide('300');
        $(".select-year .options").hide('300');
        $(".select-month .options").toggle('300');
        e.stopPropagation();
        // var icon = $(".select-dropdown-icon i");
        // icon.removeClass("fa fa-angle-down");
        // icon.addClass("fa fa-times");
    });
    $(".select-month .option").on("click", function () {
        $("#selected-month").attr("value", $(this).attr("value"));
        $(".value-month").text($(this).text());
        $(".select-month .options").css('display', 'none !important');
    });
    $(document).click(function(e) {
        $('.select-month .options').hide('300');
        e.stopPropagation();
    });

    $(".select-year").on("click", function (e) {
        $('.sim-name .options').hide('300');
        $(".select-day .options").hide('300');
        $(".select-month .options").hide('300');
        $(".select-year .options").toggle('300');
        e.stopPropagation();
        // var icon = $(".select-dropdown-icon i");
        // icon.removeClass("fa fa-angle-down");
        // icon.addClass("fa fa-times");
    });
    $(".select-year .option").on("click", function () {
        $("#selected-year").attr("value", $(this).attr("value"));
        $(".value-year").text($(this).text());
        $(".select-year .options").css('display', 'none !important');
    });
    $(document).click(function(e) {
        $('.select-year .options').hide('300');
        e.stopPropagation();
    });


    // day month year 2
    $(".select-day-2").on("click", function (e) {
        $(".select-month-2 .options").hide('300');
        $(".select-year-2 .options").hide('300');
        $(".select-day-2 .options").toggle('300');
        e.stopPropagation();
        // var icon = $(".select-dropdown-icon i");
        // icon.removeClass("fa fa-angle-down");
        // icon.addClass("fa fa-times");
    });
    $(".select-day-2 .option").on("click", function () {
        $("#selected-day-2").attr("value", $(this).attr("value"));
        $(".value-day-2").text($(this).text());
        $(".select-day-2 .options").css('display', 'none !important');
    });
    $(document).click(function(e) {
        $('.select-day-2 .options').hide('300');
        e.stopPropagation();
    });

    $(".select-month-2").on("click", function (e) {
        $(".select-day-2 .options").hide('300');
        $(".select-year-2 .options").hide('300');
        $(".select-month-2 .options").toggle('300');
        e.stopPropagation();
        // var icon = $(".select-dropdown-icon i");
        // icon.removeClass("fa fa-angle-down");
        // icon.addClass("fa fa-times");
    });
    $(".select-month-2 .option").on("click", function () {
        $("#selected-month-2").attr("value", $(this).attr("value"));
        $(".value-month-2").text($(this).text());
        $(".select-month-2 .options").css('display', 'none !important');
    });
    $(document).click(function(e) {
        $('.select-month-2 .options').hide('300');
        e.stopPropagation();
    });

    $(".select-year-2").on("click", function (e) {
        $(".select-day-2 .options").hide('300');
        $(".select-month-2 .options").hide('300');
        $(".select-year-2 .options").toggle('300');
        e.stopPropagation();
        // var icon = $(".select-dropdown-icon i");
        // icon.removeClass("fa fa-angle-down");
        // icon.addClass("fa fa-times");
    });
    $(".select-year-2 .option").on("click", function () {
        $("#selected-year-2").attr("value", $(this).attr("value"));
        $(".value-year-2").text($(this).text());
        $(".select-year-2 .options").css('display', 'none !important');
    });
    $(document).click(function(e) {
        $('.select-year-2 .options').hide('300');
        e.stopPropagation();
    });


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
    $(".show-pagination").on("click", function (e) {
        $(".show-pagination .options").toggle('300');
        e.stopPropagation();
        // var icon = $(this).find("i");
        // icon.toggleClass("fa-angle-down fa-times");
    });
    $(".show-pagination .option").on("click", function () {
        $("#selected-pagination").attr("value", $(this).attr("value"));
        $(".value-pagination").text($(this).text());
        $(".show-pagination .options").css('display', 'none !important');
    });
    $(document).click(function(e) {
        $('.show-pagination .options').hide('300');
        e.stopPropagation();
    });


    $(".show-sim-type .show-value").on("click", function (e) {
        $(".show-sim-type .options").toggle('300');
        var icon = $(this).find("i");
        icon.toggleClass("fa-ellipsis-h fa-times");
        e.stopPropagation();
    });
    $(".show-sim-type .show-value span .fa.fa-times").on("click", function () {
        $(".show-sim-type .options").hide('300');
    });
    $(document).click(function(e) {
        $('.show-sim-type .options').hide('300');
        e.stopPropagation();
    });



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
});