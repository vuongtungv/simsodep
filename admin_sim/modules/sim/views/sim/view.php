
<?php
	$title = @$data ? FSText :: _('Thông tin chi tiết'):''; 
	global $toolbar;
	$toolbar->setTitle($title);
	$toolbar->addButton('back',FSText :: _('Cancel'),'','cancel.png');   
	
    $data_partner=@$data ->agency;

    $cat = sim(@$data -> number,@$data -> price_public);

    $this -> dt_form_begin();

    TemplateHelper::dt_edit_text(FSText :: _('Sim'),'sim',@$data -> sim);
    TemplateHelper::dt_edit_text(FSText :: _('Sim không dấu'),'number',@$data -> number);
    TemplateHelper::dt_edit_text(FSText :: _('Giá khuyến mại'),'price_old',format_money(@$data -> price));
    TemplateHelper::dt_edit_text(FSText :: _('Giá đại lý'),'price',format_money(@$data -> price));
    TemplateHelper::dt_edit_text(FSText :: _('Giá bán'),'price_public',format_money(@$data -> price_public));
    TemplateHelper::dt_edit_text(FSText :: _('Danh mục'),'ordering',$cat);
    TemplateHelper::dt_edit_text(FSText :: _('Tổng điểm'),'point',@$data -> point);
    TemplateHelper::dt_edit_text(FSText :: _('Tổng nút'),'button',@$data -> button);
    TemplateHelper::dt_edit_text(FSText :: _('Nhà mạng'),'network',@$data -> network);
    TemplateHelper::dt_edit_text(FSText :: _('Đại lý'),'agency_name',@$data -> agency_name);
    TemplateHelper::datetimepicke( FSText :: _('Published time' ), 'created_time', @$data->created_time?@$data->created_time:date('Y-m-d H:i:s'),'', 20,'','col-md-3','col-md-4');
    
?>
<?php
    $this -> dt_form_end(@$data,1,0); 
?>
