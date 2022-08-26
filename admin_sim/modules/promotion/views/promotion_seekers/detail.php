<?php
$title = @$data ? FSText :: _('Edit'): FSText :: _('Add'); 
global $toolbar;
$toolbar->setTitle($title);
//$toolbar->addButton('apply',FSText :: _('Apply'),'','apply.png'); 
//$toolbar->addButton('Save',FSText :: _('Save'),'','save.png'); 
$toolbar->addButton('back',FSText :: _('Cancel'),'','cancel.png');   
$array_check_questions_answers = array(
    1=>FSText::_('Đăng thông báo khóa học và Tin tuyển sinh'),
    2=>FSText::_('Tìm khóa học và Tin tuyển sinh'),
    3=>FSText::_('Tìm kiếm thí sinh toàn năng'),
    4=>FSText::_('E-Marketing khóa học và tin tuyển sinh đến thí sinh'),
    5=>FSText::_('Tất cả cá phương án trên'),
);

	//$this -> dt_form_begin(0);
    $this -> dt_form_begin(1,4,$title.' '.FSText::_('Sửa'),'fa-edit',1,'col-md-12',1);
        TemplateHelper::dt_edit_selectbox(FSText::_('Chương trình KM'),'promotion_id',@$data -> promotion_id,0,$promotion,$field_value = 'id', $field_label='title',$size = 10,0);
        TemplateHelper::dt_edit_text(FSText::_('Name'),'name',@$data -> name);
    	TemplateHelper::dt_edit_text(FSText::_('Năm sinh'),'birthyear',@$data -> birthyear);
        TemplateHelper::dt_edit_text(FSText::_('Địa chỉ'),'address',@$data -> address);
        TemplateHelper::dt_edit_text(FSText::_('Email'),'email',@$data -> email);
        TemplateHelper::dt_edit_text(FSText::_('Số điện thoại'),'telephone',@$data -> telephone);
        TemplateHelper::dt_edit_text(FSText::_('Trình độ văn hóa hiện tại'),'degree',@$data -> degree);
        TemplateHelper::dt_edit_text(FSText::_('Tình trạng học tập hiện nay'),'academic_status',@$data -> academic_status);
        TemplateHelper::dt_edit_text(FSText::_('Năm tốt nghiệp'),'graduation_year',@$data -> graduation_year);
//        TemplateHelper::dt_edit_selectbox(FSText::_('Đáp án lựa chọn'),'',@$data->questions_answers,0,$array_check_questions_answers,$field_value = '', $field_label='',$size = 1,0);
        if($data->questions_answers_1 != 0){
        ?><hr><?php 
            TemplateHelper::dt_edit_text(FSText::_('Câu hỏi khảo sát 1'),'category_name',@$answers1 -> category_name);
            TemplateHelper::dt_edit_text(FSText::_('Lựa chọn khảo sát 1'),'title',@$answers1 -> title);
        }
        if($data->questions_answers_2 != 0){
        ?><hr><?php 
            TemplateHelper::dt_edit_text(FSText::_('Câu hỏi khảo sát 2'),'category_name',@$answers2 -> category_name);
            TemplateHelper::dt_edit_text(FSText::_('Lựa chọn khảo sát 2'),'title',@$answers2 -> title);
        }
        if($data->questions_answers_3 != 0){
        ?><hr><?php 
            TemplateHelper::dt_edit_text(FSText::_('Câu hỏi khảo sát 3'),'category_name',@$answers3 -> category_name);
            TemplateHelper::dt_edit_text(FSText::_('Lựa chọn khảo sát 3'),'title',@$answers3 -> title);
        }
        if($data->questions_answers_4 != 0){
        ?><hr><?php 
            TemplateHelper::dt_edit_text(FSText::_('Câu hỏi khảo sát 4'),'category_name',@$answers4 -> category_name);
            TemplateHelper::dt_edit_text(FSText::_('Lựa chọn khảo sát 4'),'title',@$answers4 -> title);
        }
        if($data->questions_answers_5 != 0){
        ?><hr><?php 
            TemplateHelper::dt_edit_text(FSText::_('Câu hỏi khảo sát 5'),'category_name',@$answers5 -> category_name);
            TemplateHelper::dt_edit_text(FSText::_('Lựa chọn khảo sát 5'),'title',@$answers5 -> title);
        }
        TemplateHelper::datetimepicke( FSText::_('Published time' ), 'created_time', @$data->created_time?@$data->created_time:date('Y-m-d H:i:s'), FSText :: _('Bạn vui lòng chọn thời gian hiển thị'), 20,'','col-md-3','col-md-4');
        TemplateHelper::dt_edit_text(FSText::_('Cảm tưởng'),'content',@$data -> content,'',100,5,0,'','','col-md-3','col-md-9');
	$this->dt_form_end_col(); // END: col-1s
    $this -> dt_form_end(@$data,1,0,2,'Cấu hình seo','',1,'col-sm-4'); 
?>
