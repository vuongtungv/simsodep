<script language="javascript" type="text/javascript" src="../libraries/jquery/jquery.ui/jquery-ui.js"></script>
<link rel="stylesheet" type="text/css" media="screen" href="../libraries/jquery/jquery.ui/jquery-ui.css" />
<?php  
// var_dump($_SESSION);
	global $toolbar;
	$toolbar->setTitle(FSText :: _('Tra cứu sim') );
	$toolbar->addButton('save_all',FSText :: _('Save'),'','save.png'); 
	$toolbar->addButton('delete',FSText :: _('Remove'),FSText :: _('You must select at least one record'),'remove.png');	
	//	FILTER

	$fitler_config[]  = array();
?>
    <div class="form-inline" style="margin-bottom: 10px;">
      <div class="form-group">
        <input placeholder="Số sim" type="text" class="form-control" id="sim" value=" <?php echo @$_SESSION['sim'] ?>">
      </div>
<!--       <div class="form-group">
        <input placeholder="Từ giá" type="text" class="form-control" id="price_min">
      </div>
      <div class="form-group">
        <input type="text" class="form-control" id="price_max">
      </div> -->
      <div class="form-group">
        <select class="form-control" id="agency" >
            <option value="">Đại lý</option>
            <?php foreach ($partner as $item) {
                $active = @$_SESSION['agency'] == $item->id ? 'selected':'';
             ?>
                <option <?php echo $active ?> value="<?php echo $item->id ?> "><?php echo $item->full_name ?></option>
            <?php } ?>
        </select>
      </div>
      <div class="form-group">
        <select class="form-control" id="network" >
            <option value="">Nhà mạng</option>
            <?php foreach ($network as $item) { 
                $active = @$_SESSION['network'] == $item->id ? 'selected':'';
             ?>
                <option <?php echo $active ?> value="<?php echo $item->id ?> "><?php echo $item->name ?></option>
            <?php } ?>
        </select>
      </div>
      <div class="form-group">
        <select class="form-control" id="type" >
            <option value="">Thể loại</option>
            <?php foreach ($type as $item) { 
                $active = @$_SESSION['type'] == $item->alias ? 'selected':'';
             ?>
                <option <?php echo $active ?> value="<?php echo $item->alias ?> "><?php echo $item->name ?></option>
            <?php } ?>
        </select>
      </div>
      <div class="form-group">
        <select class="form-control" id="admin_status" >
            <option value="">Trạng thái</option>
            <?php foreach ($array_obj_admin_status as $item) { 
                $active = @$_SESSION['admin_status'] && @$_SESSION['admin_status'] == $item->id ? 'selected':'';
             ?>
                <option <?php echo $active ?> value="<?php echo $item->id ?> "><?php echo $item->name ?></option>
            <?php } ?>
        </select>
      </div>
      <div class="form-group">
        <select class="form-control" id="status" >
            <option value="">Tình trạng</option>
            <?php foreach ($array_obj_status as $item) { 
                $active = @$_SESSION['status'] && @$_SESSION['status'] == $item->id ? 'selected':'';
             ?>
                <option <?php echo $active ?> value="<?php echo $item->id ?> "><?php echo $item->name ?></option>
            <?php } ?>
        </select>
      </div>
      <a id="reset_search" class="btn btn-danger" href="<?php echo URL_ROOT.URL_ROOT_ADMIN ?>index.php?module=sim&view=search&task=reset">Reset</a>
      <a id="search_sim" class="btn btn-primary">Tra cứu</a>
    </div>
<?php
	//	CONFIG	
	$list_config = array();
	$list_config[] = array('title'=>'Sim','field'=>'sim','ordering'=> 1,'align'=>'left', 'type'=>'text');
	$list_config[] = array('title'=>'Giá bán','field'=>'price_public','ordering'=> 1, 'type'=>'format_money');
	$list_config[] = array('title'=>'Giá đại lý','field'=>'price','ordering'=> 1, 'type'=>'format_money');
	$list_config[] = array('title'=>'Chiết khấu','field'=>'commission_value','ordering'=> 1, 'type'=>'commission');
  $list_config[] = array('title'=>'Tiền lãi','field'=>'price','ordering'=> 1, 'type'=>'interest');
  $list_config[] = array('title'=>'Giá thu về','field'=>'price','ordering'=> 1, 'type'=>'price_receive');
	$list_config[] = array('title'=>'Đại lý','field'=>'agency_name','ordering'=> 1, 'type'=>'link_agency');
	// $list_config[] = array('title'=>'Website','field'=>'web','ordering'=> 1, 'type'=>'text');
    $list_config[] = array('title'=>'Tình trạng','field'=>'status','ordering'=> 1, 'type'=>'edit_selectbox','col_width' => '10%','arr_params'=>array('arry_select'=>$array_obj_status,'field_value'=>'id','field_label'=>'name','size'=>1));
    $list_config[] = array('title'=>'Trạng thái','field'=>'admin_status','ordering'=> 1, 'type'=>'admin_status','col_width' => '10%','arr_params'=>array('arry_select'=>$array_obj_admin_status,'field_value'=>'id','field_label'=>'name','size'=>1));
	// $list_config[] = array('title'=>'Loại sim','field'=>'cat_name','ordering'=> 1, 'type'=>'text');
    $list_config[] = array('title'=>'Ngày cập nhật','field'=>'created_time','ordering'=> 1, 'type'=>'datetime');
	$list_config[] = array('title'=>'Tạo đơn','field'=>'order','ordering'=> 1, 'type'=>'order');
  $list_config[] = array('title'=>'Ghi chú','field'=>'note','ordering'=> 1, 'type'=>'note');
    // $list_config[] = array('title'=>'Ngày hiển thị','field'=>'public_time','ordering'=> 1, 'type'=>'datetime');

	TemplateHelper::genarate_form_liting($this->module,$this -> view,$list,$fitler_config,$list_config,$sort_field,$sort_direct,$pagination);
