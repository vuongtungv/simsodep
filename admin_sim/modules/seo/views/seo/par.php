<label class="col-md-3 col-xs-12 control-label">Hợp mệnh</label>
<div class="col-md-9 col-xs-12">
    <select data-placeholder="Hợp mệnh" class="form-control " name="type" id="type">
    	<option value="par" selected="selected">Hợp mệnh</option>
    	<option <?php echo @$data -> type == 'kim' ? 'selected':'' ?> value="kim">Hợp mệnh kim</option>
    	<option <?php echo @$data -> type == 'moc' ? 'selected':'' ?> value="moc">Hợp mệnh mộc</option>
    	<option <?php echo @$data -> type == 'thuy' ? 'selected':'' ?> value="thuy">Hợp mệnh thủy</option>
    	<option <?php echo @$data -> type == 'hoa' ? 'selected':'' ?> value="hoa">Hợp mệnh hỏa</option>
    	<option <?php echo @$data -> type == 'tho' ? 'selected':'' ?> value="tho">Hợp mệnh thổ</option>
    </select>
</div>