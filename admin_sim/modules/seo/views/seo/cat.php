<?php 
	$list = $model->get_records('level = 0','fs_sim_type','id,name');
 ?>
<label class="col-md-3 col-xs-12 control-label">Thể loại</label>
<div class="col-md-9 col-xs-12">
    <select data-placeholder="Trang Seo" class="form-control " name="type" id="type">
    	<option value="cat" selected="selected">Thể loại</option>
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