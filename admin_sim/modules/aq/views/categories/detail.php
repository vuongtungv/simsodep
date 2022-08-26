<!-- HEAD -->
	<?php 
	
	$title = @$data ? FSText::_('Edit'): FSText::_('Add'); 
	global $toolbar;
	$toolbar->setTitle($title);
    $toolbar->addButton('save_add',FSText :: _('Save and new'),'','save_add.png');
	$toolbar->addButton('apply',FSText::_('Apply'),'','apply.png'); 
	$toolbar->addButton('save',FSText::_('Save'),'','save.png'); 
	$toolbar->addButton('cancel',FSText::_('Cancel'),'','cancel.png');   
	
	$this -> dt_form_begin();
	
	TemplateHelper::dt_edit_text(FSText :: _('Name'),'name',@$data -> name);
	TemplateHelper::dt_edit_text(FSText :: _('Alias'),'alias',@$data -> alias,'',60,1,0,FSText::_("Can auto generate"));
	TemplateHelper::dt_edit_selectbox(FSText::_('Parent'),'parent_id',@$data -> parent_id,0,$categories,$field_value = 'id', $field_label='treename',$size = 10,0,1);
//	TemplateHelper::dt_edit_image(FSText :: _('Image'),'image',URL_ROOT.@$data->image);
//    TemplateHelper::dt_edit_image(FSText :: _('icon'),'icon',URL_ROOT.@$data->icon);
//    $arr_types = array(
//        array('0',FSText::_('Thí sinh')),
//        array('1',FSText::_('Nhà đào tạo')),
//    );
//    TemplateHelper::dt_edit_selectbox2(FSText::_('Nhóm đối tượng'),'type_id',@$data -> type_id,0,$arr_types,$field_value = 0, $field_label=1,$size = 10,0,1);
    
    TemplateHelper::dt_date_pick ( FSText :: _('Published time' ), 'created_time', @$data->created_time?@$data->created_time:date('Y-m-d H:i:s'), FSText :: _('Bạn vui lòng chọn thời gian hiển thị'), 20);
    TemplateHelper::dt_checkbox(FSText::_('Published'),'published',@$data -> published,1);
	// TemplateHelper::dt_checkbox(FSText::_('Hiển thị tên category trong bài viết'),'display_title',@$data -> display_title,1);
	// TemplateHelper::dt_checkbox(FSText::_('Hiển thị comment trong bài viết'),'display_comment',@$data -> display_comment,1);
	// TemplateHelper::dt_checkbox(FSText::_('Hiển thị tags cho bài viết'),'display_tags',@$data -> display_tags,1);
	// TemplateHelper::dt_checkbox(FSText::_('Hiển thị tin liên quan cho bài viết'),'display_related',@$data -> display_related,1);
	// TemplateHelper::dt_checkbox(FSText::_('Hiển thị ngày tạo cho bài viết'),'display_created_time',@$data -> display_created_time,1);
	// TemplateHelper::dt_checkbox(FSText::_('Hiển thị tóm tắt bài viết'),'display_summary',@$data -> display_summary,1);
	TemplateHelper::dt_edit_text(FSText :: _('Ordering'),'ordering',@$data -> ordering,@$maxOrdering,'20');
//	TemplateHelper::dt_edit_image(FSText :: _('Icon'),'icon',@$data -> icon);
	
	$this -> dt_form_end(@$data,1,1);
	
	?>

