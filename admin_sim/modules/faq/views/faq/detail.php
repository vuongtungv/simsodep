<?php
$title = @$data ? FSText :: _('Edit'): FSText :: _('Add'); 
global $toolbar;
$toolbar->setTitle($title);
$toolbar->addButton('apply',FSText :: _('Apply'),'','apply.png'); 
$toolbar->addButton('Save',FSText :: _('Save'),'','save.png'); 
$toolbar->addButton('back',FSText :: _('Cancel'),'','cancel.png');   
	
	//$this -> dt_form_begin(0);
    $this -> dt_form_begin(1,4,$title.' '.FSText::_('FAQ'),'fa-edit',1,'col-md-8',1);
     
        TemplateHelper::dt_edit_text(FSText :: _('Tiêu đề'),'title',@$data -> title);
    	TemplateHelper::dt_edit_text(FSText :: _('Alias'),'alias',@$data -> alias,'',60,1,0,FSText::_("Can auto generate"));
    	TemplateHelper::dt_edit_selectbox(FSText::_('Danh mục hỏi đáp'),'category_id',@$data -> category_id,0,$categories,$field_value = 'id', $field_label='treename',$size = 0,0);
    	//TemplateHelper::dt_edit_image(FSText :: _('Image'),'image',URL_ROOT.@$data->image);
        TemplateHelper::datetimepicke( FSText :: _('Published time' ), 'created_time', @$data->created_time?@$data->created_time:date('Y-m-d H:i:s'), FSText :: _('Bạn vui lòng chọn thời gian hiển thị'), 20,'','col-md-2','col-md-4');
        //TemplateHelper::dt_edit_text(FSText :: _('Tên người hỏi'),'asker',@$data -> asker);
        //TemplateHelper::dt_edit_text(FSText :: _('Email người hỏi'),'email',@$data -> email);
        //TemplateHelper::dt_edit_text(FSText :: _('Nội dung câu hỏi'),'question',@$data -> question,'',100,9);
        //TemplateHelper::dt_edit_text(FSText :: _('Số lượng phản hồi hữu ích'),'useful',@$data -> useful);
        //TemplateHelper::dt_edit_text(FSText :: _('Số lượng phản hồi không hữu ích'),'un_useful',@$data -> un_useful);
        //TemplateHelper::dt_checkbox(FSText::_('Phổ biến'),'is_common',@$data -> is_common,1);
	$this->dt_form_end_col(); // END: col-1

    $this -> dt_form_begin(1,4,FSText::_('Kích hoạt'),'fa-unlock',1,'col-md-4 fl-right');
        TemplateHelper::dt_checkbox(FSText::_('Published'),'published',@$data -> published,1,'','','','col-sm-4','col-sm-6');
        TemplateHelper::dt_edit_text(FSText :: _('Ordering'),'ordering',@$data -> ordering,@$maxOrdering,'','',0,'','','col-sm-4','col-sm-6');
    $this->dt_form_end_col(); // END: col-2
    
    $this -> dt_form_begin(1,4,FSText::_('Trả lời'),'fa-unlock',1,'col-md-12');
        TemplateHelper::dt_edit_text(FSText :: _(''),'content',@$data -> content,'',650,450,1,'','','col-sm-2','col-sm-12');
    $this->dt_form_end_col(); // END: col-2
//	TemplateHelper::dt_edit_text(FSText :: _('Người hỏi'),'asker',@$data -> asker,'',60,1);
//	TemplateHelper::dt_edit_text(FSText :: _('Email'),'email',@$data -> email,'',60,1);
	//TemplateHelper::dt_edit_text(FSText :: _('Ordering'),'ordering',@$data -> ordering,@$maxOrdering,'20');
	//TemplateHelper::dt_checkbox(FSText::_('Published'),'published',@$data -> published,1);
//	TemplateHelper::dt_edit_text(FSText :: _('Câu hỏi'),'question',@$data -> question,'',100,9);
	
	//TemplateHelper::dt_edit_text(FSText :: _('Tags'),'tags',@$data -> tags,'',100,4); 
    
    $this -> dt_form_end(@$data,1,0,2,'Cấu hình seo','',1,'col-sm-4'); 
    //$this -> dt_form_end(@$data,0);
?>
