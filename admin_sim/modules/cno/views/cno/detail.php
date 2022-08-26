<?php
    $title = @$data ? FSText :: _('Edit'): FSText :: _('Add'); 
    global $toolbar;
    $toolbar->setTitle($title);
    // $toolbar->addButton('save_add',FSText :: _('Save and new'),'','save_add.png');
    if (@$data -> status != 4 ) {
    $toolbar->addButton('apply',FSText :: _('Apply'),'','apply.png'); 
    $toolbar->addButton('Save',FSText :: _('Save'),'','save.png'); 
    }
    $toolbar->addButton('back',FSText :: _('Cancel'),'','cancel.png');  
    $this -> dt_form_begin(1,4,$title.' '.FSText::_('CNO'));
?>

<style type="text/css">
    #recive{
        font-weight: bold;
    }
</style>

    <table class="table table-bordered table-striped">
        <tbody>
            <tr>
                <td width="50%">
                  <?php if ($order_item) {?>
                  <table class="table table-bordered table-striped" style="background: #fff">
                    <thead>
                      <tr>
                        <th colspan="2"><i class="fa fa-cart-plus"></i>  Thông tin đơn hàng</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td  width="30%"><b>Số sim </b></td>
                        <td><?php echo $data->sim ?></td>
                      </tr>
                      <tr>
                        <td><b>Giá tiền </b></td>
                        <td><?php echo format_money($order_item->price_end) ?></td>
                      </tr>
                      <tr>
                        <td><b>Thời gian đăng sim</b></td>
                        <td><?php echo date('d/m/Y H:i', strtotime($order_item->time_create)); ?></td>
                      </tr>
                      <tr>
                        <td><b>Thời gian đặt hàng</b></td>
                        <td><?php echo date('d/m/Y H:i', strtotime($order_item->time_order)); ?></td>
                      </tr>
                      <tr>
                        <td><b>Đại lý </b></td>
                        <td><?php echo $order_item->agency_name ?></td>
                      </tr>
                      <tr>
                        <td><b>Số điện thoại đại lý</b></td>
                        <td><?php echo $order_item->agency_phone ?></td>
                      </tr>
                    </tbody>
                  </table>
                  <?php } ?>
                </td>
                <td>
                  <?php if ($order) {?>
                   <table class="table table-bordered table-striped" style="background: #fff">
                    <thead>
                      <tr>
                        <th colspan="2"><i class="fa fa-info-circle"></i>  Thông tin khách hàng</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td  width="30%"><b>Họ và tên</b></td>
                        <td><?php echo $order->recipients_name ?></td>
                      </tr>
                      <tr>
                        <td><b>Địa chỉ</b></td>
                        <td><?php echo $order->recipients_address ?></td>
                      </tr>
                      <tr>
                        <td><b>Số điện thoại </b></td>
                        <td><?php echo $order->recipients_mobilephone ?></td>
                      </tr>
                      <tr>
                        <td><b>Tỉnh thành</b></td>
                        <td><?php echo $order->recipients_city_name ?></td>
                      </tr>
                      <tr>
                        <td><b>Email</b></td>
                        <td><?php echo $order->recipients_email ?></td>
                      </tr>
                      <tr>
                        <td><b>Ghi chú </b></td>
                        <td><?php echo $order->recipients_comments ?></td>
                      </tr>
                    </tbody>
                  </table>
                  <?php } ?>
                </td>
            </tr>
        </tbody>
    </table>



  <div class="row">
      <div class="col-sm-6">
            <div class="form-group">
                <label class="col-md-3 col-xs-12 control-label">Đại lý bán cho</label>
                <div class="col-md-9 col-xs-12">
                    <select onchange="takeFunction()" data-placeholder="Thu tiền" class="form-control change_price" name="take" id="take">
                        <option value="0" <?php echo $data->take==0 ? 'selected':'' ?> >Không</option>
                        <option value="1" <?php echo $data->take==1 ? 'selected':'' ?> >Có</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-3 col-xs-12 control-label price_sell"><?php echo $data->take==0 ? 'Giá cuối':'Giá đối tác bán' ?></label>
                <div class="col-md-9 col-xs-12">
                    <input type="text" class="form-control numeric change_price" data-v-min="0" data-v-max="999999999999" name="price_sell" id="price_sell" value="<?php echo @$data->price_sell ?>" size="60" maxlength="255">
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-3 col-xs-12 control-label price_orginal"><?php echo $data->take==0 ? 'Giá đại lý':'Giá mình gửi bảng' ?></label>
                <div class="col-md-9 col-xs-12">
                    <input type="text" class="form-control numeric change_price" data-v-min="0" data-v-max="999999999999" name="price_orginal" id="price_orginal" value="<?php echo @$data->price_orginal ?>" size="60" maxlength="255">
                </div>
            </div>
