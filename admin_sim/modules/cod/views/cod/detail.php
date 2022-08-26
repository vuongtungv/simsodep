<?php
    $title = @$data ? FSText :: _('Edit'): FSText :: _('Add'); 
    global $toolbar;
    $toolbar->setTitle($title);
    $toolbar->addButton('save_add',FSText :: _('Save and new'),'','save_add.png');
    $toolbar->addButton('apply',FSText :: _('Apply'),'','apply.png'); 
    $toolbar->addButton('Save',FSText :: _('Save'),'','save.png'); 
    $toolbar->addButton('back',FSText :: _('Cancel'),'','cancel.png');   

	$this -> dt_form_begin(1,4,$title.' '.FSText::_('COD'));
?>

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

<?php
    TemplateHelper::dt_edit_text(FSText :: _('Sim'),'sim',@$data -> sim);
    TemplateHelper::dt_edit_text(FSText :: _('Giá'),'price',format_money(@$data -> price,''));
    // TemplateHelper::dt_edit_text(FSText :: _('Giá cọc'),'price_first',format_money(@$data -> price_first,''));
?>
    <div class="form-group">
        <label class="col-md-3 col-xs-12 control-label">Giá cọc</label>
        <div class="col-md-9 col-xs-12">
            <input type="text" class="form-control numeric change_price" data-v-min="0" data-v-max="999999999999" name="price_first" id="price_first" value="<?php echo @$data->price_first ?>" size="60" maxlength="255">
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-3 col-xs-12 control-label">Giá thu</label>
        <div class="col-md-9 col-xs-12">
            <input type="text" class="form-control numeric change_price" data-v-min="0" data-v-max="999999999999" name="price_last" id="price_last" value="<?php echo @$data->price_last ?>" size="60" maxlength="255">
        </div>
    </div>
<?php 
	// TemplateHelper::dt_edit_text(FSText :: _('Giá thu'),'price_last',format_money(@$data -> price_last,''));
    TemplateHelper::dt_edit_text(FSText :: _('Điện thoại'),'phone',@$data -> phone);
    TemplateHelper::dt_edit_text(FSText :: _('Mã bưu phẩm'),'code',@$data -> code);
    TemplateHelper::datetimepicke( FSText :: _('Ngày chuyển' ), 'day', @$data->day?@$data->day:date('Y-m-d H:i:s'), FSText :: _('Bạn vui lòng chọn thời gian bắt đầu chuyển sim'), 20,'','col-md-3','col-md-4');
    TemplateHelper::dt_edit_selectbox('Thu tiền','take',@$data -> take,0,$this -> arr_money,$field_value = '', $field_label='');
    TemplateHelper::dt_edit_selectbox('Trạng thái','status',@$data -> status,0,$this -> arr_status,$field_value = '', $field_label='');
    TemplateHelper::dt_edit_text(FSText :: _('Ghi chú'),'note',@$data -> note,'',5,5,0);
	// TemplateHelper::dt_checkbox(FSText::_('Published'),'published',@$data -> published,1);
	// TemplateHelper::dt_edit_text(FSText :: _('Ordering'),'ordering',@$data -> ordering,@$maxOrdering,'20','','','','','col-md-2','col-md-2');
    
	$this -> dt_form_end(@$data);

?>
 
<script type="text/javascript">

    jQuery(function($) {
        $('#price_first').autoNumeric('init');
    });

    $("#price_first").keyup(function(){
        price = $("#price").val();
        price = price.split(',').join('');
        price = parseInt(price);

        price_first = $("#price_first").val();
        price_first = price_first.split(',').join('');
        price_first = parseInt(price_first);

        price_last = price - price_first;

      // alert(price_revice); 
        price_last = formatMoney(price_last);
        $("#price_last").val(price_last);


    });

    function formatMoney(moth_format) {
        var moth_format = moth_format.toString();
        var format_money = "";
        while (parseInt(moth_format) > 999) {
            format_money = "," + moth_format.slice(-3) + format_money;
            moth_format = moth_format.slice(0, -3);
        }
        moth_format = moth_format + format_money;
        return moth_format;
    };

</script>
		
