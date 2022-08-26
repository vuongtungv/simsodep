<?php
    $title = @$data ? FSText :: _('Edit'): FSText :: _('Add'); 
    global $toolbar;
    $toolbar->setTitle($title);
    $toolbar->addButton('save_add',FSText :: _('Save and new'),'','save_add.png');
    $toolbar->addButton('apply',FSText :: _('Apply'),'','apply.png'); 
    $toolbar->addButton('Save',FSText :: _('Save'),'','save.png'); 
    $toolbar->addButton('back',FSText :: _('Cancel'),'','cancel.png');   

	$this -> dt_form_begin(1,4,$title.' '.FSText::_('Đối tác'));

	TemplateHelper::dt_edit_text(FSText :: _('Name'),'name',@$data -> name);
	TemplateHelper::dt_edit_text(FSText :: _('Alias'),'alias',@$data -> alias,'',60,1,0,FSText::_("Can auto generate"));
    //TemplateHelper::dt_edit_selectbox(FSText::_('Categories'),'category_id',@$data -> category_id,0,$categories,$field_value = 'id', $field_label='treename',$size = 1,0);
	TemplateHelper::dt_edit_image(FSText :: _('Image'),'image',URL_ROOT.str_replace('/original/','/resized/', @$data->image),'','');
	TemplateHelper::dt_edit_text(FSText :: _('Địa chỉ'),'adress',@$data -> adress);
	TemplateHelper::dt_edit_text(FSText :: _('Lĩnh vực'),'field',@$data -> field);	
	TemplateHelper::dt_edit_text(FSText :: _('Url'),'url',@$data -> url,'',80,1,0);
	TemplateHelper::dt_checkbox(FSText::_('Published'),'published',@$data -> published,1);
	TemplateHelper::dt_edit_text(FSText :: _('Ordering'),'ordering',@$data -> ordering,@$maxOrdering,'20');
    
	$this -> dt_form_end(@$data);

?>
		