<!--             <div class="form-group">
                <label class="col-md-3 col-xs-12 control-label">Ưu đãi từ đại lý</label>
                <div class="col-md-9 col-xs-12">
                    <input type="text" class="form-control numeric change_price" data-v-min="0" data-v-max="999999999999" name="price_commissions" id="price_commissions" value="<?php echo @$data->price_commissions ? '@$data->price_commissions':'0' ?>" size="60" maxlength="255">
                </div>
            </div> -->
            <div class="form-group">
                <label class="col-md-3 col-xs-12 control-label commissions"><?php echo $data->take==0 ? 'Hoa hồng':'Chiết khấu' ?></label>
                <div class="col-md-6 col-xs-12">
                    <input type="text" class="form-control numeric change_price" data-v-min="0" data-v-max="999999999999" name="commissions" id="commissions" value="<?php echo @$data->commissions ?>" size="60" maxlength="255">
                </div>
                <div class="col-md-3">
                    <input type="number" readonly class="form-control change_price" data-v-min="0" data-v-max="999999999999" name="commission_percent" id="commission_percent" value="<?php echo @$data->commission_percent ?>" size="60" maxlength="255">
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-3 col-xs-12 control-label price_partner"><?php echo $data->take==0 ? 'Số tiền phải trả đại lý':'Số tiền thu về' ?></label>
                <div class="col-md-9 col-xs-12">
                    <input type="text" class="form-control numeric change_price" data-v-min="0" data-v-max="999999999999" name="price_partner" id="price_partner" value="<?php echo @$data->price_partner ?>" size="60" maxlength="255">
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-3 col-xs-12 control-label price_partner_end"><?php echo $data->take==0 ? 'Số tiền thực phải trả đại lý':'Số tiền thực thu về' ?></label>
                <div class="col-md-9 col-xs-12">
                    <input type="text" class="form-control numeric change_price" data-v-min="0" data-v-max="999999999999" name="price_partner_end" id="price_partner_end" value="<?php echo @$data->price_partner_end ?>" size="60" maxlength="255">
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-3 col-xs-12 control-label price_interest"><?php echo $data->take==0 ? 'Số tiền lãi':'Đối tác lãi' ?></label>
                <div class="col-md-9 col-xs-12">
                    <input type="text" readonly class="form-control numeric" data-v-min="0" data-v-max="999999999999" name="price_interest" id="price_interest" value="<?php echo @$data->price_interest ?>" size="60" maxlength="255">
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-3 col-xs-12 control-label price_revice"><?php echo $data->take==0 ? 'Số tiền tự thu của khách':'Đối tác tự thu' ?></label>
                <div class="col-md-9 col-xs-12">
                    <input type="text" class="form-control numeric change_price" data-v-min="0" data-v-max="999999999999" name="price_revice" id="price_revice" value="<?php echo @$data->price_revice  ? @$data->price_revice:'0' ?>" size="60" maxlength="255">
                </div>
            </div>
      </div>
      <div class="col-sm-6">
            <div class="form-group">
                <label class="col-md-3 col-xs-12 control-label partner_recive"><?php echo $data->take==0 ? 'Số tiền đại lý thu hộ':'Mình thu hộ' ?></label>
                <div class="col-md-9 col-xs-12">
                    <input type="text" class="form-control numeric change_price" data-v-min="0" data-v-max="999999999999" name="partner_recive" id="partner_recive" value="<?php echo @$data->partner_recive ?>" size="60" maxlength="255">
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-3 col-xs-12 control-label">Phí hỗ trợ giao dịch</label>
                <div class="col-md-9 col-xs-12">
                    <input type="text" class="form-control numeric change_price" data-v-min="0" data-v-max="999999999999" name="price_support" id="price_support" value="<?php echo @$data->price_support ? @$data->price_support:'0' ?>" size="60" maxlength="255">
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-3 col-xs-12 control-label">Trả thu</label>
                <div class="col-md-9 col-xs-12">
                    <input type="text" readonly class="form-control" data-v-min="0" data-v-max="999999999999" name="recive" id="recive" value="<?php echo @$data->recive ?>" size="60" maxlength="255" style="<?php echo @$data->recive >= 0 ? 'color: blue':'color: red'; ?>">
                </div>
            </div>
