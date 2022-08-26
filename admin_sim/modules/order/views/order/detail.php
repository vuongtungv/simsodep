<!-- HEAD -->
<?php
	$title = @$order ? FSText :: _('Xem đơn hàng ').'DH'.str_pad($order -> id, 8 , "0", STR_PAD_LEFT): FSText :: _('Add'); 
	global $toolbar;
	$toolbar->setTitle($title);
	?>
<!-- END HEAD-->

<!-- BODY-->
<style>
    .btn_order{
        display: inline-block;
        border: 1px solid;
        padding: 3px 5px;
        margin: 0 5px;
        float: right;
    }
    .btn_order:hover{
        text-decoration: none;
    }
    select.form-control{
        height: 30px;
        padding: 0 12px;
        width: 50%;
    }
    input.form-control{
        height: 30px;
    }
    .table{
        margin-bottom: 0px;
    }
    .wrap-toolbar{
        margin-bottom: 10px;
    }
</style>

<div id="wrap-toolbar" class="wrap-toolbar affix-top" data-spy="affix" data-offset-top="197">   
    <div class="fr">
        <a class="toolbar"  href="index.php?module=order&view=order">
            <span title="Thoát" style="background:url('templates/default/images/toolbar/cancel.png') no-repeat"></span>Thoát
        </a>      
    </div>  
        <div class="clearfix"></div>
</div>

<div class="row">
    <div class="col-lg-6 col-xs-12">
        <div class="panel panel-info">
            <div class="panel-heading">
                <i class="fa fa-cart-plus"></i> 
                Chi tiết đơn đặt hàng: <strong><?php echo 'DH'.str_pad($order -> id, 8 , "0", STR_PAD_LEFT) ?></strong>
                <a class="btn_order" id="save_status" style="margin-left: 20px;" href="javascript:void(0)">Lưu</a>
            </div>
            <div class="panel-body">
                <?php $print = FSInput::get('print',0,'int');?>
                <?php if(!$print){?>
                <?php include_once 'detail_status.php';?>
                <?php }?>
            </div>
        </div>
    </div>
    
    <div class="col-lg-6 col-xs-12">
        <div class="panel panel-info">
            <div class="panel-heading">
                <i class="fa fa-info-circle"></i>
                <?php echo FSText::_('Thông tin người đặt hàng') ?>
                <a class="btn_order" id="save_info" style="margin-left: 20px;" href="javascript:void(0)">Lưu</a>
            </div>
            <div class="panel-body">
                <!--  SENDER INFO -->
                <?php include_once 'detail_buyer.php';?>
                <!--  end SENDER INFO --> 
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12 col-xs-12 ">
    <form class="panel panel-info" action="index.php?module=<?php echo $this -> module;?>&view=<?php echo $this -> view;?>"
    	name="adminForm" method="post" enctype="multipart/form-data">
        <div class="panel-heading">
            <i class="fa fa-th-list"></i>
            <?php echo FSText::_('Danh sách sim đặt mua') ?>
        </div>
        <table class="table table-striped table-bordered table-hover panel-body">
        	<thead>
        		<tr>
        			<th width="30">STT</th>
        			<th><?php echo FSText::_('Số Sim') ?></th>
                    <th><?php echo "Giá đại lý"; ?></th>
                    <th><?php echo "Chiết khấu"; ?></th>
                    <th><?php echo "Giá thu về"; ?></th>
                    <th><?php echo "Giá bán"; ?></th>
                    <th><?php echo "Giảm giá"; ?></th>
        			<th><?php echo "Gía cuối"; ?></th>
                    <th><?php echo "Tiền lãi"; ?></th>
                    <th><?php echo "Đại lý"; ?></th>
                    <th><?php echo "Số điện thoại"; ?></th>
                    <!-- <th><?php echo "Website"; ?></th> -->
                    <!-- <th><?php echo "Tỉnh thành"; ?></th> -->
                    <th><?php echo "Ngày đăng"; ?></th>
        			<th><?php echo "Thao tác"; ?></th>
        		</tr>
        	</thead>
        	<tbody>
                <?php $i=1; foreach ($data as $item) {
                ?>
                <tr id="row_<?php echo $item->id ?>">
                    <td width="30"><?php echo $i ?></td>
                    <td><?php echo $item->sim ?></td>
                    <td><?php echo format_money($item->price,'') ?></td>
                    <td><?php echo format_money($item->commission,'') ?>(<?php echo $item->commission_percent ?>%)</td>
                    <td><?php echo format_money($item->price_sell,'') ?></td>
                    <td><?php echo format_money($item->price_public,'') ?></td>
                    <?php 
                        $discount = '0%';
                        if ($item->discount_unit == 'price') {
                            $discount = format_money($item->discount,'đ');
                        }
                        if ($item->discount_unit == 'percent') {
                            $discount = $item->discount.'%';
                    } ?>
                    <td><?php echo $discount ?></td>
                    <td><?php echo format_money($item->price_end,'') ?></td>
                    <td><?php echo format_money($item->interest,'') ?></td>
                    <td><?php echo $item->agency_name ?></td>
                    <td><?php echo $item->agency_phone ?></td>
<!--                     <td><?php echo $item->agency_web ?></td> 
                    <td><?php echo $item->agency_city ?></td> -->
                    <td><?php echo date('d/m/Y H:i', strtotime($item->time_create)); ?></td>
                    <td>
                        <a value="<?php echo $item->id ?>" class="btn_order delete_sim" href="javascript:void(0)">Xóa</a>
                        <a class="btn_order" href="<?php echo 'index.php?module=order&view=order&task=cod&phone='.$item->number.'&price='.$item->price_end.'&number='.$order->recipients_mobilephone.'&order_item='.$item->id.'&order='.$order->id ?>">COD</a>
                        <a class="btn_order" href="<?php echo 'index.php?module=order&view=order&task=cno&id='.$order->id.'&phone='.$item->number.'&item='.$item->id ?>">CNO</a>
                    </td>
                </tr>
                <?php $i++; } ?>
    		</tbody>
        </table>
    		<?php if(@$data->id) { ?>
    		<input type="hidden" value="<?php echo $data->id; ?>" name="id">
    		<?php }?>
    		<input type="hidden" value="<?php echo $this -> module;?>" name="module"> 
            <input type="hidden" value="<?php echo $this -> view;?>" name="view"> 
            <input type="hidden" value="" name="task"> 
            <input type="hidden" value="0" name="boxchecked">
    </form>
    </div>
