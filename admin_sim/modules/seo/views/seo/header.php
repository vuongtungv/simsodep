<?php 
	$list = $model->get_records('published=1','fs_network','id,name,header');
	$header = '';
	foreach ($list as $item) {
		$header .= $item->header.',';
	}
	$header = rtrim($header,',');
	$header = explode(',', $header);
	$list = $header;
 ?>
<label class="col-md-3 col-xs-12 control-label">Đầu số</label>
<div class="col-md-9 col-xs-12">
    <select data-placeholder="Trang Seo" class="form-control " name="type" id="type">
    	<option value="network" selected="selected">Đầu số</option>
        <?php foreach ($list as $item) {
        	$selected = '';
        	if (@$data -> type == $item) {
        		$selected = 'selected';
        	}
    	?>
        <option <?php echo $selected; ?> value="<?php echo $item ?>"><?php echo $item ?></option>
        <?php }?>
    </select>
</div>