
// jQuery(function($) {
//     $('.numeric').autoNumeric('init');
// });


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

function myFunctiontb(text) {
  // Get the snackbar DIV
  var x = document.getElementById("snackbar");

  // Add the "show" class to DIV
  $('#snackbar p').html(text);
  x.className = "show";

  // After 3 seconds, remove the show class from DIV
  setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
}

function action_cart(sim,id,price,network,cat,point,button,el) {
    root = $('#root').val();
    cart = $(el).attr("cart");
    type = $(el).attr("type");
    if (type == 'list') {
        if (cart == 'no_cart') {
            $('.div-add-cart'+id).hide();
            $('.delete-sim'+id).show();
            $('.md_cart_'+id+' .scart').show();
            myFunctiontb('Thêm vào giỏ hàng thành công !');
            $('.menu-top .cart-icon .icon_has_cart').addClass('has_pro_dot');
        }else{
            $('.div-add-cart'+id).show();
            $('.delete-sim'+id).hide();
            $('.md_cart_'+id+' .scart').hide();
            myFunctiontb('Đã xóa khỏi giỏ hàng !');
            $.ajax({
                async: true,
                url: root+"index.php?module=home&view=home&task=check_count_cart&raw=1",
                data: {},
                dataType: "html",
                success: function (result) {
                    if(result == 0){
                        $('.menu-top .cart-icon .icon_has_cart').removeClass('has_pro_dot');
                    }
                }
            });
        }
    }
    // if (type == 'block2') {
    //     if (cart == 'no_cart') {
    //         alert("Thêm vào giỏ hàng thành công.");
    //         $(el).attr("cart","exit_cart");
    //         $(el).attr("title","Xóa khỏi giỏ hàng");
    //         $(el).children().attr("src",root+"templates/default/images/icon_in_cart.png");
    //     }else{
    //         alert("Xóa khỏi giỏ hàng.");
    //         $(el).attr("cart","no_cart");
    //         $(el).attr("title","Thêm vào giỏ hàng");
    //         $(el).children().attr("src",root+"templates/default/images/icon_sim.png");
    //     }
    // }
    if (type == 'block1') {
        if (cart == 'no_cart') {
            $(el).attr("cart","exit_cart");
            $(el).attr("title","Xóa khỏi giỏ hàng");
            $(el).children().attr("src",root+"templates/mobile/images/img_svg/trang_chu/cart_dots.svg");
            myFunctiontb('Thêm vào giỏ hàng thành công !');
            $('.menu-top .cart-icon .icon_has_cart').addClass('has_pro_dot');
        }else{
            $(el).attr("cart","no_cart");
            $(el).attr("title","Thêm vào giỏ hàng");
            $(el).children().attr("src",root+"templates/mobile/images/img_svg/trang_chu/Cart.svg");
            myFunctiontb('Đã xóa khỏi giỏ hàng !');
            $.ajax({
                async: true,
                url: root+"index.php?module=home&view=home&task=check_count_cart&raw=1",
                data: {},
                dataType: "html",
                success: function (result) {
                    if(result == 0){
                        $('.menu-top .cart-icon .icon_has_cart').removeClass('has_pro_dot');
                    }
                }
            });
        }
    }
    root = $('#root').val();
    $.ajax({
        async: false,
        url: root+"index.php?module=home&view=home&task=maction_cart&raw=1",
        data: {id:id, sim:sim, price:price, network:network, cat:cat, point:point, button:button},
        dataType: "json",
            success: function (result) {

                if (result.quantity == 0) {
                  $('.icon_has_cart').hide();
                }else{
                  $('.icon_has_cart').show();
                }

                $('#table-quick-cart tbody').html(result.list);
                $('#table-quick-cart tfoot').show();
                $('#total_cart').html(result.total);
                $('#total_word').html(result.total_word);
            }
    });
}

