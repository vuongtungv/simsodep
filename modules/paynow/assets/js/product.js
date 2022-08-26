$(document).ready(function(){
    /* Ảnh sản phẩm*/
    $('.product-thumbs ul li').click(function(){
        $('.product-thumbs ul li').removeClass('selected');
        $(this).addClass('selected');
        $('#product-image').attr('src', $(this).children('img').attr('src').replace('/tiny/', '/medium/'));
        initZoom();
    });
    /* Tabs */
    $('#quantity').change(function(){
        var $obj = $('.bound-quantity a.add-cart');
        $id = $obj.attr('data-id');
        $quantity = $(this).val();
        $('.bound-quantity a.add-cart').attr('href', '/index.php?module=product&view=cart&task=addCart&id='+$id+'&quantity='+$quantity);
    });

    // if($('#product-zoom').length)
    //     initZoom();

    $('ul.tabs li a.tabs-label').click(function(){
        $('ul.tabs li').removeClass('selected');
        $(this).parent().addClass('selected');
        $('.tabs-content').removeClass('selected');
        var $tab = $(this).attr('data-content'); 
        $('#'+$tab).addClass('selected');
    });
    
    $('#product-faqs .faq-heading a').click(function(){
        $(this).parent().parent().toggleClass('selected');
    });

    $('.button-add').click(function () {
        var $quantity = $('input[name="quantity"]').val();
        $quantity = parseInt($quantity) + 1;
        $('input[name="quantity"]').val($quantity);
        $('.quantity-text').html($quantity);
    });

    $('.button-sub').click(function () {
        var $quantity = $('input[name="quantity"]').val();
        if(parseInt($quantity) == 1)
            return;
        $quantity = parseInt($quantity) - 1;
        $('input[name="quantity"]').val($quantity);
        $('.quantity-text').html($quantity);
    });



    // Show image by color
    $('.other-color a').click(function (event) {
        // document.getElementById("extend_color").value = 0; // Get text field
        var $id = $(this).attr('data-id');
        var $name = $(this).attr('data-name');
        var $field = $(this).attr('data-field');

        $('input[name="extend_'+$field+'"]').val($id);
        $('.extend_text_'+$field).html($name);

        document.getElementById("form-color-new").submit();




        if($id == 0){
            $("#by-color").hide("slow");
            $('#default-color').show('slow');
        }
        else{
            $("#by-color").show("slow");
            $("#default-color").hide("slow");
        }
    });



    $('#product-related .sp-item .checked').click(function () {
        var $checked = $(this).attr('data-checked');
        if($checked == 1){
            $(this).addClass('unchecked');
            $(this).attr('data-checked', 0);
        }else{
            $(this).removeClass('unchecked');
            $(this).attr('data-checked', 1);
        }

        var $ids = '0';
        $('#product-related .sp-item .checked').each(function(){
            var $checked = $(this).attr('data-checked');
            var $id = $(this).attr('data-id');
            if($checked == 1)
                $ids += ','+$id;
        });
        $('#product-related .btn-related').attr('data-id', $ids);
    })
});

// function initZoom() {
//     var $src = $('#product-zoom img').attr('src').replace('/medium/', '/original/');
//     $('#product-zoom').zoom({url: $src});
// }

function validateComment(){ 
    if ($('#txtCom').val() == '') {
        Boxy.alert('Bạn vui lòng nhập bình luận.',function(){ $('#txtCom').focus();},{title:'Thông báo.',afterShow: function() {$('#boxy_button_OK').focus();}});
      	return false;
   	}
    if ($('#txtName').val() == '') {
        Boxy.alert('Bạn vui lòng nhập tên.',function(){ $('#txtName').focus();},{title:'Thông báo.',afterShow: function() {$('#boxy_button_OK').focus();}});
      	return false;
   	}
	if(!isEmail($('#txtMail').val())){
		Boxy.alert('Hãy nhập địa chỉ Email.',function(){$('#txtMail').focus();},{title:'Thông báo.',afterShow: function() { $('#boxy_button_OK').focus();} });
		return false;
	}
	if ($('#txtCode').val()=='') {Boxy.alert('Bạn vui lòng nhập mã bảo mật.',function(){ $('#txtCode').focus();},{title:'Thông báo.',afterShow: function() {$('#boxy_button_OK').focus();}});
      	return false;
   	}
	var $data = $('form#frmComment').serialize();
	$('#waitting').addClass('show');
	$.ajax({
		type : 'POST',
		url : '/index.php?module=ajax&view=ajax&task=commentProduct',
		dataType : 'json',
		data: $data,
		success : function(data){Boxy.alert(data.message,function(){$('#waitting').removeClass('show'); if (data.error==false) {location.reload(true)}},{title:'Thông báo.',afterShow: function() { $('#boxy_button_OK').focus();} });},
		error : function(XMLHttpRequest, textStatus, errorThrown) {Boxy.alert('Có lỗi trong quá trình đưa lên máy chủ. Xin bạn vui lòng kiểm tra lại kết nối.',function(){$('div#waitting').css('display','none');},{title:'Thông báo.',afterShow: function() { $('#boxy_button_OK').focus();} });
		}
	});
	return false;
}
function quickBuy($id){
    tb_show('Mua nhanh', '/index.php?module=product&view=product&raw=1&width=510&task=quickBuy&id='+$id);
    return false;
}