</div>

<div class="row">
    <div class="col-lg-6 col-xs-12">
        <div class="panel panel-info">
            <div class="panel-heading">
                <i class="fa fa-sticky-note"></i> 
                Note cho nhân viên
            </div>
            <div class="panel-body">
                <table class="table table-striped table-bordered table-hover panel-body">
                    <thead>
                        <tr>
                            <th width="30">STT</th>
                            <th>Thời gian</th>
                            <th>Tài khoản</th>
                            <th>Nội dung</th>
                        </tr>
                    </thead>
                    <tbody  id="table_note">
                        <?php $i=1; foreach ($note as $item) {
                        ?>
                        <tr>
                            <td width="30"><?php echo $i ?></td>
                            <td><?php echo date('d/m/Y h:i', strtotime($item->time)); ?></td>
                            <td><?php echo $item->username ?></td>
                            <td><?php echo $item->note ?></td>
                        </tr>
                        <?php $i++; } ?>
                    </tbody>
                </table>
                <div>
                    <input type="text" class="form-control" name="note" id="note">
                    <div style="text-align: right;padding-top: 15px;">
                        <a class="btn_order" id="add_note" href="javascript:void(0)">Thêm ghi chú</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-6 col-xs-12">
        <div class="panel panel-info">
            <div class="panel-heading">
                <i class="fa fa-history"></i>
                <?php echo FSText::_('Lịch sử tác động') ?>
            </div>
            <div class="panel-body">
            <table class="table table-striped table-bordered table-hover panel-body">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Thời gian</th>
                        <th>Tài khoản</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody id="table_history">
                    <?php $i=1; foreach ($history as $item) {
                    ?>
                    <tr>
                        <td width="30"><?php echo $i ?></td>
                        <td><?php echo date('d/m/Y H:i', strtotime($item->time)); ?></td>
                        <td><?php echo $item->username ?></td>
                        <td><?php echo $item->name_status ?></td>
                    </tr>
                    <?php $i++; } ?>
                </tbody>
            </table>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12 col-xs-12 ">
    <form class="panel panel-info" action="index.php?module=<?php echo $this -> module;?>&view=<?php echo $this -> view;?>"
        name="adminForm" method="post" enctype="multipart/form-data">
        <div class="panel-heading">
            <i class="fa fa-th-list"></i>
            <?php echo FSText::_('Lịch sử mua hàng') ?>
        </div>
        <table class="table table-striped table-bordered table-hover panel-body">
            <thead>
                <tr>
                    <th width="30">STT</th>
                    <!-- <th><?php echo FSText::_('Số Sim đã mua') ?></th> -->
                    <th><?php echo "Tình trạng đơn hàng"; ?></th>
                    <th><?php echo "Thời gian đặt hàng"; ?></th>
                    <th><?php echo "Thời gian giao dịch xong"; ?></th>
                    <th><?php echo "Giá trị đơn hàng"; ?></th>
                    <th><?php echo "Số điện thoại"; ?></th>
                    <th><?php echo "Ghi chú"; ?></th>
                    <th><?php echo "Lưu"; ?></th>
                </tr>
            </thead>
            <tbody>
                <?php $i=1; foreach ($history_order as $item) {
                ?>
                <tr>
                    <td width="30"><?php echo $i ?></td>
                    <!-- <td><?php echo $item->products_id ?></td> -->
                    <td>
                        <?php 
                            $array_status = $this -> arr_status;
                            $array_obj_status = array();
                            foreach($array_status as $key => $name){
                                if ($key == $item->status) {
                                     $name_status = $name;
                                }
                            }
                            echo $name_status;
                         ?>
                    </td>
                    <td><?php echo date('d/m/Y', strtotime($item->created_time)); ?></td>
                    <td><?php echo date('d/m/Y', strtotime($item->cancel_time)); ?></td>
                    <td><?php echo format_money($item->total_end) ?></td>
                    <td><?php echo $item->recipients_mobilephone ?></td>
                    <td><input id="note_<?php echo $item->id ?>" class="form-control" type="text" value="<?php echo $item->comments ?> "></td>
                    <td><a value="<?php echo $item->id ?>" class="btn_order save_comments" href="javascript:void(0)">Lưu</a></td>
                </tr>
                <?php $i++; } ?>
            </tbody>
        </table>
            <?php if(@$data->id) { ?>
            <input type="hidden" value="<?php echo $data->id; ?>" name="id">
            <?php }?>
            <input type="hidden" value="<?php echo $this -> module;?>" name="module"> 
            <input type="hidden" value="<?php echo $this -> view;?>" name="view"> 
            <input type="hidden" value="" name="task"> 
            <input type="hidden" value="0" name="boxchecked">
    </form>
    </div>
