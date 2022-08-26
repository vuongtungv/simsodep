<?php if(isset($config['fields_seo_description']['fields']) && $config['fields_seo_description']['fields'] && count($config['fields_seo_description']['fields'])): ?>
	<?php $count_fields = count($config['fields_seo_description']['fields']);?>	
	<tr>
		<td valign="top" width="109">
			<?php $title = isset($config['fields_seo_title']['title'])?$config['fields_seo_title']['title']:FSText::_('Meta Description'); ?>
			<?php echo $title; ?>
		</td>
		<td   valign="top">
			<?php 
			$data_fields_seo_description = $data -> fields_seo_description;
			$arr_fields_seo_description = count($data_fields_seo_description)? explode('|',$data_fields_seo_description):array();	
			?>
			<?php for($i = 0; $i < $count_fields,$i<3; $i ++):?>
				<?php 
				if(isset($arr_fields_seo_description[$i])){
					$data_field_item = $arr_fields_seo_description[$i];
					$arr_buffer_data_field_item = explode(',',$data_field_item);// array(cọnugate,field_name)
					$data_field_conjugate = isset($arr_buffer_data_field_item[0])?$arr_buffer_data_field_item[0]:0;
					$data_field_name = $arr_buffer_data_field_item[1];
				}else{
					$data_field_item = array();
					$data_field_conjugate = 0;
					$data_field_name = '';
				}
				?>
				<?php if($i):?>
					<strong class='seo_sepa'>+</strong>
					<select name="seo_description_conjugate_<?php echo $i;?>"  class='seo_conjugate'>
						<?php foreach($arr_conjugate as $conjugate_key => $conjugate_value):?>
							<option value="<?php echo $conjugate_key;?>" <?php echo $conjugate_key == $data_field_conjugate?'selected="selected"':''?> ><?php echo $conjugate_value;?></option>
						<?php endforeach;?>
					</select>
				<?php endif;?>
					<select name="seo_description_field_name_<?php echo $i;?>" class='seo_field'>
						<?php foreach($config['fields_seo_description']['fields'] as $field_name => $field_title):?>
							<option value="<?php echo $field_name;?>" <?php echo $field_name == $data_field_name?'selected="selected"':''?> ><?php echo $field_title;?></option>
						<?php endforeach;?>
					</select>
				
			<?php endfor;?>	
		</td>
		<td  width="30">
			<?php if(isset($config['fields_seo_description']['help']) && $config['fields_seo_description']['help'] ) {?>
				<a href="javascript:void()" title="Help" class="fa fa-exclamation-circle">
					<div class='help_content' style="display:none"><?php echo $config['fields_seo_description']['help'] ;?></div>
				</a>
			<?php }else{?>
				&nbsp;
			<?php }?>
		</td>
	</tr>
<?php endif;?>
	