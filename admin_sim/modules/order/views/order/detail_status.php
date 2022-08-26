<?php 
    $array_type = array( 
                        1 => FSText::_('Mua hàng trực tiếp - thanh toán tại cửa hàng'),
                        2 => FSText::_('Giao hàng - nhận tiền (COD)'),
                        3=> FSText::_('Chuyển khoản ngân hàng (click vào để hiện danh sách tài khoản)')
                    );
 ?>
<div class="table-responsive">
	<!-- TABLE 							-->
	<!--	RECIPIENCE INFO				-->
	<table class="table table-striped">
		<tbody> 

		  <tr>
			<td class="col-sm-4"><?php echo FSText::_('Mã đơn hàng') ?></td>

			<td width="5px">:</td>
			<td>
				<strong class = "red"><?php echo 'DH'.str_pad($order -> id, 8 , "0", STR_PAD_LEFT); ?>  </strong>
			</td>
		  </tr>

		  <tr>
			<td class="col-sm-4"><?php echo FSText::_('Loại khách hàng') ?></td>

			<td width="5px">:</td>
			<td>
				<strong class = "red"><?php echo $order->member_level_name ?></strong>
			</td>
		  </tr>

		  <tr>
			<td class="col-sm-4"><?php echo FSText::_('Thời gian đặt hàng') ?></td>
			<td width="5px">:</td>
			<td>
				<strong class = "red"><?php echo date('d/m/Y H:i', strtotime($order->created_time)); ?></strong>
			</td>
		  </tr>

		  <tr>
			<td class="col-sm-4"><?php echo FSText::_('Trạng thái') ?></td>
			<td width="5px">:</td>
			<td>
				<select class="form-control" name="status" id="status">
					<?php foreach ($array_obj_status as $item) {
						$selected = $item->id==$order->status ? 'selected':'';
					 ?>
					 <option <?php echo $selected ?> value="<?php echo $item->id ?>"><?php echo $item->name ?></option>
					<?php } ?>
				</select>
			</td>
		  </tr>

		  <tr id="appointment" style="display:<?php echo $order->status == 12 ? '':'none'; ?> ">
			<td class="col-sm-4"><?php echo FSText::_('Ngày hẹn') ?></td>
			<td width="5px">:</td>
			<td>
		  		<link rel="stylesheet" type="text/css" media="screen" href="../admin_sim/templates/default/css/bootstrap-datetimepicker.min.css">
				<input class="form-control datetimepicker" type="text" name="date_appointment" id="date_appointment" value="<?php echo $order->date_appointment?date('d/m/Y H:i:s',$order->date_appointment):'' ?>" size="20">

                <script src="../admin_sim/templates/default/js/moment.js"></script>
                <script src="../admin_sim/templates/default/js/bootstrap-datetimepicker.min.js"></script>
				<!-- <?php $timenow = date('Y-m-d H:i'); $timenow = strtotime($timenow); $timenow = date('Y/m/d H:i',$timenow+86400)  ?> -->
				<?php $timenow = date('d-m-Y H:i:s'); $timenow = strtotime($timenow); $timenow = date('d/m/Y H:i:s',$timenow+86400)  ?>
                <script type="text/javascript">
                 
                  	$('#date_appointment').datetimepicker({
					   // dateFormat: 'dd-mm-yy',
					   format:'DD-MM-YYYY HH:mm:ss' 
					});

                </script> 
			</td>
		  </tr>



		  <tr>
			<td class="col-sm-4"><?php echo FSText::_('Giá trị đơn hàng') ?></td>
			<td width="5px">:</td>
			<td>
				<strong class = "red total_dh"><?php echo format_money($order->total_end) ?></strong>
			</td>
		  </tr>

		  <tr>
			<td class="col-sm-4"><?php echo FSText::_('Phương thức đặt cọc') ?></td>
			<td width="5px">:</td>
			<td>
				<select class="form-control" id="deposit" name="deposit">
                    <option <?php echo $order->deposit_method == 'Thẻ cào' ? 'selected':'' ?> value="Thẻ cào">Thẻ cào</option>
                    <option <?php echo $order->deposit_method == 'Ngân hàng' ? 'selected':'' ?>  value="Ngân hàng">Ngân hàng</option>
                    <option <?php echo $order->deposit_method == 'Trực tiếp' ? 'selected':'' ?>  value="Trực tiếp">Trực tiếp</option>
                </select>
			</td>
		  </tr>

		  <tr>
			<td class="col-sm-4"><?php echo FSText::_('Phương thức thanh toán') ?></td>
			<td width="5px">:</td>
			<td>
				<select class="form-control" id="pay" name="pay">
					<?php foreach ($method as $item) {?>
                    	<option <?php echo $item->id == $order->payment_method ? 'selected':'' ?> value="<?php echo $item->id ?>"><?php echo $item->title ?></option>
					<?php } ?>
                </select>
			</td>
		  </tr>

		  <tr>
			<td class="col-sm-4"><?php echo FSText::_('Chương trình khuyến mại') ?></td>

			<td width="5px">:</td>
			<td>
				<strong class = "red">
				<?php 
                        $discount = '0%';
                        $gift = '';
                        $d_name = '';
                        if ($order->discount_unit == 'price') {
                            $discount = format_money($order->discount_value,' đ');
                        }
                        if ($order->discount_unit == 'percent') {
                            $discount = $order->discount_value.'%';
                        }
                        if ($order->discount_name) {
                        	$d_name = $order->discount_name;
                        }
                        if ($order->gift) {
                            $gift = ' và '.$order->gift;
                        }
                        echo $discount.' '.$d_name.$gift;
                    ?>
				</strong>
			</td>
		  </tr>

		 </tbody>
	</table>
	<!-- ENd TABLE 							-->
		
</div>