<script type="text/javascript" language="javascript" src="<?=URL_ROOT.'administrator/templates/default/js/jquery.layout-latest.js'?>"></script>
<script type="text/javascript" language="javascript" src="<?=URL_ROOT.'administrator/templates/default/js/jquery.form.js'?>"></script>
<script type="text/javascript" language="javascript" src="<?=URL_ROOT.'administrator/templates/default/js/jquery.MultiFile.js'?>"></script>
<script type="text/javascript" language="javascript" src="<?=URL_ROOT.'administrator/templates/default/js/jquery.validate.min.js'?>"></script>
<script type="text/javascript" language="javascript" src="<?=URL_ROOT.'administrator/templates/default/js/import.js'?>"></script>
<fieldset id="zone-upload-analytics">
	<legend class="title">Cập nhật sản phẩm từ excel</legend>
	
	<div id="content-form-upload-import-excel">
		<form id="frm-import-excel-for-product" action="index.php?module=products&view=import&task=upload_cat" method="POST" enctype="multipart/form-data">
			<div class="one-row-input">
				<div class="input">
					<div id='frm-editing-upload-league-excel_wrap'><span>File excel: </span><input type="file" size="35" id="frm-editing-upload-league-excel" class="football-data-excel-file-import" name="excel"><span id="frm-editing-upload-league-excel_wrap_labels"></span></div>
				</div>
			</div>
			<div class="one-row-input">
				<div class="input-title">&nbsp;</div>
				<div class="input">
					<input type="submit" value="<?php echo (@$cat)?'Import':'Cập nhật'?>">
					&nbsp;
					<input type="button" value="Nhập file khác" onclick="javascritp: location.reload();">
				</div>
			</div>
		</form>
	</div>
</fieldset>