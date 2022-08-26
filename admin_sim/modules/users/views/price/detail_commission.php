<link type="text/css" rel="stylesheet" media="all" href="../libraries/jquery/jquery.ui/jquery-ui.css" />
<script type="text/javascript" src="../libraries/jquery/jquery.ui/jquery-ui.js"></script>
<div id="chietkhau">
<?php $max_ordering = 1; ?>
<?php 
	$array_commission_type = array('percent'=>'Phần trăm','price'=>'Giá trị');
	$array_commission = array('commission'=>'Chiết khấu','up'=>'Tăng','down'=>'Giảm');
 ?>
	<table id="sample_1" class="table table-striped table-bordered table-hover table-checkable order-column" width="100%">
		<thead>
			<tr>
				<th align="center" width="20%" >
					Loại
				</th>
				<th align="center" width="20%" >
					Lớn hơn(VND)
				</th>
				<th align="center" width="20%" >
					Nhỏ hơn(VND)
				</th>
				<th align="center" width="20%" >
					Giá trị
				</th>
				<th align="center" width="20%" >
					Đơn vị tính
				</th>
				<th align="center" width="20%" >
					Thứ tự
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
					<select id="commission_type_exist_<?php echo $i;?>" name="commission_type_exist_<?php echo $i;?>">
						<?php foreach($array_commission as $key=>$type){?>
							<?php $checked = $item -> commission_type == $key ? 1 : 0; ?>
							<option <?php echo $checked ? 'selected="selected"':''?> value="<?php echo $key?>"><?php echo $type; ?></option>
						<?php }?>
					</select>
					<input type="hidden" value="<?php echo $item -> commission_type; ?>" name="commission_type_exist_<?php echo $i;?>_original">
				</td>
				<td>
					<input type="hidden" value="<?php echo $item -> id; ?>" name="id_exist_<?php echo $i;?>">
					
					<input class='numeric' data-v-min="0" data-v-max="999999999999" type="text" size="20" value="<?php echo $item -> price_f; ?>" name="price_f_exist_<?php echo $i;?>">
					<input type="hidden" value="<?php echo $item -> price_f; ?>" name="price_f_exist_<?php echo $i;?>_original">
				</td>
				<td>
					<input class='numeric' data-v-min="0" data-v-max="999999999999" type="text" size="20" value="<?php echo $item -> price_t; ?>" name="price_t_exist_<?php echo $i;?>">
					<input type="hidden" value="<?php echo $item -> price_t; ?>" name="price_t_exist_<?php echo $i;?>_original">
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
					<input class="<?php echo $item -> commission_unit == 'price'?'numeric':'' ?>"  type="text" size="20" data-v-min="0" data-v-max="999999999999" value="<?php echo $item -> commission ?>" name="commission_exist_<?php echo $i;?>">
					<input type="hidden" value="<?php echo $item -> commission; ?>" name="commission_exist_<?php echo $i;?>_original">
				</td>
				<td>
					<input type="text" size="20" data-v-min="0" data-v-max="999999999999" value="<?php echo $item -> ordering ?>" name="ordering_exist_<?php echo $i;?>">
					<input type="hidden" value="<?php echo $item -> ordering; ?>" name="ordering_exist_<?php echo $i;?>_original">
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
		<?php for($i = 0; $i < 50; $i ++ ) { ?>
			<tr id='new_record_<?php echo $i?>' class='new_record closed'>
				<td>
				 	<select id="new_commission_type_<?php echo $i;?>" name="new_commission_type_<?php echo $i;?>">
						<?php foreach($array_commission as $key=>$type){?>
							<option <?php echo $key == 'percent' ? 'selected="selected"':''?> value="<?php echo $key?>"><?php echo $type; ?></option>
						<?php }?>
					</select>
				</td>
				 <td>
					 <input class="numeric" data-v-min="0" data-v-max="999999999999" type="text" size="20" id="new_price_f_<?php echo $i;?>" placeholder="Điều kiện 1 >=" name="new_price_f_<?php echo $i;?>">
				 </td>
				 <td>
					 <input class="numeric" data-v-min="0" data-v-max="999999999999" type="text" size="20" id="new_price_t_<?php echo $i;?>" placeholder="Điều kiện 2 <" name="new_price_t_<?php echo $i;?>">
				 </td>
				 <td>
				 	<select id="new_commission_unit_<?php echo $i;?>" onchange="type_unit(<?php echo $i;?>)" name="new_commission_unit_<?php echo $i;?>">
						<?php foreach($array_commission_type as $key=>$type){?>
							<option <?php echo $key == 'percent' ? 'selected="selected"':''?> value="<?php echo $key?>"><?php echo $type; ?></option>
						<?php }?>
					</select>
				</td>
				 <td>
					 <input data-v-min="0" data-v-max="999999999999" type="text" size="20" id="new_commission_<?php echo $i;?>" placeholder="vd: 25" name="new_commission_<?php echo $i;?>">
				 </td>
				 <td>
					 <input data-v-min="0" data-v-max="999999999999" type="text" size="20" id="new_ordering_<?php echo $i;?>" placeholder="vd: 1" name="new_ordering_<?php echo $i;?>">
				 </td>
 				<td>
					<input type="checkbox" onclick="remove_image(this.checked);" value="<?php echo @$item->id; ?>"  name="other_image[]" id="other_image<?php echo $i; ?>" />
				</td>
			</tr>
	<?php } ?>
	</tbody>		
	</table>
	<div class='add_record'>
		<a href="javascript:add_commission()"><strong class='red'>Thêm điều kiện</strong></a>
	</div>
	<input type="hidden" value="<?php echo isset($commissions)?count($commissions):0; ?>" name="commissions_exist_total" id="commissions_exist_total" />
	
<script type="text/javascript" >
function type_unit(i){
	v = $('#new_commission_unit_'+i).val();
	if (v == 'price') {
		$('#new_commission_'+i).addClass('numeric');
	}else{
		$('#new_commission_'+i).removeClass('numeric');
	}
	$('.numeric').autoNumeric('init');
}
function remove_image(isitchecked){
	if (isitchecked == true){
		document.adminForm.otherimage_remove.value++;
	}
	else {
		document.adminForm.otherimage_remove.value--;
	}
}
function add_commission(){
	for(var i = 0; i < 50; i ++){
		tr_current = $('#new_record_'+i);
		if(tr_current.hasClass('closed')){
			tr_current.addClass('opened').removeClass('closed');
			//Lấy giá trị index-before
            if(i>=1){
                var $for = i-1;
                $com =$('#new_commission_type_'+$for).val();
                $price =$('#new_price_t_'+$for).val();
                $unit =$('#new_commission_unit_'+$for).val();

                $('#new_commission_type_'+i).val($com);
                $('#new_price_f_'+i).val($price);
                $('#new_commission_unit_'+i).val($unit);
            }
			return;
		}


		// if(i>=1){
        //
        // }
	}
}
</script>
<style>
.closed{
	display:none;
}
</style>
</div>