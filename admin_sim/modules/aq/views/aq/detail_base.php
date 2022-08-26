<table cellspacing="1" class="admintable">
<?php 
	
	TemplateHelper::dt_edit_text(FSText :: _('Tiêu đề'),'title',@$data -> title);
//	TemplateHelper::dt_edit_text(FSText :: _('Alias'),'alias',@$data -> alias,'',60,1,0,FSText::_("Can auto generate"));
	TemplateHelper::dt_edit_selectbox(FSText::_('Categories'),'category_id',@$data -> category_id,0,$categories,$field_value = 'id', $field_label='treename',$size = 0,0);
	//TemplateHelper::dt_edit_image(FSText :: _('Image'),'image',URL_ROOT.@$data->image);
    TemplateHelper::dt_date_pick ( FSText :: _('Published time' ), 'created_time', @$data->created_time?@$data->created_time:date('Y-m-d H:i:s'), FSText :: _('Bạn vui lòng chọn thời gian hiển thị'), 20);
    TemplateHelper::dt_edit_text(FSText :: _('Tên người hỏi'),'asker',@$data -> asker);
    TemplateHelper::dt_edit_text(FSText :: _('Email người hỏi'),'email',@$data -> email);
    TemplateHelper::dt_edit_text(FSText :: _('Nội dung câu hỏi'),'question',@$data -> question,'',100,9);
    TemplateHelper::dt_edit_text(FSText :: _('Số lượng phản hồi hữu ích'),'useful',@$data -> useful);
    TemplateHelper::dt_edit_text(FSText :: _('Số lượng phản hồi không hữu ích'),'un_useful',@$data -> un_useful);
    TemplateHelper::dt_checkbox(FSText::_('Phổ biến'),'is_common',@$data -> is_common,1);
	

//	TemplateHelper::dt_edit_text(FSText :: _('Người hỏi'),'asker',@$data -> asker,'',60,1);
//	TemplateHelper::dt_edit_text(FSText :: _('Email'),'email',@$data -> email,'',60,1);
	TemplateHelper::dt_edit_text(FSText :: _('Ordering'),'ordering',@$data -> ordering,@$maxOrdering,'20');
	TemplateHelper::dt_checkbox(FSText::_('Published'),'published',@$data -> published,1);
//	TemplateHelper::dt_edit_text(FSText :: _('Câu hỏi'),'question',@$data -> question,'',100,9);
	TemplateHelper::dt_edit_text(FSText :: _('Trả lời'),'content',@$data -> content,'',650,450,1);
	//TemplateHelper::dt_edit_text(FSText :: _('Tags'),'tags',@$data -> tags,'',100,4);

?>
</table>
