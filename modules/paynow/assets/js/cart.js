

$(document).ready( function(){

    // Cập nhật id sim cho giỏ hàng
    // setTimeout(function(){ 
    //   root = $('#root').val();
    //   $.ajax({
    //       async: true,
    //       url: root+"index.php?module=home&view=home&task=update_id&raw=1"
    //   });
    // }, 3000);


    $(".box-head").click(function(){
        total = 0;
        count = 0;
        $('input[name="check"]:checked').each(function() {
            count = count + 1;
        });

        if (count < 2 || count >4) {
            alert('Quý khách phải chọn từ 02 đến 04 sim trong giỏ hàng để so sánh !');
        }else{
            $('input[name="check"]:checked').each(function() {
               total = total + 1;
               sim = $(this).attr('data-sim');
               $('.tr'+total).show();
               $('.sim'+total).html(sim);
               network = $(this).attr('data-network');
               $('.network'+total).html(network);
               cat = $(this).attr('data-cat');
               $('.cat'+total).html(cat);
               button = $(this).attr('data-button');
               $('.button'+total).html(button);
               point = $(this).attr('data-point');
               $('.point'+total).html(point);
               price = $(this).attr('data-price');
               $('.price'+total).html(price);
               id = this.value;
               $('#compare'+total).val(id);
            });
        }

    });

    $('input[name=compare]').change(function() {
      count = 0;
      str_id = '';
      $('input[name="compare"]:checked').each(function() {
          count = count + 1;
          id = this.value;
          if (id) {
            str_id += id+',';
          }
      });
      if(count > 0 && str_id != ''){
        $( "#paynow" ).removeClass("no_compare");
      }else{
        $( "#paynow" ).addClass("no_compare");
      }
    });


    $("#paynow").click(function(){
        count = 0;
        str_id = '';
        $('input[name="compare"]:checked').each(function() {
            count = count + 1;
            id = this.value;
            if (id) {
              str_id += id+',';
            }
        });
        if (str_id == '') {
            alert('Quý khách phải tối thiểu một sim để thanh toán !');
            return false;
        }
        // if (count == 0) {
        //     alert('Quý khách phải tối thiểu một sim để thanh toán !');
        //     return false;
        // }
        if(count > 0 && str_id != ''){
            $('input[name="compare"]:checked').each(function() {
               id = this.value;
               str_id += id+',';
            });
            str_id = str_id.substring(0, str_id.length - 1);    

            $.ajax({url: "index.php?module=paynow&view=paynow&task=compare_cart&raw=1",
                data: {id: str_id},
                dataType: "html",
                async : false,
                success : function($data){
                }
            });
            
            url_root = $('#url_root').val();
            window.location.href = url_root+"gio-hang.html";
        }

    });

    $("#check_code").click(function(){
        $code = $('#code').val();
        $totalmoney = $('#totalmoney').val();
        if (!$code) {
            return false;
        }
        $.ajax({url: "index.php?module=paynow&view=paynow&task=get_member&raw=1",
            data: {code: $code, total:$totalmoney },
            dataType: "json",
            success : function($json){
              if ($json.discount || $json.position_name || $json.name) {
                var gift = '';
                if ($json.gift) {
                    gift = ' và '+$json.gift;
                }
                $('#member_sales').html($json.discount+' '+$json.position_name+gift);
                $('#totalend').html($json.total+' ('+$json.string+' đồng)');
                $('#m_totalend').html($json.total);
                $('#m_totalend_word').html('('+$json.string+' đồng)');
                $('#totalafter').val($json.total_original);
                $('#ex_total').html($json.total);

                $('#code_f').val($json.code);
                $('#discount').val($json.discount_original);
                $('#discount_unit').val($json.discount_unit);
                $('#discount_name').val($json.position_name);
                $('#gift').val($json.gift);

                $('#deprecate_name').val($json.name);
                $('.deprecate_name').html($json.name);
                $('#deprecate_phone').val($json.telephone);
                $('.deprecate_phone').html($json.telephone);
                $('#deprecate_address').val($json.address);
                $('.deprecate_address').html($json.address);
                $('#deprecate_email').val($json.email);
                $('.deprecate_email').html($json.email);

                $('#selected-city').val($json.city); 
                $('.value-city').html($json.city_name);
                $('.deprecate_city').html($json.city_name);
                $( ".hidden" ).attr( "style", "display:block" );

                // check v

                  // tên
                  if($json.name !=''){
                      var regex_name = /^[a-zA-Z ÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚĂĐĨŨƠàáâãèéêìíòóôõùúăđĩũơƯĂẠẢẤẦẨẪẬẮẰẲẴẶẸẺẼỀỀỂưăạảấầẩẫậắằẳẵặẹẻẽềềểỄỆỈỊỌỎỐỒỔỖỘỚỜỞỠỢỤỦỨỪễệỉịọỏốồổỗộớờởỡợụủứừỬỮỰỲỴÝỶỸửữựỳỵỷỹ\\s]+$/;
                      if (regex_name.test($json.name)) {

                          $('#deprecate_name').removeClass("error_input");
                          $('#deprecate_name').addClass("success_input");
                          $('#show-error-name').css("display",'none');
                          $('#deprecate_name').parent().addClass('check_ok');
                          $('#deprecate_name').on('blur',function () {
                              $('#deprecate_name').addClass('border_none');
                          });
                      }else{
                          $('#deprecate_name').removeClass("success_input");
                          $('#deprecate_name').addClass("error_input");
                          $('#show-error-name').html("Họ tên phải là ký tự từ a-z");
                          $('#show-error-name').css("display",'block');
                          $('#deprecate_name').on('blur',function () {
                              $('#deprecate_name').removeClass('border_none');
                          });
                          $(this).parent().removeClass('check_ok');
                      };
                  }


                  // số điện thoại
                  if($json.telephone !=''){
                      var regex_phone = /^0\d{9}$/;
                      if (regex_phone.test($json.telephone)) {
                          $("#deprecate_phone").removeClass("error_input");
                          $("#deprecate_phone").addClass("success_input");
                          $('#show-error-phone').css("display",'none');
                          $("#deprecate_phone").parent().addClass('check_ok');
                          $('#deprecate_phone').on('blur',function () {
                              $('#deprecate_phone').addClass('border_none');
                          });
                      }else{
                          $(this).removeClass("success_input");
                          $(this).addClass("error_input");
                          $('#show-error-phone').html("Số điện thoại gồm 10 số, bắt đầu từ số 0");
                          $('#show-error-phone').css("display",'block');
                          $(this).parent().removeClass('check_ok');
                          $('#deprecate_phone').on('blur',function () {
                              $('#deprecate_phone').removeClass('border_none');
                          });
                      };
                  }

                  // địa chỉ
                  if($json.address !=''){
                      $("#deprecate_address").removeClass("error_input");
                      $("#deprecate_address").addClass("success_input");
                      $('#show-error-address').css("display",'none');
                      $("#deprecate_address").parent().addClass('check_ok');
                      $('#deprecate_address').on('blur',function () {
                          $('#deprecate_address').addClass('border_none');
                      });
                  }

                  if($json.email !=''){
                      var regex_email = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                      if(regex_email.test($json.email)){
                          $("#deprecate_email").removeClass("error_input");
                          $("#deprecate_email").addClass("success_input");
                          $('#show-error-email').css("display",'none');
                          $("#deprecate_email").parent().addClass('check_ok');
                          $('#deprecate_email').on('blur',function () {
                              $('#deprecate_email').addClass('border_none');
                          });
                      }else{
                          $("#deprecate_email").removeClass("success_input");
                          $("#deprecate_email").addClass("error_input");
                          $('#show-error-email').css("display",'block');
                          $("#deprecate_email").parent().removeClass('check_ok');
                          $('#deprecate_email').on('blur',function () {
                              $('#deprecate_email').removeClass('border_none');
                          });
                      };
                  }

                  if($json.city !=''){
                      $('.value-city').css('font-family','Text-Regular');
                      $('.select-city').addClass('check_ok');
                  }

                // end check v

              }else{
                alert('Mã khách hàng hoặc mã giảm giá không đúng, bạn vui lòng kiểm tra lại !');
              }
            }
        });

    });

    $("#deprecate_name").on("keyup",function(){
        var value= $(this).val();
        $('.deprecate_name').html(value);
        var regex_name = /^[a-zA-Z ÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚĂĐĨŨƠàáâãèéêìíòóôõùúăđĩũơƯĂẠẢẤẦẨẪẬẮẰẲẴẶẸẺẼỀỀỂưăạảấầẩẫậắằẳẵặẹẻẽềềểỄỆỈỊỌỎỐỒỔỖỘỚỜỞỠỢỤỦỨỪễệỉịọỏốồổỗộớờởỡợụủứừỬỮỰỲỴÝỶỸửữựỳỵỷỹ\\s]+$/;
        if (regex_name.test(value)) {
            $(this).removeClass("error_input");
            $(this).addClass("success_input");
            // $(this).parent().find('.fa-check-circle').css('display','block');
            $('#show-error-name').css("display",'none');
            $(this).parent().addClass('check_ok');
            $('#deprecate_name').on('blur',function () {
                $('#deprecate_name').addClass('border_none');
            });
        }else{
            $(this).removeClass("success_input");
            $(this).addClass("error_input");
            $('#deprecate_name').on('blur',function () {
                $('#deprecate_name').removeClass('border_none');
            });
            // $(this).parent().find('.fa-check-circle').css('display','none');
            $('#show-error-name').html("Họ tên phải là ký tự từ a-z");
            $('#show-error-name').css("display",'block');
            $(this).parent().removeClass('check_ok');
        };
        check_thanh_nang();
    });


    $("#deprecate_phone").on("keyup",function(){
        var value= $(this).val();
        $('.deprecate_phone').html(value);
        var regex_phone = /^0\d{9}$/;
        if (regex_phone.test(value)) {
            $(this).removeClass("error_input");
            $(this).addClass("success_input");
            $('#show-error-phone').css("display",'none');
            $(this).parent().addClass('check_ok');
            $('#deprecate_phone').on('blur',function () {
                $('#deprecate_phone').addClass('border_none');
            });
        }else{
            $(this).removeClass("success_input");
            $(this).addClass("error_input");
            $('#show-error-phone').html("Số điện thoại gồm 10 số, bắt đầu từ số 0");
            $('#show-error-phone').css("display",'block');
            $(this).parent().removeClass('check_ok');
            $('#deprecate_phone').on('blur',function () {
                $('#deprecate_phone').removeClass('border_none');
            });
        };
        check_thanh_nang();
    });
    $("#deprecate_address").on("keyup",function(){
        var value= $(this).val();
        $('.deprecate_address').html(value);
        var regex_phone = /^0\d{9}$/;
        if (value !='') {
            $(this).removeClass("error_input");
            $(this).addClass("success_input");
            $('#show-error-address').css("display",'none');
            $(this).parent().addClass('check_ok');
            $('#deprecate_address').on('blur',function () {
                $('#deprecate_address').addClass('border_none');
            });
        }else{
            $(this).removeClass("success_input");
            $(this).addClass("error_input");
            $('#show-error-address').css("display",'block');
            $(this).parent().removeClass('check_ok');
            $('#deprecate_address').on('blur',function () {
                $('#deprecate_address').removeClass('border_none');
            });
        };
        check_thanh_nang();
    });


    $(".selected-city").click(function(){
        var value = $(this).html();
        $('.deprecate_city').html(value);
        $('#click-city').val(value);
        $('.select-city').addClass('check_ok');
        $('.value-city').addClass('border_none');
        check_thanh_nang();
    });


    $("#selected-city").on("keyup",function(){
        $('#show-error-city').css("display",'block');
        return false;
    });
    $('#show-error-city').css("display",'none');  

    $("#selected-paymethod").on("keyup",function(){
        $('#show-error-method').css("display",'block');
        return false;
    });
    $('#show-error-method').css("display",'none');



    $("#deprecate_email").on("keyup",function(){
        var value= $(this).val();
        $('.deprecate_email').html(value);
        var regex_email = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        if (value !='') {
            if(regex_email.test(value)){
                $(this).removeClass("error_input");
                $(this).addClass("success_input");
                $('#show-error-email').css("display",'none');
                $(this).parent().addClass('check_ok');
                $('#deprecate_email').on('blur',function () {
                    $('#deprecate_email').addClass('border_none');
                });
            }else{
                $(this).removeClass("success_input");
                $(this).addClass("error_input");
                $('#show-error-email').css("display",'block');
                $(this).parent().removeClass('check_ok');
                $('#deprecate_email').on('blur',function () {
                    $('#deprecate_email').removeClass('border_none');
                });
            };
        }else{
            $(this).parent().removeClass('check_ok');
            $(this).removeClass('error_input');
        }
        check_thanh_nang();
    });



    $(".select-method").click(function(){
        var value = $(this).html();
        $id = $(this).attr( "data-id" );
        $('.method_pay').html(value);
        $('#click-method').val(value);
        $('#show-error-method').css("display",'none');
        $.ajax({url: "index.php?module=paynow&view=paynow&task=get_method&raw=1",
            data: {id: $id},
            dataType: "json",
            success : function($json){
                $('.method_des').html($json.html);
            }
        });
        check_thanh_nang();
    });

    $("#comment").on("keyup",function(){
        var value= $(this).val();
        $('.comment').html(value);
        check_thanh_nang();
    });



    /* FORM CONTACT */
    $('#submitbt').click(function(){
        // if(checkFormsubmit()){
            // document.form_register.submit();
        // }
    });
});


