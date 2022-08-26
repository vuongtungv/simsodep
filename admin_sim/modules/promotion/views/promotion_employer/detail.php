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
        TemplateHelper::dt_edit_text(FSText::_('Tên Nhà Tuyển sinh/Nhà Đào tạo'),'name',@$data -> name);
    	TemplateHelper::dt_edit_text(FSText::_('Địa chỉ liên hệ'),'address',@$data -> address);
        TemplateHelper::dt_edit_text(FSText::_('Người liên hệ'),'fullname',@$data -> fullname);
        TemplateHelper::dt_edit_text(FSText::_('Bộ phận/Chức danh'),'contact_parts',@$data -> contact_parts);
        TemplateHelper::dt_edit_text(FSText::_('Email'),'email',@$data -> email);
        TemplateHelper::dt_edit_text(FSText::_('Điện thoại liên hệ'),'telephone',@$data -> telephone);
        TemplateHelper::dt_edit_text(FSText::_('Website'),'website',@$data -> website);
        TemplateHelper::dt_edit_text(FSText::_('FB/Fanpage'),'facebook',@$data -> facebook);
        TemplateHelper::datetimepicke( FSText::_('Published time' ), 'created_time', @$data->created_time?@$data->created_time:date('Y-m-d H:i:s'), FSText :: _('Bạn vui lòng chọn thời gian hiển thị'), 20,'','col-md-3','col-md-4');
	$this->dt_form_end_col(); // END: col-1s
    $this -> dt_form_end(@$data,1,0,2,'Cấu hình seo','',1,'col-sm-4'); 
?>
