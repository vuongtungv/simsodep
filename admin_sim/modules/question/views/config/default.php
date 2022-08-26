<?php
$title = FSText :: _('Cấu hình làm bài');
global $toolbar;
$toolbar->setTitle($title);
$toolbar->addButton('Save',FSText :: _('Save'),'','save.png');
$toolbar->addButton('back',FSText :: _('Cancel'),'','cancel.png');
$this -> dt_form_begin(1, 4, $title);

$valGroups = array();
foreach($data as $item)
	if($item->name == 'groups')
		$valGroups = unserialize($item->value);
?>
    <?php foreach($data as $item) {
		if($item->name == 'groups')
			continue;
		?>
		<div class="form-group">
            <label class="col-sm-2 col-xs-12 control-label"><?php echo FSText::_($item->title); ?></label>
			<div class="col-sm-9 col-xs-12">
				<div class="row">
					<div class="col-sm-6 col-sm-6">
					<?php
					switch ($item->data_type) {
						case "text":
						default:
							echo "<input class='form-control' type='text' name='$item->name' value='$item->value' size='70' /> ";
							break;
						case 'textarea':
							echo "<textarea class='form-control' cols='70' rows='10' name='$item->name'>$item->value</textarea>";
							break;
						case 'datetime':
							echo '<link rel="stylesheet" type="text/css" media="screen" href="../'.URL_ROOT_ADMIN.'templates/default/css/bootstrap-datetimepicker.min.css">';
							echo '	<div class="input-group date datetimepicker" id="datetimepicker_'.$item->name.'">';
							echo '		<input class="form-control" type="text" name="' . $item->name . '"  id="' . $item->name . '"  value="' . ($item->value?$item->value:date('Y-m-d H:i:s')) . '" />';
							echo '		<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>';
							echo '	</div>';
							echo '<script src="../'.URL_ROOT_ADMIN.'templates/default/js/moment.js">
							  </script><script src="../'.URL_ROOT_ADMIN.'templates/default/js/bootstrap-datetimepicker.min.js"></script>
								<script type="text/javascript">
								  $(function() {
									$(".datetimepicker").datetimepicker({
										format: "YYYY-MM-DD HH:mm:ss"
									});
								  });
								</script>
							';
							break;
						case "bool":
							if($item->value == 1)
							{
								$checktrue = " checked = 'checked' ";
								$checkfalse = "";
							}
							else
							{
								$checkfalse = " checked = 'checked' ";
								$checktrue = "";
							}
							echo "<input type='radio' name='$item->name' $checktrue value='1'  />&nbsp;".FSText::_('Yes').'&nbsp;&nbsp;&nbsp;&nbsp;';
							echo "<input type='radio' name='$item->name' $checkfalse value='0' />&nbsp;".FSText::_('No');
							break;
						case "image":
							if($item -> value){
								echo '<img width="120px" src="'.URL_ROOT.$item -> value.'" />';
							}
							echo '
									<div class="fileUpload btn btn-primary ">
										<span><i class="fa fa-cloud-upload"></i> Upload</span>
										<input type="file" class="upload" name="'.$item->name.'"  />
									</div>';
							break;
						case "editor":
							$oFCKeditor = new FCKeditor("$item->name") ;
							$oFCKeditor->BasePath	=  '../libraries/wysiwyg_editor/' ;
							$oFCKeditor->Value		= @$item->value;
							$oFCKeditor->Width = 650;
							$oFCKeditor->Height = 450;
							$oFCKeditor->Create() ;
							break;
					}
					?>
					</div>
					<div class="col-sm-6 col-sm-6">
						<?php echo $item->note;  ?>
					</div>
				</div>
			</div>
		</div>
		<?php if($item->name == 'number_questions'){ ?>
			<?php foreach($groups as $g){ ?>
				<div class="form-group">
					<label class="col-sm-2 col-xs-12 control-label"></label>
					<div class="col-sm-9 col-xs-12">
						<div class="row">
							<div class="col-sm-6">
								<input class="form-control" type="text" name="groups[<?php echo $g->id?>]" value="<?php echo intval(@$valGroups[$g->id])?>" size='70' />
							</div>
							<div class="col-sm-6">
								<?php echo FSText::_($g->name); ?>
							</div>
						</div>
					</div>
				</div>
		<?php } ?>
		<?php } ?>
	<?php } ?>
<?php $this -> dt_form_end(@$data,1,0); ?>
<script type="text/javascript">
	$('.form-horizontal').keypress(function (e) {
		if (e.which == 13) {
			submitbutton('Save')
			return false;
		}
	});

	$('.form-control').keypress(function(event){
		if(event.which != 8 && isNaN(String.fromCharCode(event.which))){
			event.preventDefault();
			alert('Bạn nhập sai định dạng');
		}
	});
</script>