</div>

<input type="hidden" id="member_id" name="member_id" value="<?php echo $order->member_id ?>">
<input type="hidden" id="order_id" name="order_id" value="<?php echo $order->id ?>">
<input type="hidden" id="products_id" name="products_id" value="<?php echo $order->products_id ?>">

<script  type="text/javascript" language="javascript">

    $("#status").change(function(){
      status = $(this).val();
      if (status == 12) {
        $("#appointment").show(); 
      }else{
        $("#appointment").hide();
      }
    });
    $('.save_comments').click(function () {
        $id = $(this).attr("value");
        $note = $('#note_'+$id).val();
        if ($note == '') {
            alert('Bạn cần nhập ghi chú');
            return false;
        }
        $.ajax({url: "<?php echo URL_ROOT.URL_ROOT_ADMIN ?>index.php?module=order&task=save_comments&raw=1", 
            data: {id: $id, note:$note},
            dataType: "text",
            success: function (result) {
                if (result == 1) {                    
                    alert('Đã lưu ghi chú');
                } else {
                    alert('Chưa lưu được');
                }
            }
        });
    });

    $('.delete_sim').click(function () {
    if (confirm("Thực hiện tác vụ ?")) {
        $id = $(this).attr("value");
        $("#row_"+$id).remove();
        $.ajax({url: "<?php echo URL_ROOT.URL_ROOT_ADMIN ?>index.php?module=order&task=delete_sim_cart&raw=1",
            data: {id: $id},
            dataType: "text",
            success: function (result) {
                if (result != 0) {                    
                    $('.total_dh').html(result);
                    alert('Đã xóa khỏi giỏ hàng');
                } else {
                    alert('Chưa xóa được');
                }
            }
        });
    }
    });

    $('#add_note').click(function () {
    $order_id = $('#order_id').val();
    $note = $('#note').val();
    if ($note == '') {
        alert('Bạn cần nhập ghi chú');
        return false;
    }

        $.ajax({url: "<?php echo URL_ROOT.URL_ROOT_ADMIN ?>index.php?module=order&task=save_note&raw=1",
            data: {id: $order_id, note: $note},
            dataType: "html",
            success: function (result) {
                if (result) {                    
                    $("#table_note").html(result);
                    $('#note').val('');
                    alert('Thêm ghi chú thành công');
                } else {
                    alert('Chưa thêm được ghi chú');
                }
            }
        });

    });

    $('#save_status').click(function () {
    $order_id = $('#order_id').val();
    $products_id = $('#products_id').val();
    $deposit = $('#deposit').val();
    $pay = $('#pay').val();
    $member = $('#member_id').val();
    $date_appointment = $('#date_appointment').val();
    $status = $('#status').val();
        $.ajax({url: "<?php echo URL_ROOT.URL_ROOT_ADMIN ?>index.php?module=order&task=save_status&raw=1",
            data: {id: $order_id, member:$member, products: $products_id, status: $status, deposit: $deposit, pay:$pay, date_appointment:$date_appointment },
            dataType: "text",
            success: function (result) {
                if (result == 0) {
                    alert('Chưa lưu được');
                } else {
                    $("#table_history").html(result);
                    alert('Lưu thông tin đơn hàng thành công');
                }
            }
        });
    });

    $('#save_info').click(function () {
    $order_id = $('#order_id').val();
    $name = $('#name_customer').val();
    $city = $('#city').val();
    $mail = $('#email_customer').val();
    $address = $('#address_customer').val();
    $phone = $('#phone_customer').val();
    $comments = $('#comments_customer').val();
        $.ajax({url: "<?php echo URL_ROOT.URL_ROOT_ADMIN ?>index.php?module=order&task=save_info&raw=1",
            data: {id: $order_id, name: $name, city: $city, mail: $mail, phone:$phone, comments:$comments , address:$address },
            dataType: "text",
            success: function (result) {
                if (result == 0) {
                    alert('Chưa lưu được');
                } else {
                    $("#table_history").html(result);
                    alert('Lưu thông tin khách hàng thành công');
                }
            }
        });
    });

	print_page();
	function print_page(){
		var width = 800;
		var centerWidth = (window.screen.width - width) / 2;
//	    var centerHeight = (window.screen.height - windowHeight) / 2;
		$('.Print').click(function(){
			link = window.location.href;
			link += '&print=1';
			window.open(link, "","width="+width+",menubar=0,resizable=1,scrollbars=1,statusbar=0,titlebar=0,toolbar=0',left="+ centerWidth + ",top=0");
		});
	}
</script>
