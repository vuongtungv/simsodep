<?php
$title = @$data ? FSText :: _('Edit'): FSText :: _('Add'); 
global $toolbar;
$toolbar->setTitle($title);
$toolbar->addButton('apply',FSText :: _('Apply'),'','apply.png'); 
$toolbar->addButton('Save',FSText :: _('Save'),'','save.png'); 
$toolbar->addButton('back',FSText :: _('Cancel'),'','back.png');   

	$this -> dt_form_begin();
?>

<div class="form-group">
	<label class="col-sm-3 control-label">Ghi chú</label>
    	<div class="col-md-9">
			<textarea id="note" name="note" class="form-control" rows="10" readonly="1">            
	    #mang#			= Nhà mạng
            #theloai#		        = Thể loại
            #theloaicon#	        = Thể loại con
            #dauso#			= Đầu số
            #sim#			= Sim có dấu
            #simkd#			= Sim không dấu
            #menh#			= Sim Hợp mệnh
            #gia#			   	= Giá sim
            #timkiem#		= Tham số tìm kiếm
            </textarea> 
			<p class="alert alert-danger" id="ajax-info-note" style="display: none"></p>
		</div>
</div>

<div class="form-group">
    <label class="col-md-3 col-xs-12 control-label">User tạo</label>
    <div class="col-md-9 col-xs-12">
        <input type="text" class="form-control" disabled value="<?php echo @$data->user_create_name ?>" size="60" maxlength="200">
    </div>
</div>
<div class="form-group">
    <label class="col-md-3 col-xs-12 control-label">User sửa</label>
    <div class="col-md-9 col-xs-12">
        <input type="text" class="form-control" disabled value="<?php echo @$data->user_update_name ?>" size="60" maxlength="200">
    </div>
</div>

<?php
	TemplateHelper::dt_edit_selectbox(FSText::_('Trang Seo'),'module_seo',@$data -> module_seo,0,$this -> array_cat,$field_value = 'id', $field_label='name',$size = 0,0,0);
?>

<div class="form-group" id="dm2">
	<?php if (@$data -> module_seo) {
		switch ($data -> module_seo) {
			case 'cat':
				include 'modules/'.$this->module.'/views/'.$this->view.'/cat.php';
				break;
			case 'network':
				include 'modules/'.$this->module.'/views/'.$this->view.'/network.php';
				break;
			case 'head_network':
				include 'modules/'.$this->module.'/views/'.$this->view.'/network.php';
				break;
			case 'header':
				include 'modules/'.$this->module.'/views/'.$this->view.'/header.php';
				break;
			case 'sim':
				break;
			case 'par':
				include 'modules/'.$this->module.'/views/'.$this->view.'/par.php';
				break;
			case 'subcat':
				include 'modules/'.$this->module.'/views/'.$this->view.'/cat.php';
				break;
			default:
				break;
		}

		?>
	<?php } ?>
</div>

<?php
	TemplateHelper::dt_edit_text(FSText :: _('Meta title'),'title',@$data -> title);
	TemplateHelper::dt_edit_text(FSText :: _('Meta keywords'),'keywords',@$data -> keywords,'','',1,0,'');
	TemplateHelper::dt_edit_text(FSText :: _('Meta description '),'description',@$data -> description,'','',5);
	TemplateHelper::dt_edit_text(FSText :: _('Content'),'content',@$data -> content,'',650,450,1,'','','col-sm-3','col-sm-9');
	// TemplateHelper::dt_edit_text(FSText :: _('Ordering'),'ordering',@$data -> ordering,@$maxOrdering,'20');
	TemplateHelper::dt_checkbox(FSText::_('Published'),'published',@$data -> published,1);

	$this -> dt_form_end(@$data,1,0);

?>

<script type="text/javascript">
	$("#module_seo").change(function(){
		m = $(this).val();
		$.ajax({url: "<?php echo URL_ROOT.URL_ROOT_ADMIN ?>index.php?module=seo&view=seo&task=get_list_module&raw=1",
            data: { type: m},
            dataType: "html",
            success : function(data){
              $('#dm2').html(data);
            }
        });
	});
</script>
	