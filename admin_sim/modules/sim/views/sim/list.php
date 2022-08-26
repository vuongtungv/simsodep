<script language="javascript" type="text/javascript" src="../libraries/jquery/jquery.ui/jquery-ui.js"></script>
<link rel="stylesheet" type="text/css" media="screen" href="../libraries/jquery/jquery.ui/jquery-ui.css" />
<?php  
	global $toolbar;
	$toolbar->setTitle(FSText :: _('Danh sách sim đã duyệt') );
	$toolbar->addButton('save_all',FSText :: _('Save'),'','save.png'); 
	// $toolbar->addButton('add',FSText :: _('Add'),'','add.png');  
	$toolbar->addButton('delete',FSText :: _('Remove'),FSText :: _('You must select at least one record'),'remove.png');	
	//	FILTER

	$filter_config  = array();
	$fitler_config['search'] = 1; 
    $fitler_config['text_count'] = 4;
    $fitler_config['filter_count'] = 4;

    $filter_categories = array();
	$filter_categories['title'] = FSText::_('Nhà mạng'); 
	$filter_categories['list'] = @$network; 
	$filter_categories['field'] = 'name';

	$filter_partner = array();
	$filter_partner['title'] = FSText::_('Đại lý'); 
	$filter_partner['list'] = @$partner; 
	$filter_partner['field'] = 'full_name';

    $filter_type = array();
    $filter_type['title'] = FSText::_('Loại sim'); 
    $filter_type['list'] = @$type; 
    $filter_type['field'] = 'name';

    $filter_status = array();
    $filter_status['title'] =  FSText::_('Trạng thái'); 
    $filter_status['list'] = @$array_obj_status;

    $text_from_date = array();
	$text_from_date['title'] =  FSText::_('Từ ngày'); 
	
	$text_to_date = array();
	$text_to_date['title'] =  FSText::_('Đến ngày');

	$text_from_price = array();
	$text_from_price['title'] =  FSText::_('Từ giá'); 
	
	$text_to_price = array();
	$text_to_price['title'] =  FSText::_('Đến giá');    
	
	$fitler_config['filter'][] = $filter_categories;
    $fitler_config['filter'][] = $filter_partner;
    $fitler_config['filter'][] = $filter_type;
	$fitler_config['filter'][] = $filter_status;
    $fitler_config['text'][] = $text_from_date;
	$fitler_config['text'][] = $text_to_date;	
	$fitler_config['text'][] = $text_from_price;
	$fitler_config['text'][] = $text_to_price;		


	//	CONFIG	
	$list_config = array();
	$list_config[] = array('title'=>'Sim','field'=>'sim','ordering'=> 1,'align'=>'left', 'type'=>'text');
	$list_config[] = array('title'=>'Nhà mạng','field'=>'network','ordering'=> 1, 'type'=>'text');
	$list_config[] = array('title'=>'Đại lý','field'=>'agency_name','ordering'=> 1, 'type'=>'text');
	$list_config[] = array('title'=>'Loại sim','field'=>'cat_name','ordering'=> 1, 'type'=>'text');
	$list_config[] = array('title'=>'Giá gốc','field'=>'price','ordering'=> 1, 'type'=>'format_money');
	$list_config[] = array('title'=>'Chiết khấu','field'=>'commission_value','ordering'=> 1, 'type'=>'format_money');
	$list_config[] = array('title'=>'Giá hiển thị','field'=>'price_public','ordering'=> 1, 'type'=>'format_money');
    $list_config[] = array('title'=>'Tình trạng','field'=>'status','ordering'=> 1, 'type'=>'edit_selectbox','col_width' => '10%','arr_params'=>array('arry_select'=>$array_obj_status,'field_value'=>'id','field_label'=>'name','size'=>1));
    // $list_config[] = array('title'=>'Trạng thái','field'=>'status','ordering'=> 1, 'type'=>'admin_status','col_width' => '10%','arr_params'=>array('arry_select'=>$array_obj_status,'field_value'=>'id','field_label'=>'name','size'=>1));
    $list_config[] = array('title'=>'Ngày tạo','field'=>'created_time','ordering'=> 1, 'type'=>'datetime');
	// $list_config[] = array('title'=>'Tạo đơn','field'=>'author','ordering'=> 1, 'type'=>'order');
    $list_config[] = array('title'=>'View','type'=>'edit');
    // $list_config[] = array('title'=>'Ngày hiển thị','field'=>'public_time','ordering'=> 1, 'type'=>'datetime');

	TemplateHelper::genarate_form_liting($this->module,$this -> view,$list,$fitler_config,$list_config,$sort_field,$sort_direct,$pagination);
