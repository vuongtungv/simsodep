<?php
$title = @$data ? FSText :: _('Edit'): FSText :: _('Add'); 
global $toolbar;
$toolbar->setTitle($title);
$toolbar->addButton('save_add',FSText :: _('Save and new'),'','save_add.png'); 
$toolbar->addButton('apply',FSText :: _('Apply'),'','apply.png'); 
$toolbar->addButton('Save',FSText :: _('Save'),'','save.png'); 
$toolbar->addButton('back',FSText :: _('Cancel'),'','back.png');   


	//$this -> dt_form_begin(0);
    $this -> dt_form_begin(1,4,$title.' '.FSText::_('Sửa'),'fa-edit',1,'col-md-12',1);
    
    TemplateHelper::dt_edit_text(FSText :: _('Title'),'title',@$data -> title);
	TemplateHelper::dt_edit_text(FSText :: _('Alias'),'alias',@$data -> alias,'',60,1,0,FSText::_("Can auto generate"));
	// $sub_time_start = TemplateHelper::sub_edit_text('&nbsp;&nbsp;&nbsp;','published_hour_start',@$data -> date_start?date('H:i',strtotime(@$data -> date_start)):'','','5',1);
	// TemplateHelper::dt_edit_text(FSText :: _('Ngày bắt đầu'),'date_start',@$data -> date_start?date('d-m-Y',strtotime(@$data -> date_start)):'','','12',1,0,'Nhập dạng <strong>dd-mm-YYYY HH:mm</strong>.',$sub_time_start);
	$sub_time_end = TemplateHelper::sub_edit_text('&nbsp;&nbsp;&nbsp;','published_hour_end',@$data -> date_end?date('H:i',strtotime(@$data -> date_end)):'','','5',1);
	TemplateHelper::dt_edit_text(FSText :: _('Ngày hết hạn'),'date_end',@$data -> date_end?date('d-m-Y',strtotime(@$data -> date_end)):'','','12',1,0,'Nhập dạng <strong>dd-mm-YYYY HH:mm</strong>.',$sub_time_end);
	TemplateHelper::dt_checkbox(FSText::_('Published'),'published',@$data -> published,1);
	TemplateHelper::dt_checkbox(FSText::_('Dành cho'),'is_types',@$data -> is_types,0,array(0=>FSText::_('Thí sinh'),1=>FSText::_('Nhà đào tạo'),2=>FSText::_('Form khảo sát')));
//	TemplateHelper::dt_checkbox(FSText::_('Dành cho Nhà Đào tạo'),'is_employer',@$data -> is_employer,0);
	TemplateHelper::dt_edit_text(FSText :: _('Ordering'),'ordering',@$data -> ordering,@$maxOrdering,'20');
	TemplateHelper::dt_edit_text(FSText :: _('Content'),'content',@$data -> content,'',650,450,1);

	$this->dt_form_end_col(); // END: col-1s
    $this -> dt_form_end(@$data,1,0,2,'Cấu hình seo','',1,'col-sm-4');
?>
<script  type="text/javascript" language="javascript">
$(function() {
	$( "#date_end" ).datepicker({clickInput:true,dateFormat: 'dd-mm-yy',changeMonth: true, changeYear: true});
	$( "#date_end").change(function() {
		document.formSearch.submit();
	});
	// $( "#date_start" ).datepicker({clickInput:true,dateFormat: 'dd-mm-yy',changeMonth: true, changeYear: true});
	// $( "#date_start").change(function() {
	// 	document.formSearch.submit();
	// });
});
</script>