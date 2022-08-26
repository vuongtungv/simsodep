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


    $click_help = 0;
    $("#id-help").on("click", function () {
        $click_help ++;
        if($click_help %2 !=0){
            $("#show-help").slideDown(300);
            $(this).attr('src','/templates/mobile/images/img_svg/trang_chu/search/close.svg');
        }else{
            $("#show-help").slideUp(300);
            $(this).attr('src','/templates/mobile/images/img_svg/trang_chu/huong_dan_tim_kiem.svg');
        }
    });


    $('#text-search').on('keyup',function () {
        if($(this).val()!=''){
            $(this).parent().find('img').css('display','none');
        }else{
            $(this).parent().find('img').css('display','unset');
        }
        check_active();
    });
    $('#selected-value').change(function () {
        check_active();
    });
    $('#selected-type').change(function () {
        check_active();
    });
    $('#form_price').on('keyup',function () {
        check_active();
    });
    $('#to_price').on('keyup',function () {
        check_active();
    });
    $('#total-button-sim').on('keyup',function () {
        check_active();
    });
    $('#total-score-sim').on('keyup',function () {
        check_active();
    });
    var $checkPrice = 0;
    $(".check-type-number-1 .checkcontainer").click(function () {
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
        var text_search = $('#text-search').val();
        var selected_value = $('#selected-value').val();
        var selected_type = $('#selected-type').val();
        var form_price = $('#form_price').val();
        var to_price = $('#to_price').val();
        var check_price = $('#check_price').val('true');
        var total_button_sim = $('#total-button-sim').val();
        var total_score_sim = $('#total-score-sim').val();
        var inc_num = $('#inc_num').val('true');

        // check active btn search
        if( text_search !='' || selected_value !='' || selected_type !='' || form_price!='' || to_price!='' || total_button_sim!='' || total_score_sim!='' || check_price =='true' || inc_num =='true')
        {
            $('.btn_search').css('background','#fd8f00');
        }
        else{
            $('.btn_search').css('background','#007bff');
        }
    }


});