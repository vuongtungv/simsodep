<?php
$title = @$data ? FSText :: _('Edit'): FSText :: _('Add'); 
global $toolbar;
$toolbar->setTitle($title);
//$toolbar->addButton('apply',FSText :: _('Apply'),'','apply.png'); 
//$toolbar->addButton('Save',FSText :: _('Save'),'','save.png'); 
$toolbar->addButton('back',FSText :: _('Cancel'),'','cancel.png');   
$array_check_members = array(
    1=>FSText::_('Thành viên Thí sinh của website Ketnoigiaoduc.vn'),
    2=>FSText::_('Thành viên Nhà Tuyển sinh / Nhà Đào tạo của website Ketnoigiaoduc.vn'),
    3=>FSText::_('Không phải là thành viên của website Ketnoigiaoduc.vn'),
);

	//$this -> dt_form_begin(0);
    $this -> dt_form_begin(1,4,$title.' '.FSText::_('Sửa'),'fa-edit',1,'col-md-12',1);
        TemplateHelper::dt_edit_selectbox(FSText::_('Đợt khảo sát'),'promotion_id',@$data -> promotion_id,0,$promotion,$field_value = 'id', $field_label='title',$size = 10,0);
        TemplateHelper::dt_edit_text(FSText::_('Name'),'name',@$data -> name);
    	TemplateHelper::dt_edit_text(FSText::_('Ngày sinh'),'birthyear',@$data -> birthyear);
        TemplateHelper::dt_edit_text(FSText::_('Nghề nghiệp hiện tại'),'occupation',@$data -> occupation);
        TemplateHelper::dt_edit_text(FSText::_('Email'),'email',@$data -> email);
        TemplateHelper::dt_edit_text(FSText::_('Số điện thoại'),'telephone',@$data -> telephone);
        TemplateHelper::dt_edit_text(FSText::_('Facebook'),'facebook',@$data -> facebook);
        TemplateHelper::dt_edit_selectbox(FSText::_('Bạn đang là'),'',@$data->check_members,0,$array_check_members,$field_value = '', $field_label='',$size = 1,0);
        if($data->answers_1 != 0){
        ?><hr><?php 
            TemplateHelper::dt_edit_text(FSText::_('Câu hỏi khảo sát 1'),'category_name',@$answers1 -> category_name);
            TemplateHelper::dt_edit_text(FSText::_('Lựa chọn khảo sát 1'),'title',@$answers1 -> title);
        }
        if($data->answers_2 != 0){
        ?><hr><?php 
            TemplateHelper::dt_edit_text(FSText::_('Câu hỏi khảo sát 2'),'category_name',@$answers2 -> category_name);
            TemplateHelper::dt_edit_text(FSText::_('Lựa chọn khảo sát 2'),'title',@$answers2 -> title);
        }
        if($data->answers_3 != 0){
        ?><hr><?php 
            TemplateHelper::dt_edit_text(FSText::_('Câu hỏi khảo sát 3'),'category_name',@$answers3 -> category_name);
            TemplateHelper::dt_edit_text(FSText::_('Lựa chọn khảo sát 3'),'title',@$answers3 -> title);
        }
        if($data->answers_4 != 0){
        ?><hr><?php 
            TemplateHelper::dt_edit_text(FSText::_('Câu hỏi khảo sát 4'),'category_name',@$answers4 -> category_name);
            TemplateHelper::dt_edit_text(FSText::_('Lựa chọn khảo sát 4'),'title',@$answers4 -> title);
        }
        if($data->answers_5 != 0){
        ?><hr><?php 
            TemplateHelper::dt_edit_text(FSText::_('Câu hỏi khảo sát 5'),'category_name',@$answers5 -> category_name);
            TemplateHelper::dt_edit_text(FSText::_('Lựa chọn khảo sát 5'),'title',@$answers5 -> title);
        }
        TemplateHelper::datetimepicke( FSText::_('Published time' ), 'created_time', @$data->created_time?@$data->created_time:date('Y-m-d H:i:s'), FSText :: _('Bạn vui lòng chọn thời gian hiển thị'), 20,'','col-md-3','col-md-4');
	$this->dt_form_end_col(); // END: col-1s
//    $this -> dt_form_begin(1,4,FSText::_('Kích hoạt'),'fa-unlock',1,'col-md-4 fl-right');
//        TemplateHelper::dt_checkbox(FSText::_('Published'),'published',@$data -> published,1,'','','','col-sm-4','col-sm-6');
//        TemplateHelper::dt_edit_text(FSText :: _('Ordering'),'ordering',@$data -> ordering,@$maxOrdering,'','',0,'','','col-sm-4','col-sm-6');
//    $this->dt_form_end_col(); // END: col-2
    $this -> dt_form_end(@$data,1,0,2,'Cấu hình seo','',1,'col-sm-4'); 
?>
