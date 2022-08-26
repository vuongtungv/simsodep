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
	
	TemplateHelper::dt_edit_text(FSText :: _('Tên thiết bị'),'name',@$data -> name);
	TemplateHelper::dt_edit_text(FSText :: _('Alias'),'alias',@$data -> alias,'',60,1,0,FSText::_("Can auto generate"));
    TemplateHelper::dt_edit_image(FSText:: _('Ảnh thiết bị'),'image',str_replace('/original/','/resized/',URL_ROOT.@$data->image));
    TemplateHelper::dt_edit_text(FSText :: _('Hãng'),'manufactory_name',@$data -> manufactory_name);
    TemplateHelper::dt_edit_text(FSText :: _('Model'),'model',@$data -> model);
    
    TemplateHelper::dt_date_pick ( FSText :: _('Ngày bản giao'), 'end_time', @$data->end_time?@$data->end_time:date('Y-m-d H:i:s'), FSText :: _('Bạn vui lòng chọn thời gian hiển thị'), 20);
    TemplateHelper::dt_date_pick ( FSText :: _('Ngày bảo dưỡng tiếp theo' ), 'start_time', @$data->start_time?@$data->start_time:date('Y-m-d H:i:s'), FSText :: _('Bạn vui lòng chọn thời gian hiển thị'), 20);
    
    TemplateHelper::dt_checkbox(FSText::_('Tình trạng'),'status',@$data -> status,0,array(1=>'Đã bảo dưỡng',0=>'Chưa bảo dưỡng'));
    TemplateHelper::dt_checkbox(FSText::_('Hình thức nhắc nhở'),'is_prompt',@$data -> is_prompt,0,array(1=>'email',0=>'tắt nhắc'));
    
    TemplateHelper::dt_edit_text(FSText :: _('Ghi chú'),'note',@$data -> note,'',100,9);
    
    TemplateHelper::dt_checkbox(FSText::_('Published'),'published',@$data -> published,1);

	TemplateHelper::dt_edit_text(FSText :: _('Ordering'),'ordering',@$data -> ordering,@$maxOrdering,'20');
    TemplateHelper::dt_sepa();
    TemplateHelper::dt_edit_selectbox(FSText::_('Dự án bảo trì'),'maintenance_id',$data->maintenance_id,0,$maintenance,$field_value = 'id', $field_label='full_name',$size = 1,0);

	$this -> dt_form_end(@$data,1,0);
	
?>

