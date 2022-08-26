<div class="table-responsive">
	<!-- TABLE 							-->
	<table class="table table-striped">
		<tbody>
		  <tr>
			<td class="col-sm-5">T&#234;n ng&#432;&#7901;i &#273;&#7863;t h&#224;ng</td>
			<td width="5px">:</td>
			<td>
				<input class="form-control" type="text" name="name_customer" id="name_customer" value="<?php echo $order-> recipients_name; ?>">
			</td>
		  </tr>
		  <tr>
			<td>Mã khách hàng</td>
			<td width="5px">:</td>
			<td><b><?php echo $order->member_code ?></b></td>
		  </tr>
		  <tr>
			<td>Tỉnh thành</td>
			<td width="5px">:</td>
			<td>
				<select class="form-control" id="city" name="city">
					<?php foreach ($city as $item) {
						$selected = $item->name == $order-> recipients_city_name ? 'selected':'';
					?>
					<option <?php echo $selected ?> value="<?php echo $item->id ?> "><?php echo $item->name ?></option>
					<?php } ?>
				</select>
			</td>
		  </tr>
		  <tr>
			<td>Địa chỉ</td>
			<td width="5px">:</td>
			<td>
				<input class="form-control" type="text" name="address_customer" id="address_customer" value="<?php echo $order-> recipients_address; ?>">
			</td>
		  </tr>
		  <tr>
			<td>Email</td>
			<td width="5px">:</td>
			<td>
				<input class="form-control" type="text" name="email_customer" id="email_customer" value="<?php echo $order-> recipients_email; ?>">
			</td>
		  </tr>
		  <tr>
			<td>&#272;i&#7879;n tho&#7841;i</td>
			<td width="5px">:</td>
			<td>
				<input class="form-control" type="text" name="phone_customer" id="phone_customer" value="<?php echo $order-> recipients_mobilephone; ?>">
			</td>
		  </tr>
          <tr>
			<td><?php echo FSText::_('Ghi chú'); ?></td>
			<td width="5px">:</td>
			<td>
				<input class="form-control" type="text" name="comments_customer" id="comments_customer" value="<?php echo $order-> recipients_comments; ?>">
			</td>
		  </tr>
		 </tbody>
	</table>
	<!-- ENd TABLE 							-->
		
</div>