?>

<div class="modal fade bs-modal-lg" id="large" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form class="form-horizontal" role="form" method="post" action="#" name="order" >
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 id="title_order" class="modal-title">Đặt sim</h4>
            </div>
            <div class="modal-body">
                <div class="portlet-body form">
                        <div class="form-body">

                        	<input type="hidden" name="product_order" id="product_order" value="">
                            <input type="hidden" name="module" value="order" />
                            <input type="hidden" name="view" value="order" />
                            <input type="hidden" name="task" value="save_order_cms" />

                            <div class="form-group">
                                <label class="col-md-3 control-label">Số điện thoại</label>
                                <div class="col-md-9">
                                    <input required type="text" class="form-control" placeholder="" id="phone" name="phone"> </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Mã khách hàng</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" placeholder="" id="code" name="code"> </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Tên khách hàng</label>
                                <div class="col-md-9">
                                    <input required type="text" class="form-control" placeholder="" id="name" name="name"> </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Email</label>
                                <div class="col-md-9">
                                    <input required type="text" class="form-control" placeholder="" id="email" name="email"> </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Tỉnh/thành phố</label>
                                <div class="col-md-9">
                                    <select class="form-control" id="city" name="city">
                                        <?php foreach ($city as $item) { ?>
                                            <option value="<?php echo $item->id ?>"><?php echo $item->name ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Giá bán</label>
                                <div class="col-md-9">
                                    <input type="text" class="numeric form-control" data-v-min="0" data-v-max="999999999999" placeholder="" id="price_public" name="price_public"> </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Giá đại lý</label>
                                <div class="col-md-9">
                                    <input type="text" disabled class="form-control" placeholder="" id="price" name="price" > </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Chiếu khấu</label>
                                <div class="col-md-9">
                                    <input type="text" disabled class="form-control" placeholder="" id="commission_value" name="commission_value"> </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Phương thức đặt cọc</label>
                                <div class="col-md-9">
                                    <select class="form-control" id="deposit" name="deposit">
                                        <option value="Thẻ cào">Thẻ cào</option> 
                                        <option value="Ngân hàng">Ngân hàng</option>
                                        <option value="Trực tiếp">Trực tiếp</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Phương thức thanh toán</label>
                                <div class="col-md-9">
                                    <select class="form-control" id="pay" name="pay">
                                        <option value="Trực tiếp">Trực tiếp</option>
                                        <option value="Ngân hàng">Ngân hàng</option>
                                        <option value="COD">COD</option>
                                        <option value="Ghi nợ">Ghi nợ</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Ghi chú</label>
                                <div class="col-md-9">
                                <textarea class="form-control" rows="3" id="note" name="note"></textarea> </div>
                            </div>


                        </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
                <button type="submit" class="btn green">Đặt sim</button>
            </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<script>
    $("#phone").blur(function(){
        $phone = $('#phone').val();

        $.ajax({url: "<?php echo URL_ROOT.URL_ROOT_ADMIN ?>index.php?module=sim&view=sim&task=get_member&raw=1",
            data: {phone: $phone},
            dataType: "json",
            success : function($json){
              $('#name').val($json.name);
              $('#code').val($json.code);
              $('#email').val($json.email);
              $('#city').val($json.city);
            }
        });

    });
	function OrderFunction(id,name,price,price1,commission_value,commission_value1,price_public,price_public1) {
	  $('#title_order').html('Đặt sim : '+name);
      $('#product_order').val(id);
      $('#price').val(price1);
      $('#commission_value').val(commission_value1);
      $('#price_public').val(price_public1);
	}
	$(function() {
		$( "#text0" ).datepicker({
		  clickInput:true,
          dateFormat: 'dd-mm-yy',
          changeMonth: true,
          numberOfMonths: 2,
          changeYear: true,
          maxDate:  " + d ",
          showMonthAfterYear: true
        });
		$( "#text1" ).datepicker({
		  clickInput:true,
          dateFormat: 'dd-mm-yy',
          changeMonth: true,
          numberOfMonths: 2,
          changeYear: true,
          maxDate:  " + d ",
          showMonthAfterYear: true
        });
	});
</script>