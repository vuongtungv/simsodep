
<?php
    $title = @$data ? FSText :: _('Edit'): FSText :: _('Add'); 
    global $toolbar;
    $toolbar->setTitle($title);
    $toolbar->addButton('apply',FSText :: _('Apply'),'','apply.png'); 
    $toolbar->addButton('Save',FSText :: _('Save'),'','save.png'); 
    $toolbar->addButton('back',FSText :: _('Cancel'),'','cancel.png');   

	$this -> dt_form_begin(1,4,$title.' '.FSText::_('Hạng khách hàng'));
	
	TemplateHelper::dt_edit_text(FSText :: _('Tên hạng'),'name',@$data -> name);
	TemplateHelper::dt_checkbox(FSText::_('Published'),'published',@$data -> published,1);
	TemplateHelper::dt_edit_text(FSText :: _('Số lượng giao dịch thành công cần đạt'),'quantity',@$data -> quantity);
	// TemplateHelper::dt_edit_text(FSText :: _('Mức giảm(%)'),'discount',@$data -> discount);
	TemplateHelper::dt_edit_text(FSText :: _('Quà tặng'),'gift',@$data -> gift);
	TemplateHelper::dt_edit_text(FSText :: _('Thời gian có hiệu lực'),'time',@$data -> time);
	TemplateHelper::dt_edit_text(FSText :: _('Ordering'),'ordering',@$data -> ordering,@$maxOrdering,'20');
	TemplateHelper::dt_edit_text(FSText :: _('Ghi chú'),'note',@$data -> note,'',100,4);
?>
<?php 
	include_once 'detail_price.php';
//	TemplateHelper::dt_edit_text(FSText :: _('Tags'),'tags',@$data -> tags,'',100,4);
	$this -> dt_form_end(@$data,1);

?>


