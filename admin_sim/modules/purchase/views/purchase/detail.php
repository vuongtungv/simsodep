<?php
$title = @$data ? FSText :: _('Edit'): FSText :: _('Add'); 
global $toolbar;
$toolbar->setTitle($title);
$toolbar->addButton('back',FSText :: _('Cancel'),'','back.png');   

	$this -> dt_form_begin();
	
	TemplateHelper::dt_edit_text(FSText :: _('Tên  người gửi'),'fullname',@$data -> fullname);
	TemplateHelper::dt_edit_text(FSText :: _('Email'),'email',@$data -> email);
	TemplateHelper::dt_edit_text(FSText :: _('Điện thoại'),'telephone',@$data -> telephone);
	TemplateHelper::dt_edit_text(FSText :: _('Thương hiệu'),'trademark',@$data -> trademark);
	TemplateHelper::dt_edit_text(FSText :: _('Ngày mua'),'date',@$data -> date?date('d-m-Y',strtotime(@$data -> date)):'','','12',1,0);
	TemplateHelper::dt_edit_text(FSText :: _('Hộp bảo hành'),'care',@$data -> care);
	TemplateHelper::dt_edit_text(FSText :: _('Giá đề nghị'),'price',@$data -> price);	
	TemplateHelper::dt_edit_image(FSText :: _('Image'),'image',URL_ROOT.str_replace('/original/','/resized/',@$data->image));
	TemplateHelper::dt_edit_text(FSText :: _('Mô tả'),'description',@$data -> description,'',100,9);
	$this -> dt_form_end(@$data,1,0);

?>
