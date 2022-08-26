<div id="chietkhau">
<?php $max_ordering = 1; ?>
<?php $array_commission_type = array('percent'=>'Phần trăm','price'=>'Giá trị'); ?>
	<table id="sample_1" class="table table-striped table-bordered table-hover table-checkable order-column" width="100%">
		<thead>
			<tr>
				<th align="center" width="30%" >
					Lớn hơn(VND)
				</th>
				<th align="center" width="30%" >
					Nhỏ hơn(VND)
				</th>
				<th align="center" width="15%" >
					Hoa hồng
				</th>
				<th align="center" width="15%" >
					Đơn vị tính
				</th>
				<th align="center"  width="10%" >
					Xóa
				</th>
			</tr>
		</thead>
		<tbody>
		<?php
			$i = 0; 
			if(isset($commissions) && !empty($commissions)){
				foreach ($commissions as $item) { 
		?>
			<tr>
				<td>
					<input type="hidden" value="<?php echo $item -> id; ?>" name="id_exist_<?php echo $i;?>">
					
					<input type="text" size="20" value="<?php echo format_money($item -> price_f,'') ?>" name="price_f_exist_<?php echo $i;?>">
					<input type="hidden" value="<?php echo $item -> price_f; ?>" name="price_f_exist_<?php echo $i;?>_original">
				</td>
				<td>
					<input type="text" size="20" value="<?php echo format_money($item -> price_t,''); ?>" name="price_t_exist_<?php echo $i;?>">
					<input type="hidden" value="<?php echo $item -> price_t; ?>" name="price_t_exist_<?php echo $i;?>_original">
				</td>
				<td>
					<input type="text" size="20" value="<?php echo $item -> commission; ?>" name="commission_exist_<?php echo $i;?>">
					<input type="hidden" value="<?php echo $item -> commission; ?>" name="commission_exist_<?php echo $i;?>_original">
				</td>
				<td>
					<select id="commission_unit_exist_<?php echo $i;?>" name="commission_unit_exist_<?php echo $i;?>">
						<?php foreach($array_commission_type as $key=>$type){?>
							<?php $checked = $item -> commission_unit == $key ? 1 : 0; ?>
							<option <?php echo $checked ? 'selected="selected"':''?> value="<?php echo $key?>"><?php echo $type; ?></option>
						<?php }?>
					</select>
					<input type="hidden" value="<?php echo $item -> commission_unit; ?>" name="commission_unit_exist_<?php echo $i;?>_original">
				</td>
				<td>
					<input type="checkbox" onclick="remove_image(this.checked);" value="<?php echo $item->id; ?>"  name="other_image[]" id="other_image<?php echo $i; ?>" />
				</td>
			</tr>
				<?php
					$i++; 
				} // end .foreach ($commissions as $item)
			} // end .if(isset($commissions))
			?>
		<?php for($i = 0; $i < 20; $i ++ ) { ?>
			<tr id='new_record_<?php echo $i?>' class='new_record closed'>
				 <td>
					 <input type="text" size="20" id="new_price_f_<?php echo $i;?>" name="new_price_f_<?php echo $i;?>">
				 </td>
				 <td>
					 <input type="text" size="20" id="new_price_t_<?php echo $i;?>" name="new_price_t_<?php echo $i;?>">
				 </td>
				 <td>
					 <input type="text" size="20" id="new_commission_<?php echo $i;?>" name="new_commission_<?php echo $i;?>">
				 </td>
				 <td>
				 	<select id="new_commission_unit_<?php echo $i;?>" name="new_commission_unit_<?php echo $i;?>">
						<?php foreach($array_commission_type as $key=>$type){?>
							<option <?php echo $key == 'percent' ? 'selected="selected"':''?> value="<?php echo $key?>"><?php echo $type; ?></option>
						<?php }?>
					</select>
				</td>
				<td>
					<input type="checkbox" onclick="remove_image(this.checked);" value="<?php echo @$item->id; ?>"  name="other_image[]" id="other_image<?php echo $i; ?>" />
				</td>
			</tr>
	<?php } ?>
	</tbody>		
	</table>
	<div class='add_record'>
		<a href="javascript:add_commission()"><strong class='red'>Thêm điều kiện chiết khấu</strong></a>
	</div>
	<input type="hidden" value="<?php echo isset($commissions)?count($commissions):0; ?>" name="commissions_exist_total" id="commissions_exist_total" />
	
<script type="text/javascript" >
function remove_image(isitchecked){
	if (isitchecked == true){
		document.adminForm.otherimage_remove.value++;
	}
	else {
		document.adminForm.otherimage_remove.value--;
	}
}
function add_commission(){
	for(var i = 0; i < 20; i ++){
		tr_current = $('#new_record_'+i);
		if(tr_current.hasClass('closed')){
			tr_current.addClass('opened').removeClass('closed');
			return;
		}
	}
}
</script>
<style>
.closed{
	display:none;
}
</style>
</div>