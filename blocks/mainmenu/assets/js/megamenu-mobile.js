$(document).ready(function () {
    $('.button-level-2').click(function () {
        var x = $(this).attr("aria-expanded");
        if (x == "true")
        {
            $(this).parent().removeClass('click-x');
            x = "false";
        } else {
            x = "true";
            $(this).parent().addClass('click-x');
        }
        $(this).attr("aria-expanded",x);
    });


    $i = 0 ;
    $('.icon-drop').click(function () {
        $i++;
        if($i %2 !=0){
            $(this).find('.img-change').attr("src","/templates/mobile/images/x-icon.png");
            $(this).parent().find('.level_1').css('display','block');
        }else{
            $(this).find('.img-change').attr("src","/templates/mobile/images/cong-icon.png");
            $(this).parent().find('.level_1').css('display','none');
        }
    });
});