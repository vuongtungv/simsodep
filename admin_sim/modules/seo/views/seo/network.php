<?php $list = $model->get_records('published=1','fs_network','id,name,alias'); ?>
<label class="col-md-3 col-xs-12 control-label">Nhà mạng</label>
<div class="col-md-9 col-xs-12">
    <select data-placeholder="Trang Seo" class="form-control " name="type" id="type">
    	<option value="network">Nhà mạng</option>
        <?php foreach ($list as $item) {
        	$selected = '';
        	if (@$data -> type == $item->id) {
        		$selected = 'selected';
        	}
        	?>
        <option <?php echo $selected; ?> value="<?php echo $item->id ?>"><?php echo $item->name ?></option>
        <?php }?>
    </select>
</div>