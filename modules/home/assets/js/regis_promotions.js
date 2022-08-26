// register sim
var $sn = 0
$(".sim-name").on("click", function (e) {
    $sn++;
    $('.select-year .options').hide('300');
    $('.select-month .options').hide('300');
    $('.select-day .options').hide('300');
    $(".sim-name .options").toggle('300');
    if($sn %2 !=0){
        $('.icon_drop_x').attr('src','/templates/default/images/img_svg/thanh_toan/delete.svg');
    } else{
        $('.icon_drop_x').attr('src','/templates/default/images/img_svg/trangchu/down_menu.svg');
    }

    e.stopPropagation();
    // var icon = $(".select-dropdown-icon i");
    // icon.removeClass("fa fa-angle-down");
    // icon.addClass("fa fa-times");
});
$(".sim-name .option").on("click", function () {
    $('.icon_drop_x').attr('src','/templates/default/images/img_svg/trangchu/down_menu.svg');
    $('.sim-name .option').removeClass('active');
    $(this).addClass('active');  
    $("#selected-sim-name").attr("value", $(this).attr("value"));
    $("#selected-sim-name").attr("data-id", $(this).attr("data-id"));
    $("#id_net_work").attr("value", $(this).attr("data-id"));
    $.ajax({
        url: "index.php?module=home&view=home&task=ajax_get_promotions&raw=1",
        data: {
            cid: $(this).attr("data-id")
        },
        dataType: "json",
        success: function(json) {
            // var obj = JSON.parse('{"firstName":"John", "lastName":"Doe"}');
            // alert(obj.firstName);
            // var detail_per = JSON.parse(json);
            if(json.title !='null'){
                $("#name_regis").html(json.title);
                $("#price_regis").html(json.price);
                $("#detail_regis").html(json.content);
                $("#send_detail").html(json.rules_regis) ;
                $("#send_num").html(json.number_send) ;

                $("#name_regis_pop").html(json.title);
                $("#send_detail_pop").html(json.rules_regis);
                $("#send_num_pop").html(json.number_send);
                if(json.link !=''){
                    $('#promotions-link').attr('href',json.link);
                    $('#promotions-pop').addClass('promotions-pop-hidden');
                }else{
                    $('#promotions-link').removeClass('promotions-link-show');
                    $('#promotions-pop').removeClass('promotions-pop-hidden');
                }
            }
        }
    });
    $(".value-type").text($(this).text());
    $(".select-type .options").css('display', 'none !important');
});
$(document).click(function(e) {
    $('.sim-name .options').hide('300');
    $('.icon_drop_x').attr('src','/templates/default/images/img_svg/trangchu/down_menu.svg');
    e.stopPropagation();
});



$(document).ready(function () {
    $('.click-regis-now').click(function () {
        $('.success-click').css('display','block');
    });

    // If an event gets to the body
    $(".success-click").click(function(e){
        var container = $(".show-send-mess");
        if (!container.is(e.target) && container.has(e.target).length === 0)
        {
            $('.success-click').css('display','none');
        }
    });
    $('.close-pup').click(function () {
        $('.success-click').css('display','none');
    });
});