function validquickBuy(){
    if ($('#qname').val()=='') {
        Boxy.alert('Bạn vui lòng nhập tên.',function(){ $('#qname').focus();},{title:'Thông báo.',afterShow: function() {$('#boxy_button_OK').focus();}});
      	return false;
   	}
    if ($('#qmobile').val()=='') {
        Boxy.alert('Bạn vui lòng nhập số điện thoại.',function(){ $('#qmobile').focus();},{title:'Thông báo.',afterShow: function() {$('#boxy_button_OK').focus();}});
      	return false;
   	}
    if ($('#qaddress').val()=='') {
        Boxy.alert('Bạn vui lòng nhập địa chỉ.',function(){ $('#qaddress').focus();},{title:'Thông báo.',afterShow: function() {$('#boxy_button_OK').focus();}});
      	return false;
   	}
    var $data = $('form#frm_quick_buy').serialize();
	$('#waitting').show();
	$.ajax({
		type : 'POST',
		url : '/index.php?module=ajax&view=ajax&task=frm_quick_buy&raw=1',
		dataType : 'json',
		data: $data,
		success : function(data){Boxy.alert(data.message,function(){$('#waitting').hide(); if (data.error==false) {location.reload(true)}},{title:'Thông báo.',afterShow: function() { $('#boxy_button_OK').focus();} });},
		error : function(XMLHttpRequest, textStatus, errorThrown) {Boxy.alert('Có lỗi trong quá trình đưa lên máy chủ. Xin bạn vui lòng kiểm tra lại kết nối.',function(){$('div#waitting').css('display','none');},{title:'Thông báo.',afterShow: function() { $('#boxy_button_OK').focus();} });
		}
	});
	return false
}

$('.related_products_detail').click(function(){
    var $price = parseInt($('#product_price').val());
    
    var checkedVals = $('.related_products_detail:checkbox:checked').map(function() {
        return this.value;
    }).get();
    
    $ids = checkedVals.join(",");
    
    $('#product_related').val($ids);
    
    var $arrIds = $ids.split(',');
    $(".related_products").prop('checked', false);
    if($ids != '')
        $.each($arrIds, function( key, value){
            $(".related_"+value).prop('checked', true);
            $price = $price + parseInt($('#product_price_'+value).val());
        });
    
    $('span.price-all').html($.number( $price, 0, ',', '.' )+' đ');
    
    var $obj = $('#add-cart-detail');
    $id = $obj.attr('data-id');
    $related = $('#product_related').val();
    $('a.add-cart').attr('href', '/dat-mua-'+$id+'?related='+$related)
});

$('.related_products_quick').click(function(){
    var $price = parseInt($('#product_price').val());
    
    var checkedVals = $('.related_products_quick:checkbox:checked').map(function() {
        return this.value;
    }).get();
    
    $ids = checkedVals.join(",");
    
    $('#product_related').val($ids);
    
    var $arrIds = $ids.split(',');
    $(".related_products").prop('checked', false);
    if($ids != '')
        $.each($arrIds, function( key, value){
            $(".related_"+value).prop('checked', true);
            $price = $price + parseInt($('#product_price_'+value).val());
        });
    
    $('span.price-all').html($.number( $price, 0, ',', '.' )+' đ');
    
    var $obj = $('#add-cart-detail');
    $id = $obj.attr('data-id');
    $related = $('#product_related').val();
    $('a.add-cart').attr('href', '/dat-mua-'+$id+'?related='+$related)
});

