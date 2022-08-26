<!-- HEAD -->
	<?php 
	$fstring = FSFactory::getClass('FSString','','../');
	$code = $fstring->generateRandomString(8);
	$title = @$data ? FSText::_('Edit'): FSText::_('Add'); 
	global $toolbar;
	$toolbar->setTitle($title);
	$toolbar->addButton('apply',FSText::_('Apply'),'','apply.png'); 
	$toolbar->addButton('save',FSText::_('Save'),'','save.png'); 
	$toolbar->addButton('cancel',FSText::_('Cancel'),'','cancel.png');   
	
	$this -> dt_form_begin();
	
	TemplateHelper::dt_edit_text(FSText :: _('Name'),'name',@$data -> name);
	if(@$data)
		TemplateHelper::dt_edit_text(FSText :: _('Mã giảm giá'),'code',@$data->code);
	else 
		TemplateHelper::dt_edit_text(FSText :: _('Mã giảm giá'),'code',@$code);
//	TemplateHelper::dt_edit_text(FSText :: _('Alias'),'alias',@$data -> alias,'',60,1,0,FSText::_("Can auto generate"));
	
	// TemplateHelper::dt_edit_text(FSText :: _('Giới hạn'),'limit',@$data -> limit,100,'20',1,0,'Giới hạn số người được khuyến mãi');
	TemplateHelper::dt_edit_text(FSText :: _('Mức giảm'),'discount',@$data -> discount,10,'20');
	TemplateHelper::dt_edit_selectbox(FSText::_('Loại giảm giá'),'unit',@$data -> unit,0,array(1 => 'VNĐ',2=>'Phần trăm'),$field_value = 'id', $field_label='');
	// TemplateHelper::dt_edit_text(FSText :: _('Thời hạn sử dụng'),'activated_time',@$data -> activated_time,60,'20',1,0,'Hạn sử dụng tính theo ngày');
	TemplateHelper::datetimepicke( FSText :: _('Khuyến mại từ' ), 'date_start', @$data->date_start?@$data->date_start:date('Y-m-d H:i:s'),'', 20,'','col-md-3','col-md-4');
	TemplateHelper::datetimepicke( FSText :: _('Khuyến mại đến' ), 'date_end', @$data->date_end?@$data->date_end:date('Y-m-d H:i:s'),'', 20,'','col-md-3','col-md-4');
	
//	TemplateHelper::dt_edit_text(FSText :: _('Description'),'description',@$data -> description,'',650,450,1);
	TemplateHelper::dt_edit_text(FSText :: _('Ordering'),'ordering',@$data -> ordering,@$maxOrdering,'20');
	TemplateHelper::dt_checkbox(FSText::_('Published'),'published',@$data -> published,1);
	
	$this -> dt_form_end(@$data,1,0);
	
	?>

