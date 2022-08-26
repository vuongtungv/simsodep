<?php
$title = @$data ? FSText :: _('Edit'): FSText :: _('Add'); 
global $toolbar;
$toolbar->setTitle($title);
$toolbar->addButton('apply',FSText :: _('Apply'),'','apply.png'); 
$toolbar->addButton('Save',FSText :: _('Save'),'','save.png'); 
$toolbar->addButton('back',FSText :: _('Cancel'),'','back.png');   
$this -> dt_form_begin(1);
TemplateHelper::dt_edit_text(FSText :: _('Nhóm câu hỏi'),'name',@$data -> name);
TemplateHelper::dt_edit_text(FSText :: _('Ordering'),'ordering',@$data -> ordering,@$maxOrdering,'20');
TemplateHelper::dt_checkbox(FSText::_('Published'),'published',@$data -> published,1);
$this -> dt_form_end(@$data,1);