$('.add-cart').click(function (event){
    var $id = $(this).attr('data-id');
    var $quantity = $('input[name="quantity"]').val();
    // var $color = $('input[name="extend_color"]').val();
    var $size = $('input[name="extend_size"]').val();
    var $style = $('input[name="extend_style"]').val();
    // if($color == 0){
    //     fsAlert('Bạn vui lòng chon màu sản phầm!');
    //     return false;
    // }
    // if($style == 0 || $style == ''){
    //     alert('Bạn vui lòng chon kiểu dáng!');
    //     return false;
    // }
    if($size == 0 || $size == ''){
        alert('Bạn vui lòng chon size!');
        return false;
    }
    if($quantity <= 0 || $size == ''){
        alert('Bạn vui lòng chon số lượng >0');
        return false;
    }
    $.ajax({
        type : 'POST',
        url : '/index.php?module=product&view=product&task=add_cart&raw=1',
        dataType : 'json',
        data: 'id='+$id+'&quantity='+$quantity+'&size='+$size+'&style='+$style,
        success : function($json){
            // if($json.error == true){
            //     alert($json.msg);
            // }else{
                showQuickCart();
            // }
        }
    });
});
$('.empty-product').click(function () {
    alert('Sản phẩm tạm thời hết hàng.');
});


$('.payment-method > a').click(function(){
    $('.payment-method').removeClass('selected');
    $(this).parent().addClass('selected');
    $('#payment_method').val($(this).attr('data-id'));
});

$('a.btn-related').click(function(){
    var $IDs = $(this).attr('data-id');
    var $comboID = $(this).attr('data-combo');
    if($IDs == '0' || $IDs ==''){
        fsAlert('Bạn vui lòng chon sản phẩm!');
        return false;
    }
    $(this).addClass('disabled');
    $.ajax({
        type : 'POST',
        sync: false,
        dataType: 'json',
        url : '/index.php?module=product&view=product&task=add_cart_multi&raw=1',
        data: 'ids='+$IDs+'&cid='+$comboID,
        success : function($json){
            if($json.error == false)
                location.href = $json.url;
        },
        error: function(){
            $(this).removeClass('disabled');
        }
    });
    return false;
});

function showQuickCart(){
    $.ajax({
        type : 'POST',
        url : '/index.php?module=product&view=product&task=quick_cart&raw=1',
        dataType : 'html',
        success : function($json){
            $('#fs-modal .modal-body').html($json);
            $('#fs-modal').modal({show:true});
        }
    });
}

$('#sender_city').change(function(){
    setSelectDistricts($('#sender_district'), $(this).val(), 0);
});

$('#recipients_city').change(function(){
    setSelectDistricts($('#recipients_district'), $(this).val(), 0);
});

function validateUpdateCart(){
    $('input.quantity-value').each(function(){
        if(Number.isInteger($(this).val()) || $(this).val() <=0 ){
            alert('Số lượng phải là số và lớn hơn 0.');
            $(this).focus();
            return false;
        }
    });
    var data = $('#frmUpdateCart').serialize();

    $.ajax({
        type : 'POST',
        url : 'index.php?module=product&view=product&raw=1&task=updateCart',
        dataType : 'JSON',
        data: data,
        success : function(data){
            window.location.reload(true);
        },
        error : function(XMLHttpRequest, textStatus, errorThrown) {

        }
    });
    return false;
}

function validatePayment(){
    if($('#username').val() == ''){
        alert('Hãy nhập họ và tên của bạn.');
        $('#username').focus();
        return false;
    }
    if($('#recipients_email').val() == ''){
        alert('Nhập email của bạn.');
        $('#recipients_email').focus();
        return false;
    }
    if($('#recipients_address').val() == ''){
        alert('Nhập địa chỉ của bạn.');
        $('#recipients_address').focus();
        return false;
    }
    if($('#recipients_telephone').val() == ''){
        alert('Nhập số điện thoại của bạn.');
        $('#recipients_telephone').focus();
        return false;
    }
    var filterEmail = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    var phoneno = /^\(?([0-9]{3})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{4})$/;
    if(!$('#recipients_email').val().match(filterEmail)){

        alert('Email chưa đúng định dạng');

        $('#recipients_email').focus();

        return false;
    }
    if(!$('#recipients_telephone').val().match(phoneno)){

        alert('Số điện thoại chưa đúng định dạng');

        $('#recipients_telephone').focus();

        return false;
    }



    // if($('#payment_method').val() == 1) {
    //     if ($('#payment_bank').val() == '') {
    //         fsAlert('Bạn vui chọn ngân hàng để chuyên khoản.');
    //         $('#payment_bank').focus();
    //         return false;
    //     }
    // }else{
    //     $('#payment_bank').val('');
    // }
    var payment_method = $("input[name='payment_method']:checked").val();
    if(payment_method == 1){
        document.forms['frmPayment'].submit();
    }


}