?>

<div class="panel panel-info">
    <div class="col-lg-12 col-xs-12 ">
        <div class="panel-heading">
            <i class="fa fa-th-list"></i>
            <?php echo FSText::_('Lịch sử') ?>
        </div>
        <table style="background: #ffffff" class="table table-striped table-bordered table-hover panel-body">
          <thead>
            <tr>
              <th width="30">STT</th>
              <th>Nội dung</th>
              <th>Số sim</th>
              <th>Số điện thoại khách hàng</th>
              <th>Thời gian tạo</th>
              <th>Nhân viên</th>
            </tr>
          </thead>
          <tbody>
                <?php $i=1; foreach ($notes as $item) {
                ?>
                <tr id="row_<?php echo $item->id ?>">
                    <td width="30"><?php echo $i ?></td>
                    <td><?php echo $item->note ?></td>
                    <td><?php echo $item->sim ?></td>
                    <td><?php echo $item->phone ?></td>
                    <td><?php echo date('d/m/Y H:i', strtotime($item->created_time)); ?></td>
                    <td><?php echo $item->user_name ?></td>
                    <td>
                        <a value="<?php echo $item->id ?>" class="btn_order delete_sim" href="<?php echo 'index.php?module=sim&view=search&task=delete_history&id='.$item->id ?>">Xóa</a>
                    </td>
                </tr>
                <?php $i++; } ?>
        </tbody>
        </table>
    </div>
</div>
<div class="modal fade bs-modal-md" id="small" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
        <form class="form-horizontal" role="form" method="post" action="#" name="note" >
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 id="title_note" class="modal-title">Ghi chú</h4>
            </div>
            <div class="modal-body">
                <div class="portlet-body form">
                        <div class="form-body">

                            <input type="hidden" name="product_note" id="product_note" value="">
                            <input type="hidden" name="module" value="sim" />
                            <input type="hidden" name="view" value="search" />
                            <input type="hidden" name="task" value="save_note" />

                            <div class="form-group">
                                <label class="col-md-3 control-label">Số điện thoại khách hàng</label>
                                <div class="col-md-9">
                                    <input required type="text" class="form-control" placeholder="" id="phone_note" name="phone_note"> </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Ghi chú</label>
                                <div class="col-md-9">
                                <textarea required class="form-control" rows="3" id="note_note" name="note_note"></textarea> </div>
                            </div>


                        </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
                <button type="submit" class="btn green">Ghi chú</button>
            </div>
            </form>
    </div>
  </div>
</div>

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
                                    <input type="text" class="form-control" placeholder="" id="email" name="email"> </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Địa chỉ</label>
                                <div class="col-md-9">
                                    <input required type="text" class="form-control" placeholder="" id="address" name="address"> 
                                </div>
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
                                <label class="col-md-3 control-label">Giá khuyến mại</label>
                                <div class="col-md-9">
                                    <input type="text" class="numeric form-control" data-v-min="0" data-v-max="999999999999" placeholder="" id="price_end" name="price_end"> </div>
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
                                <label class="col-md-3 control-label">Chiếu khấu (%)</label>
                                <div class="col-md-9">
                                    <input type="text" disabled class="form-control" placeholder="" id="commission" name="commission"> </div>
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
                                        <?php foreach ($method as $item) {?>
                                            <option value="<?php echo $item->id ?>"><?php echo $item->title ?></option>
                                        <?php } ?>
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

  function NoteFunction(id,name) {
    $('#title_note').html('Ghi chú sim : '+name);
      $('#product_note').val(name);
  }

    $("#phone").blur(function(){
        $phone = $('#phone').val();
        $price_public = $('#price_public').val();

        $.ajax({url: "<?php echo URL_ROOT.URL_ROOT_ADMIN ?>index.php?module=sim&view=sim&task=get_member&raw=1",
            data: {phone: $phone,price_public: $price_public},
            dataType: "json",
            success : function($json){
              $('#name').val($json.name);
              $('#code').val($json.code);
              $('#email').val($json.email);
              $('#city').val($json.city);
              $('#address').val($json.address);
              if ($json.price) {
                $('#price_end').val($json.price+' ('+$json.discount_name+')') ;
              }
            }
        });

    });

    $('#search_sim').click(function () {
    $sim = $('#sim').val();
    $agency = $('#agency').val();
    $network = $('#network').val();
    $type = $('#type').val();
    $admin_status = $('#admin_status').val();
    $status = $('#status').val();
        $.ajax({url: "<?php echo URL_ROOT.URL_ROOT_ADMIN ?>index.php?module=sim&view=search&task=search&raw=1",
            data: {sim: $sim, agency:$agency, network:$network, type: $type, admin_status:$admin_status, status:$status},
            dataType: "text",
            success: function (result) {
                location.reload();
            }
        });
    });

	function OrderFunction(id,name,price,price1,commission_value,commission_value1,price_public,price_public1) {
	  $('#title_order').html('Đặt sim : '+name);
      $('#product_order').val(id);
      $('#price').val(price1);
      $('#commission_value').val(commission_value1);
      $('#price_public').val(price_public1);
      commission_value1 = parseInt(commission_value1);
      price1 = parseInt(price1);
      commission = commission_value/price*100;
      $('#commission').val(commission);
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