function check_thanh_nang() {
    if($('#click-method').val() !='' && $('#click-city').val !='' && $('#deprecate_name').val() !='' && $('#deprecate_phone').val() !='' && $('#deprecate_address').val() !=''){
        $('#step-success').attr('src','/templates/default/images/img_svg/trangchu/process-01.svg');
        $('.text-thanh-ngang').css('font-family','Text-bold');
    }else{
        $('#step-success').attr('src','/templates/default/images/img_svg/trangchu/process-02.svg');
        $('.text-thanh-ngang').css('font-family','Text-regular');
    }
}




function checkFormsubmit()
{

    var deprecate_name = document.forms['form-default']['deprecate_name'].value;
    var deprecate_phone = document.forms['form-default']['deprecate_phone'].value;
    var deprecate_address = document.forms['form-default']['deprecate_address'].value;
    var deprecate_email = document.forms['form-default']['deprecate_email'].value;
    // var deprecate_comment = document.forms['form-default']['deprecate_comment'].value;

    var filterEmail = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

    if(deprecate_name == ''){
        $('#deprecate_name').addClass("error_input");
        $('#show-error-name').css("display",'block');
        // var id_block = document.getElementById("deprecate_name");
        // id_block.scrollIntoView({
        //     behavior: 'auto',
        //     block: 'center',
        //     inline: 'center',
        // });
        $('#deprecate_name').focus();
        return false;
    }
    else{
        if(/^[a-zA-Z ÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚĂĐĨŨƠàáâãèéêìíòóôõùúăđĩũơƯĂẠẢẤẦẨẪẬẮẰẲẴẶẸẺẼỀỀỂưăạảấầẩẫậắằẳẵặẹẻẽềềểỄỆỈỊỌỎỐỒỔỖỘỚỜỞỠỢỤỦỨỪễệỉịọỏốồổỗộớờởỡợụủứừỬỮỰỲỴÝỶỸửữựỳỵỷỹ\\s]+$/.test(deprecate_name)==false){
            var id_block = document.getElementById("deprecate_name");
            $('#deprecate_name').focus();
            return false;
        }
    }

    if(deprecate_phone == ''){
        $('#deprecate_phone').addClass("error_input");
        $('#show-error-phone').css("display",'block');
        // var id_block = document.getElementById("deprecate_phone");
        // id_block.scrollIntoView({
        //     behavior: 'auto',
        //     block: 'center',
        //     inline: 'center',
        // });
        $('#deprecate_phone').focus();
        return false;
    }
    else{
        if(/^0\d{9}$/.test(deprecate_phone)==false){
            var id_block = document.getElementById("deprecate_phone");
            // id_block.scrollIntoView({
            //     behavior: 'smooth',
            //     block: 'center',
            //     inline: 'center',
            // });
            $('#deprecate_phone').focus();
            return false;
        }
    }
    if(deprecate_address == ''){
        $('#deprecate_address').addClass("error_input");
        $('#show-error-address').css("display",'block');
        // var id_block = document.getElementById("deprecate_address");
        // id_block.scrollIntoView({
        //     behavior: 'auto',
        //     block: 'center',
        //     inline: 'center',
        // });
        $('#deprecate_address').focus();
        return false;
    }

    if($('#selected-city').val()==''){
        $('#show-error-city').css("display",'block');
        $('#show-error-city').focus();
        return false;
    }
    $('#show-error-city').css("display",'none');


    if(deprecate_email != ''){
        if(filterEmail.test(deprecate_email)==false){
            var id_block = document.getElementById("deprecate_email");
            // id_block.scrollIntoView({
            //     behavior: 'smooth',
            //     block: 'center',
            //     inline: 'center',
            // });
            $('#deprecate_email').focus();
            return false;
        }
    }

    if($('#selected-paymethod').val()==''){
        $('#show-error-method').css("display",'block');
        $('#show-error-method').focus();
        return false;
    }
    $('#show-error-method').css("display",'none');

    document.forms['form-default'].submit();
}