$('#txtPayLive').click(function (){
    if($('#username').val() == ''){
        alert('Hãy nhập họ và tên của bạn.');
        $('#username').focus();
        return false;
    }
    if($('#recipients_email').val() == ''){
        alert('Nhập email của bạn.');
        $('#recipients_email').focus();
        return false;
    }
    if($('#recipients_address').val() == ''){
        alert('Nhập địa chỉ của bạn.');
        $('#recipients_address').focus();
        return false;
    }
    if($('#recipients_telephone').val() == ''){
        alert('Nhập số điện thoại của bạn.');
        $('#recipients_telephone').focus();
        return false;
    }

    var filterEmail = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    var phoneno = /^\(?([0-9]{3})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{4})$/;
    if(!$('#recipients_email').val().match(filterEmail)){
        alert('Email chưa đúng định dạng');
        $('#recipients_email').focus();
        return false;
    }
    if(!$('#recipients_telephone').val().match(phoneno)){
        alert('Số điện thoại không đúng định dạng');
        $('#recipients_telephone').focus();
        return false;
    }

    $('.showATM_online').css('display', 'block');
    $('#submit-bt3').css('display', 'none');
    var username = $('#username').val();
    var recipients_email = $('#recipients_email').val();
    var recipients_address = $('#recipients_address').val();
    var recipients_telephone = $('#recipients_telephone').val();
    var sender_comments = $('#sender_comments').val();
    var payment_method = 0;
    var sender_sex = $("input[name='sender_sex']:checked").val();
    // document.forms['frmPayment'].submit();
    $.ajax({
        type : 'POST',
        url : 'index.php?module=product&view=cart&task=paymentSave2&raw=1',
        dataType : 'json',
        data: 'username='+username+'&recipients_email='+recipients_email+'&recipients_address='+recipients_address+'&recipients_telephone='+recipients_telephone+'&sender_comments='+sender_comments+'&payment_method='+payment_method+'&sender_sex='+sender_sex,
        success : function($json){
            document.getElementById("order_id").setAttribute('value',$json);
        }
    });
});
$('#txtPayOff').click(function (){
    $('.showATM_online').css('display', 'none');
    $('#submit-bt3').css('display', 'inline-block');
});

$('.nav-tabs.nav-bank li a').click(function () {
    $('input[name="payment_bank"]').val($(this).attr('data-value'));
});

function validApplyDiscount(){
    if(!isEmpty('discount_code')){
        fsAlert('Hãy nhập mã giảm giá của bạn.');
        $('#discount_code').focus();
        return false;
    }
    $.ajax({
        type : 'POST',
        url : '/index.php?module=ajax&view=ajax&raw=1&task=applyDiscount',
        dataType : 'json',
        data: {discount_code:$('#discount_code').val(), cart_total:$('#cart_total').val()},
        success : function(data){
            if(data.error == true){
                fsAlert(data.message);
                $('#discount_code').focus();
            }else{
                fsAlert(data.message);
                location.reload();
            }
        },
        error : function(XMLHttpRequest, textStatus, errorThrown) {fsAlert('Có lỗi trong quá trình đưa lên máy chủ. Xin bạn vui lòng kiểm tra lại kết nối.');}
    });
    return false;
}


function run() {
    document.getElementById("extend_size").value = document.getElementById("size-extends").value;
    document.getElementById("extend_style").value = document.getElementById("style-extends").value;
}
var heightImg = document.getElementById('default-color').offsetHeight;
var offsetHeight = document.getElementById('body_fix_add_cart').offsetHeight;
/*Scroll to top when arrow up clicked BEGIN*/
if(screen.width>=768){
    $(window).bind('scroll', function () {
        var heightTop = $(window).scrollTop();
        console.log(heightTop);
        if(heightTop>80 && heightTop <= heightImg){
            $('#body_fix_add_cart').addClass('body_fix_add_cart');
        }
        else{
            $('#body_fix_add_cart').removeClass('body_fix_add_cart');
        }
    });
}
