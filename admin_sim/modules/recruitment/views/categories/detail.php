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
	//TemplateHelper::dt_edit_selectbox(FSText::_('Parent'),'parent_id',@$data -> parent_id,0,$categories,$field_value = 'id', $field_label='treename',$size = 1,0,1);
	//TemplateHelper::dt_edit_image(FSText :: _('Image'),'image',URL_ROOT.str_replace('/original/','/resized/',@$data->image));
    TemplateHelper::dt_edit_text(FSText :: _('Khoảng giá'),'about_prices',@$data -> about_prices);
    TemplateHelper::dt_edit_text(FSText :: _('Address'),'address',@$data -> address);
    TemplateHelper::dt_checkbox(FSText::_('Published'),'published',@$data -> published,1);
    TemplateHelper::dt_date_pick ( FSText :: _('End date' ), 'end_date', @$data->end_date?@$data->end_date:date('Y-m-d H:i:s'),FSText :: _('Bạn vui lòng chọn thời gian hiển thị'), 20);
    
    TemplateHelper::dt_edit_text(FSText :: _('Ordering'),'ordering',@$data -> ordering,@$maxOrdering,'20');
    TemplateHelper::dt_edit_text(FSText :: _('Summary'),'summary',@$data -> summary,'',100,9);
    TemplateHelper::dt_edit_text(FSText :: _('Content'),'content',@$data -> content,'',650,450,1);
	
//	TemplateHelper::dt_edit_image(FSText :: _('Icon'),'icon',@$data -> icon);
	
	$this -> dt_form_end(@$data,1);
	
	?>