// Toggle menu
$(document).ready(function () {

  $('.icon_delete').on('click', function () {
      var number = $(this).attr('data'); // get selected value
      code = $('#code').val();
      if (confirm('Xóa sim '+number+' khỏi giỏ hàng?')){
          $('.row_'+number).hide();
          $.ajax({
            async: true,
            url: "index.php?module=home&view=home&task=mdelete&raw=1",
            data: {number:number,code:code},
            dataType: "json",
                success: function (result) {
                    $('#table-quick-cart tbody').html(result.list);
                    $('#table-quick-cart tfoot').show();
                    $('#total_cart').html(result.total);
                    $('#total_word').html(result.total_word);

                    $('#m_totalend').html(result.total);
                    $('#total_ori').html(result.total);
                    $('#ex_total').html(result.total);
                    $('#m_totalend_word').html('('+result.total_word+' đồng)');
                }
          });
        myFunctiontb('Đã xóa khỏi giỏ hàng !');
      }
  });


    $('#bg-opacity .breadcrumb.breadcrumb-link').removeClass('container');
   var $height = document.body.clientHeight-183;
   var i=0;j=0;k=0;h=0;
    var root=$('#root').val();
   $('#btn-menu').click(function (e) {
       i++;
       if(i %2 !=0){
           $('.abcedef').addClass('show-abcd');
           // $("#bg-opacity").addClass('bg-opacity');
           // $("#bg-opacity").addClass('bg-none');
           // $("#bg-opacity").css('display','none');
           $('head').append('<style>.bg-opacity:after{height: ' + $height + 'px;}</style>');
           $('#id-show-cart').hide();
           $('#dots-show').hide();
           $('#show-menu').slideDown('300');
           $('#btn-dots').removeClass('d_greyblue');
           $(this).attr('src',root+'templates/mobile/images/img_svg/trang_chu/left_menu_hover.svg');
       }else{
           $('.abcedef').removeClass('show-abcd');
           // $("#bg-opacity").removeClass('bg-opacity');
           // $("#bg-opacity").removeClass('bg-none');
           // $("#bg-opacity").css('display','block');
           $('#show-menu').slideUp('300');
           $(this).attr('src',root+'templates/mobile/images/img_svg/trang_chu/left_menu.svg');
       }
       e.stopPropagation();
   });

   $("#btn-cart").click(function (e) {
       j++;
       $('#id-show-cart').slideToggle('300');
       // if(j %2 !=0){
           // $('#id-show-cart').slideDown('300');
           $('#show-menu').hide();
           $('#dots-show').hide();
           $('.abcedef').removeClass('show-abcd');
           $('#btn-menu').attr('src',root+'templates/mobile/images/img_svg/trang_chu/left_menu.svg');
           $('#btn-dots').removeClass('d_greyblue');
       // }else{
       //     $('#id-show-cart').slideUp('300');
       // }
       e.stopPropagation();
       // $('.abcedef').removeClass('show-abcd');


       //
       // $('#bg-opacity').removeClass('bg-opacity');
       // $('#bg-opacity').removeClass('bg-none');
       // $('#bg-opacity').css('display', 'unset');


   });

   $("#btn-dots").click(function (e) {
       k++;
       $('#dots-show').slideToggle('300');
       // if(k %2 !=0) {
           // $("#bg-opacity").css('display','none');
           // $('head').append('<style>.bg-opacity:after{height: ' + $height + 'px;}</style>');
           $('#show-menu').hide();
           $('#id-show-cart').hide();
           // $('#dots-show').slideDown('300');
           $('#btn-menu').attr('src',root+'templates/mobile/images/img_svg/trang_chu/left_menu.svg');
           // $(this).attr('src',root+'templates/mobile/images/img_svg/trang_chu/right_menu_hover.svg');
           $('.abcedef').removeClass('show-abcd');
       // }
       // else{
       //
       //     // $("#bg-opacity").css('display','block');
       //     $('#dots-show').slideUp('300');
       //     $(this).attr('src',root+'templates/mobile/images/img_svg/trang_chu/right_menu.svg');
            $(this).toggleClass('d_greyblue');
       // }
       e.stopPropagation();
       // $("#bg-opacity").removeClass('bg-opacity');
       // $("#bg-opacity").removeClass('bg-none');
   });



    // js dots choose

    // Select promotion
    $(".select-promotion").on("click", function (e) {
        $(".select-promotion .options").slideToggle('slow');
        e.stopPropagation();
    });
    $(".select-promotion .option").on("click", function () {
        $("#regis-promotion").attr("value", $(this).attr("value"));
        $(".value-promotion").text($(this).text());
        $(".select-promotion .options").css('display', 'none !important');
    });
    $(document).click(function(e) {
        $('.select-promotion .options').hide('slow');
        e.stopPropagation();
    });

    // Quick search home
    $(".select-options").on("click", function (e) {
        $(".select-type .options").slideUp('slow');
        $(".select-options .options").slideToggle('slow');
        e.stopPropagation();
    });
    $(".select-options .option").on("click", function () {
        $("#selected-options").attr("value", $(this).attr("value"));
        $(".value-options").text($(this).text());
        $(".select-options .options").css('display', 'none !important');
    });
    $(document).click(function(e) {
        $('.select-options .options').hide('slow');
        e.stopPropagation();
    });

    $(".select-type").on("click", function (e) {
        $(".select-options .options").slideUp('slow');
        $(".select-type .options").slideToggle('slow');
        e.stopPropagation();
    });
    $(".select-type .option").on("click", function () {
        $("#selected-type").attr("value", $(this).attr("value"));
        $(".value-type").text($(this).text());
        $(".select-type .options").css('display', 'none !important');
    });
    $(document).click(function(e) {
        $('.select-type .options').hide('slow');
        e.stopPropagation();
    });



    $('.select-options img').on("click", function () {
        $('.select-options .sel-ip').addEventListener('click');
    });



    $name_module = $('#name_module').val();
    $('#ic_back_click_search').click(function () {
        $(this).css('display','none');
        $('.search-icon .input_search').css('display','none');
        $('.search-icon .click_search').css('display','block');
        $('.form-search-full').css('display','none');
        // $('#bg-opacity:after').css("display","none !important");
        // $('#bg-opacity').append('<style>#bg-opacity:after{display: none;}</style>');
        $("#bg-opacity").removeClass('bg-opacity');
        $("#bg-opacity").removeClass('bg-none');

        $('.help-onl').css('display','none');

        $('.menu-icon').css('display','block');
        $('.search-icon').css('width','55%');
        $('.dots-icon').css('display','block');
        $('.cart-icon').css('display','block');
        $('#btn-menu').attr('src',root+'templates/mobile/images/img_svg/trang_chu/left_menu.svg');
        $('#btn-dots').attr('src',root+'/templates/mobile/images/img_svg/trang_chu/right_menu.svg');
        $('.abcedef').removeClass('show-abcd');
        if($name_module !='home'){
            $('.logo-menu').css('display','block');
        }
    });




    window.onscroll = function() {myFunction()};
    function myFunction() {
        if (window.pageYOffset > 500) { 
            $('.scrollAnimationToTop').css("display", 'block');
        } else {
            $('.scrollAnimationToTop').css("display", 'none');
        }
    }
    $('.scrollAnimationToTop').click(function () {
        $('html, body').animate({
            scrollTop: 0
        }, 800);
        return false;
    });
    $('.scrollToTop').click(function () {
        $('html, body').animate({
            scrollTop: 0
        }, 800);     
        return false;
    });


    $('#text-search').keypress(function (e) {
        if (e.which == 13) {
            submit_form_search();
            return false;
        }
    });
});