<?php 

            TemplateHelper::dt_edit_selectbox(FSText::_('Tên đại lý giao dịch'),'agency',@$data -> agency,0,$agency,$field_value = 'id', $field_label='full_name',$size = 1,0,1);
            TemplateHelper::dt_edit_selectbox('Trạng thái','status',@$data -> status,0,$this -> arr_status,$field_value = '', $field_label='');
            TemplateHelper::dt_edit_selectbox(FSText::_('Nhân viên bán hàng'),'user_id',@$data -> user_id,0,$customer,$field_value = 'id', $field_label='full_name',$size = 1,0,1);


?>
            <div class="form-group">
                <label class="col-md-3 col-xs-12 control-label">Ghi chú</label>
                <div class="col-md-9 col-xs-12">
                    <textarea placeholder="" class="form-control" rows="4" cols="60" name="note" id="note"><?php echo @$data->note ?></textarea>
                </div>
            </div>
      </div>
  </div>

<?php
    
	$this -> dt_form_end(@$data);

?>
<script type="text/javascript">

    $( document ).ready(function() {
        takeFunction();

        tt = $("#recive").val();
        // alert(tt);
        tt = formatMoney(tt);
        $("#recive").val(tt);
    });

    function takeFunction(){
        take = $("#take").val();
        if (take == 0) {
            $(".price_sell").html('Giá cuối');
            $(".price_orginal").html('Giá đại lý');
            $(".commissions").html('Hoa hồng');
            $(".price_partner").html('Số tiền phải trả đại lý');
            $(".price_partner_end").html('Số tiền thực phải trả đại lý');
            $(".price_interest").html('Số tiền lãi');
            $(".price_revice").html('Số tiền tự thu của khách');
            $(".partner_recive").html('Số tiền đại lý thu hộ');
        }
        if (take == 1) {
            $(".price_sell").html('Giá đối tác bán');
            $(".price_orginal").html('Giá mình gửi bảng');
            $(".commissions").html('Chiết khấu');
            $(".price_partner").html('Số tiền thu về');
            $(".price_partner_end").html('Số tiền thực thu về');
            $(".price_interest").html('Đối tác lãi');
            $(".price_revice").html('Đối tác tự thu');
            $(".partner_recive").html('Mình thu hộ');
        }
    }

    $(".change_price").keyup(function(){

        price_sell = $("#price_sell").val();
        price_sell = price_sell.split(',').join('');
        price_sell = parseInt(price_sell);

        price_orginal = $("#price_orginal").val();
        price_orginal = price_orginal.split(',').join('');
        price_orginal = parseInt(price_orginal);

        commissions = $("#commissions").val();
        commissions = commissions.split(',').join('');
        commissions = parseInt(commissions);

        price_partner = $("#price_partner").val();
        price_partner = price_partner.split(',').join('');
        price_partner = parseInt(price_partner);

        price_partner_end = $("#price_partner_end").val();
        price_partner_end = price_partner_end.split(',').join('');
        price_partner_end = parseInt(price_partner_end);

        price_interest = $("#price_interest").val();
        price_interest = price_interest.split(',').join('');
        price_interest = parseInt(price_interest);

        price_revice = $("#price_revice").val();
        price_revice = price_revice.split(',').join('');
        if (!price_revice) {price_revice = 0}
        price_revice = parseInt(price_revice);


        partner_recive = $("#partner_recive").val();
        partner_recive = partner_recive.split(',').join('');
        partner_recive = parseInt(partner_recive);

        price_support = $("#price_support").val();
        price_support = price_support.split(',').join('');
        if (!price_support) {price_support = 0}
        price_support = parseInt(price_support);

        // tính phần trăm giá trị hoa hồng
        commission_percent = commissions/price_orginal*100;
        commission_percent = Math.round(commission_percent);
        $("#commission_percent").val(commission_percent);

        // kiểm tra đại lý bán cho có hay không
        take = $("#take").val();
        if (take == 0) {

            // alert(0);

            //nếu có giá trị tiền tự thu khách
            if (price_revice > 0) {
                // số tiền đại lý thu hộ
                partner_recive = price_sell - price_revice;
                $("#price_interest").val(partner_recive);

                // tiền thực trả đại lý
                partner_end = price_partner - price_support;
                $("#price_partner_end").val(partner_end);

                // trả thu
                recive = partner_recive - partner_end;
                $("#recive").val(recive);
            }

            // số tiền trả đại lý
            price_partner = price_orginal - commissions;

            //nếu không có giá trị tự thu khách
                if (price_revice == 0) {
                    //số tiền thực trả đại lý
                    price_partner_end = price_partner - price_support;
                    // tiền lãi
                    price_interest = price_sell - price_partner_end;
                    // tính lại tiền đại lý thu hộ
                    partner_recive = price_interest + price_partner_end;
                    //trả thu
                    // recive = price_interest;
                    recive = partner_recive - price_partner_end;
                }

            //nếu có giá trị tự thu khách
                if (price_revice > 0) {
                    // số tiền đại lý thu hộ
                    partner_recive = price_sell - price_revice;
                    //số tiền thực trả đại lý
                    price_partner_end = price_partner - price_support;
                    // trả thu
                    recive = partner_recive - price_partner_end;
                }
      // alert(partner_recive); 
        }

        if (take == 1) {

            // alert(1);

            //nếu có giá trị tiền thu hộ
            if (price_revice > 0) {
                // số tiền đại lý thu hộ
                partner_recive = price_sell - price_revice;
                $("#price_interest").val(partner_recive);

                // tiền thực trả đại lý
                partner_end = price_partner - price_support;
                $("#price_partner_end").val(partner_end);

                // trả thu
                recive = partner_recive - partner_end;
                $("#recive").val(recive);
            }

            // số tiền thu về
            price_partner = price_orginal - commissions;

            //nếu không có giá trị thu hộ
                if (price_revice == 0) {
                    //số tiền thực thu về
                    price_partner_end = price_partner - price_support;
                    // tiền lãi
                    price_interest = price_sell - price_partner_end;
                    // tính lại tiền đại lý thu hộ
                    partner_recive = price_interest + price_partner_end;
                    //trả thu
                    recive = price_partner_end - partner_recive;
                }

            //nếu có giá trị đối tác thu hộ
                if (price_revice > 0) {
                    // số tiền đại lý thu hộ
                    partner_recive = price_sell - price_revice;
                    //số tiền thực trả đại lý
                    price_partner_end = price_partner - price_support;
                    // trả thu
                    recive = price_partner_end - partner_recive;
                }
      // alert(price_revice); 
        }

        price_partner = formatMoney(price_partner);
        $("#price_partner").val(price_partner);

        price_partner_end = formatMoney(price_partner_end);
        $("#price_partner_end").val(price_partner_end);

        price_interest = formatMoney(price_interest);
        $("#price_interest").val(price_interest);

        partner_recive = formatMoney(partner_recive);
        $("#partner_recive").val(partner_recive);

        if (recive<0) {
            $("#recive").css("color", "red");
        }
        if (recive>0) {
            $("#recive").css("color", "blue");
        }
        recive = formatMoney(recive);
        $("#recive").val(recive);


    });

    $("#take").change(function(){

        price_sell = $("#price_sell").val();
        price_sell = price_sell.split(',').join('');
        price_sell = parseInt(price_sell);

        price_orginal = $("#price_orginal").val();
        price_orginal = price_orginal.split(',').join('');
        price_orginal = parseInt(price_orginal);

        commissions = $("#commissions").val();
        commissions = commissions.split(',').join('');
        commissions = parseInt(commissions);

        price_partner = $("#price_partner").val();
        price_partner = price_partner.split(',').join('');
        price_partner = parseInt(price_partner);

        price_partner_end = $("#price_partner_end").val();
        price_partner_end = price_partner_end.split(',').join('');
        price_partner_end = parseInt(price_partner_end);

        price_interest = $("#price_interest").val();
        price_interest = price_interest.split(',').join('');
        price_interest = parseInt(price_interest);

        price_revice = $("#price_revice").val();
        price_revice = price_revice.split(',').join('');
        if (!price_revice) {price_revice = 0}
        price_revice = parseInt(price_revice);


        partner_recive = $("#partner_recive").val();
        partner_recive = partner_recive.split(',').join('');
        partner_recive = parseInt(partner_recive);

        price_support = $("#price_support").val();
        price_support = price_support.split(',').join('');
        if (!price_support) {price_support = 0}
        price_support = parseInt(price_support);

        // tính phần trăm giá trị hoa hồng
        commission_percent = commissions/price_orginal*100;
        commission_percent = Math.round(commission_percent);
        $("#commission_percent").val(commission_percent);

        // kiểm tra đại lý bán cho có hay không
        take = $("#take").val();
        if (take == 0) {

            // alert(0);

            //nếu có giá trị tiền tự thu khách
            if (price_revice > 0) {
                // số tiền đại lý thu hộ
                partner_recive = price_sell - price_revice;
                $("#price_interest").val(partner_recive);

                // tiền thực trả đại lý
                partner_end = price_partner - price_support;
                $("#price_partner_end").val(partner_end);

                // trả thu
                recive = partner_recive - partner_end;
                $("#recive").val(recive);
            }

            // số tiền trả đại lý
            price_partner = price_orginal - commissions;

            //nếu không có giá trị tự thu khách
                if (price_revice == 0) {
                    //số tiền thực trả đại lý
                    price_partner_end = price_partner - price_support;
                    // tiền lãi
                    price_interest = price_sell - price_partner_end;
                    // tính lại tiền đại lý thu hộ
                    partner_recive = price_interest + price_partner_end;
                    //trả thu
                    // recive = price_interest;
                    recive = partner_recive - price_partner_end;
                }

            //nếu có giá trị tự thu khách
                if (price_revice > 0) {
                    // số tiền đại lý thu hộ
                    partner_recive = price_sell - price_revice;
                    //số tiền thực trả đại lý
                    price_partner_end = price_partner - price_support;
                    // trả thu
                    recive = partner_recive - price_partner_end;
                }
      // alert(partner_recive); 
        }

        if (take == 1) {

            // alert(1);

            //nếu có giá trị tiền thu hộ
            if (price_revice > 0) {
                // số tiền đại lý thu hộ
                partner_recive = price_sell - price_revice;
                $("#price_interest").val(partner_recive);

                // tiền thực trả đại lý
                partner_end = price_partner - price_support;
                $("#price_partner_end").val(partner_end);

                // trả thu
                recive = partner_recive - partner_end;
                $("#recive").val(recive);
            }

            // số tiền thu về
            price_partner = price_orginal - commissions;

            //nếu không có giá trị thu hộ
                if (price_revice == 0) {
                    //số tiền thực thu về
                    price_partner_end = price_partner - price_support;
                    // tiền lãi
                    price_interest = price_sell - price_partner_end;
                    // tính lại tiền đại lý thu hộ
                    partner_recive = price_interest + price_partner_end;
                    //trả thu
                    recive = price_partner_end - partner_recive;
                }

            //nếu có giá trị đối tác thu hộ
                if (price_revice > 0) {
                    // số tiền đại lý thu hộ
                    partner_recive = price_sell - price_revice;
                    //số tiền thực trả đại lý
                    price_partner_end = price_partner - price_support;
                    // trả thu
                    recive = price_partner_end - partner_recive;
                }
      // alert(price_revice); 
        }

        price_partner = formatMoney(price_partner);
        $("#price_partner").val(price_partner);

        price_partner_end = formatMoney(price_partner_end);
        $("#price_partner_end").val(price_partner_end);

        price_interest = formatMoney(price_interest);
        $("#price_interest").val(price_interest);

        partner_recive = formatMoney(partner_recive);
        $("#partner_recive").val(partner_recive);

        if (recive<0) {
            $("#recive").css("color", "red");
        }
        if (recive>0) {
            $("#recive").css("color", "blue");
        }
        recive = formatMoney(recive);
        $("#recive").val(recive);


    });

    // định dạng lại được cả số tiền âm
    function formatMoney(number) {
        number = parseFloat(number.toString().match(/^-?\d+\.?\d{0,2}/));
        //Seperates the components of the number
        var components = (Math.floor(number * 100) / 100).toString().split(".");
        //Comma-fies the first part
        components [0] = components [0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        //Combines the two sections
        return components.join(".");
    }

</script>
		
