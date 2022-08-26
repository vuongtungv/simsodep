<?php $list = $model->get_records('','fs_pricesim','id,title,price'); ?>
<label class="col-md-3 col-xs-12 control-label">Mức giá</label>
<div class="col-md-9 col-xs-12">
    <select data-placeholder="Trang Seo" class="form-control " name="type" id="type">
    	<option value="network">Mức giá</option>
        <?php foreach ($list as $item) {
        	$selected = '';
        	if (@$data -> type == $item->id) {
        		$selected = 'selected';
        	}
        	?>
        <option <?php echo $selected; ?> value="<?php echo $item->id ?>"><?php echo $item->title ?></option>
        <?php }?>
    </select>
</div>