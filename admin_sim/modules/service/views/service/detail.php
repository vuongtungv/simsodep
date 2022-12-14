<?php
	$title = @$data ? FSText :: _('Sửa'): FSText :: _('Thêm mới');
	global $toolbar;
	$toolbar->setTitle($title);
	//$toolbar->addButton('save_add',FSText :: _('Save and new'),'','save_add.png');
	$toolbar->addButton('apply',FSText::_('Apply'),'','apply.png');
	$toolbar->addButton('save',FSText::_('Save'),'','save.png');
	$toolbar->addButton('cancel',FSText::_('Cancel'),'','cancel.png');

	$this -> dt_form_begin();
	TemplateHelper::dt_edit_text(FSText :: _('Name'),'name',@$data -> name);
	TemplateHelper::dt_edit_text(FSText :: _('Alias'),'alias',@$data -> alias,'',60,1,0,FSText::_("Can auto generate"));
    
    //TemplateHelper::dt_checkbox(FSText::_('Dịch vụ đăng tuyển cơ bản'),'is_basic',@$data -> is_basic,0,'','',FSText::_('Chỉ có duy nhất 1 dịch vụ được chọn là đăng tuyển cơ bản'));
    
	TemplateHelper::dt_edit_text(FSText :: _('Giá'),'price',@$data -> price);

	TemplateHelper::dt_checkbox(FSText::_('Dịch vụ có sử dụng tới tìm kiếm'),'is_search',@$data -> is_search,0,'','',FSText::_('Xuất hiện danh sách lĩnh vực ngành nghề.'));
	TemplateHelper::dt_checkbox(FSText::_('Kiểu thời gian sử dụng dịch vụ'),'is_type',@$data -> is_type,0,array(0 => FSText::_('Để trống'),1 => FSText::_('Ngay'), 2 => FSText::_('Tuần')),'',FSText::_('kiểu hiển thị tương tác'));
	TemplateHelper::dt_edit_text(FSText :: _('Ngày'),'days',@$data -> days,'',60,1,0,FSText::_("Nhập đối với tất cả dịch vụ"));
	// TemplateHelper::dt_edit_text(FSText :: _('Mã'),'code',@$data -> code);
	//TemplateHelper::dt_edit_image(FSText :: _('Image'),'image',URL_ROOT.@$data->image);
    
	// TemplateHelper::dt_edit_selectbox(FSText::_('Sử dụng cho các bảng'),'tablenames',@$data -> tablenames,0,$tables,'table_name','table_name',$size = 10,1,0,'Giữ phím Ctrl để chọn nhiều item');
	TemplateHelper::dt_checkbox(FSText::_('Published'),'published',@$data -> published,1);
	TemplateHelper::dt_edit_text(FSText :: _('Ordering'),'ordering',@$data -> ordering,@$maxOrdering,'20');

	TemplateHelper::dt_edit_text(FSText :: _('Summary'),'summary',@$data -> summary,'',100,9);
	//TemplateHelper::dt_edit_text(FSText :: _('Content'),'contents',@$data -> contents,'',650,450,1);
	$this -> dt_form_end(@$data);
?>
