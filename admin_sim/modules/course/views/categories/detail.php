<link type="text/css" rel="stylesheet" media="all" href="../libraries/jquery/jquery.ui/jquery-ui.css" />
<script type="text/javascript" src="../libraries/jquery/jquery.ui/jquery-ui.js"></script>
<!-- HEAD -->
	<?php 
	
	$title = @$data ? FSText::_('Edit'): FSText::_('Add'); 
	global $toolbar;
	$toolbar->setTitle($title);
    $toolbar->addButton('save_add',FSText :: _('Save and new'),'','save_add.png'); 
	$toolbar->addButton('apply',FSText::_('Apply'),'','apply.png',1); 
	$toolbar->addButton('Save',FSText::_('Save'),'','save.png',1); 
	$toolbar->addButton('cancel',FSText::_('Cancel'),'','cancel.png');   
	
    echo '  <div class="alert alert-danger" style="display:none" >
                    <span id="msg_error"></span>
            </div>'; 

    $this -> dt_form_begin(1,4,$title.' '.FSText::_('Danh mục'),'fa-edit',1,'col-md-12',1);
    	TemplateHelper::dt_edit_text(FSText :: _('Tên nhóm khóa học'),'name',@$data->name);
    	// TemplateHelper::dt_edit_text(FSText :: _('Alias'),'alias',@$data->alias,'',60,1,0,FSText::_("Can auto generate"));
    	// TemplateHelper::dt_edit_selectbox(FSText::_('Parent'),'parent_id',@$data->parent_id,0,$categories,$field_value = 'id', $field_label='treename',$size = 10,0,1);
     //    TemplateHelper::dt_edit_image(FSText :: _('icon'),'icon',str_replace('/original/','/original/',URL_ROOT.@$data->icon));
    	TemplateHelper::dt_edit_text(FSText :: _('Ordering'),'ordering',@$data->ordering,@$maxOrdering,'20');
        TemplateHelper::dt_checkbox(FSText::_('Hoạt động'),'active',@$data -> active,1);
      ?>
        <!-- <div class="form-group">
            <label class="col-sm-3 col-xs-12 control-label"><?php echo FSText::_("Cấp học viên") ?></label>
            <div class="col-sm-9 col-xs-12">
                <select name="level" id="level" class="form-control">
                    <option value="">-- <?php echo FSText::_('Chọn Cấp học viên') ?> --</option>
                    <option value="1" <?php if (@$data->level == 1) echo 'selected' ?>>HVN</option>
                    <option value="2" <?php if (@$data->level == 2) echo 'selected' ?>>Head</option>
                    <option value="3"<?php if (@$data->level == 3) echo 'selected' ?>>User</option>
                </select>
            </div>
        </div> -->
        <?php
    $this->dt_form_end_col(); // END: col-1
    
    // $this -> dt_form_begin(1,6,FSText::_('Admin'),'fa-user',1,'col-md-4 fl-right');
    //     TemplateHelper::dt_text(FSText::_('Tên người tạo'),@$data->creator_name,'','','','col-md-5','col-md-7');
    //     TemplateHelper::dt_text(FSText::_('Thời gian tạo'),@$data->date_created?@$data->date_created:'','', '','','col-md-5','col-md-7');
    //     TemplateHelper::dt_text(FSText::_('Tên người sửa'),@$data->lastedit_name,'','','','col-md-5','col-md-7');
    //     TemplateHelper::dt_text(FSText::_('Thời gian sửa'),@$data->lastedit_date?@$data->lastedit_date:'','', '','','col-md-5','col-md-7');
    // $this->dt_form_end_col(); // END: col-2
    
  //   $this -> dt_form_begin(1,4,FSText::_('Cấu hình seo'),'',1,'col-md-4 fl-right');
  //       TemplateHelper::dt_edit_text(FSText :: _('SEO title'),'seo_title',@$data -> seo_title,'',100,1,0,'','','col-md-12','col-md-12');
		// TemplateHelper::dt_edit_text(FSText :: _('SEO meta keyword'),'seo_keyword',@$data -> seo_keyword,'',100,1,0,'','','col-md-12','col-md-12');
		// TemplateHelper::dt_edit_text(FSText :: _('SEO meta description'),'seo_description',@$data -> seo_description,'',100,9,0,'','','col-md-12','col-md-12');
  //   $this->dt_form_end_col(); // END: col-4
        
	$this -> dt_form_end(@$data,1,0,2,'Cấu hình seo','',1,'col-sm-4');
	
?>
<script type="text/javascript">
    $('.form-horizontal').keypress(function (e) {
      if (e.which == 13) {
        formValidator();
        return false;  
      }
    });
    
    function formValidator()
    {
        $('.alert-danger').show();  
        
        if(!notEmpty('name','Bạn phải nhập tên nhóm'))
            return false;
        
        if(!lengthMaxword('name',10,'Mỗi từ tối đa có 10 ký tự'))
            return false;
        
        $('.alert-danger').hide();
        return true;
    }
   
</script>