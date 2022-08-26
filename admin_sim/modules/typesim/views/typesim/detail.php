<?php
    $title = @$data ? FSText :: _('Xem'): FSText :: _('Add'); 
    global $toolbar;
    $toolbar->setTitle($title);
    $toolbar->addButton('apply',FSText :: _('Apply'),'','apply.png');
    $toolbar->addButton('Save',FSText :: _('Save'),'','save.png');
    $toolbar->addButton('back',FSText :: _('Cancel'),'','cancel.png');   

	$this -> dt_form_begin(1,4,$title.' '.FSText::_('Phương thức'));

    TemplateHelper::dt_edit_text(FSText :: _('Title'),'title',@$data -> title);
    TemplateHelper::dt_checkbox(FSText::_('Khách hàng quen'),'type_id',@$data -> type_id,0);
    TemplateHelper::dt_edit_text(FSText :: _('Thứ tự'),'ordering',@$data -> ordering);
    TemplateHelper::dt_edit_text(FSText :: _('Nội dung'),'content',@$data -> content,'',650,450,1,'','','col-sm-3','col-sm-9');
    
    $this -> dt_form_end(@$data,1);  
?>