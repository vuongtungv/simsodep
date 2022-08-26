$(document).ready(function () {
    var $i = 0 ;
    $('.click-change').click(function (){
        $i++;
        if($i%2 != 0){
            $('.text-sort').html('Giá tăng dần');
        }else{
            $('.text-sort').html('Giá giảm dần');
        }
    });

    // Choose Price
    $(".value-type-sim").click(function(e) {
        $('.select-options .options').hide();
        $(".select-type .options").hide();
        $(".show-cart").hide();
        $('#search-guide').hide();
        $(".sim-name .options").hide();
        $('.quick-net .options').hide();
        $('.quick-first .options').hide();
        $(".select-first-sim").hide('300');
        $(".select-type-sim").toggle('300');
        e.stopPropagation();
        // var icon = $(this).find("i");
        // icon.toggleClass("glyphicon-chevron-down glyphicon-chevron-up");
    });

    // Choose first sim
    $(".value-first-sim").click(function(e) {
        $('.select-options .options').hide();
        $(".select-type .options").hide();
        $(".show-cart").hide();
        $('#search-guide').hide();
        $(".sim-name .options").hide();
        $('.quick-net .options').hide();
        $('.quick-first .options').hide();
        $(".select-type-sim").hide('300');
        $(".select-first-sim").toggle('300');
        e.stopPropagation();
        // var icon = $(this).find("i");
        // icon.toggleClass("glyphicon-chevron-down glyphicon-chevron-up");
    });
    // $(".select-type-sim .option").click(function(e) {
    //     $("#selected-type-sim").attr("value", $(this).attr("value"));
    //     $(".value-type-sim").text($(this).text());
    //     // $('#submit_search i').css('color','#3478f7 ');
    // });
    // $(document).click(function(e) {
    //     $('.select-type-sim').hide('300');
    //     e.stopPropagation();
    // });


    $('.pro-in-cart .delete-cart-ok').removeClass('add-cart');
    var url_root = $('#url_root').val();
    $('.icon_add-cart.add-cart').on('click',function () {
        var id = $(this).attr('data-id');
        var price = $(this).attr('data-price');
        var sim = $(this).attr('data-sim');
        $(this).addClass('icon_in_cart');
        $(this).find('img').attr("src","/templates/mobile/images/icon-hover-0101.png");
        $(this).parent().addClass('pro-in-cart');
        $(this).removeClass('add-cart');
        $.ajax({
            type : 'POST',
            url : '/index.php?module=sim_network&view=home&task=add_cart&raw=1',
            dataType : 'json',
            data: {id:id,price:price,sim:sim},
            success : function($json){
                // if($json.error == true){
                //     alert($json.msg);
                // }else{
                alert("Thêm vào giỏ hàng thành công.");
                location.reload();
                // showQuickCart();
                // }
            }
        });
    });


    // $('.delete-cart-ok').on('click',function () {
    //     var id = $(this).attr('data-id');
    //     alert(id);
    //     $(this).addClass('add-cart');
    //     $(this).find('img').attr("src","/templates/mobile/images/icon-hover-01.png");
    //     $(this).parent().removeClass('pro-in-cart');
    //     $(this).removeClass('delete-cart-ok');
    //     $.ajax({
    //         type : 'POST',
    //         url : '/index.php?module=sim_network&view=home&task=delete&raw=1',
    //         dataType : 'json',
    //         data: {id:id},
    //         success : function($json){
    //             // if($json.error == true){
    //             //     alert($json.msg);
    //             // }else{
    //             alert("Đã xóa khỏi giỏ hàng.");
    //             location.reload();
    //             // showQuickCart();
    //             // }
    //         }
    //     });
    // });




    $(".add-cart-pay").click(function(){
        var id = $(this).attr('data-id');
        var price = $(this).attr('data-price');
        var sim = $(this).attr('data-sim');
        $.ajax({
            type : 'POST',
            url : '/index.php?module=sim_network&view=home&task=add_cart&raw=1',
            dataType : 'json',
            data: {id:id,price:price,sim:sim},
            success : function($json){
                // if($json.error == true){
                //     alert($json.msg);
                // }else{
                // alert("Thêm vào giỏ hàng thành công");
                window.location.href = url_root+"index.php?module=paynow&view=paynow";
                // location.reload();
                // showQuickCart();
                // }
            }
        });
    });

    $('.delete-cart-ok').attr("title", "Xóa khỏi giỏ hàng");


    if($('.icon_add-cart').find(".icon_in_cart").length < 0) {
        $(".icon_add-cart img").hover(function(){
            $(this).attr('src','/templates/mobile/images/icon-hover-0101.png');
        }, function(){
            $(this).attr('src','/templates/mobile/images/icon-no-hover-01.png');
        });
    }

    $(".add-cart-pay img").hover(function(){
        $(this).attr('src','/templates/mobile/images/icon-hover-0202.png');
    }, function(){
        $(this).attr('src','/templates/mobile/images/icon-no-hover-02.png');
    });
    $(".icon_in_cart img").attr("src","/templates/mobile/images/icon-hover-0101.png");
});