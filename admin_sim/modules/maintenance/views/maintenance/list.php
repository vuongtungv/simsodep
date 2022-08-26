<script language="javascript" type="text/javascript" src="../libraries/jquery/jquery.ui/jquery-ui.js"></script>
<link rel="stylesheet" type="text/css" media="screen" href="../libraries/jquery/jquery.ui/jquery-ui.css" />
<?php  
	global $toolbar;
	$toolbar->setTitle(FSText :: _('Member List') );
	$toolbar->addButton('save_all',FSText :: _('Save'),'','save.png'); 
	$toolbar->addButton('add',FSText :: _('Add'),'','add.png'); 
	$toolbar->addButton('edit',FSText :: _('Edit'),FSText :: _('You must select at least one record'),'edit.png'); 
	$toolbar->addButton('remove',FSText :: _('Remove'),FSText :: _('You must select at least one record'),'remove.png'); 
	$toolbar->addButton('published',FSText :: _('Published'),FSText :: _('You must select at least one record'),'published.png');
	$toolbar->addButton('unpublished',FSText :: _('Unpublished'),FSText :: _('You must select at least one record'),'unpublished.png');
	
	//	FILTER
	$filter_config  = array();
	$fitler_config['search'] = 1; 
	$fitler_config['filter_count'] = 1;
    $fitler_config['text_count'] = 2;

	$filter_members = array();
	$filter_members['title'] = FSText::_('Thành viên'); 
	$filter_members['list'] = @$members; 
	$filter_members['field'] = 'full_name'; 
    
    $text_from_date = array();
	$text_from_date['title'] =  FSText::_('From day'); 
	
	$text_to_date = array();
	$text_to_date['title'] =  FSText::_('To day');  
    
	$fitler_config['filter'][] = $filter_members;
    $fitler_config['text'][] = $text_from_date;
	$fitler_config['text'][] = $text_to_date;
    
	//	CONFIG	
	$list_config = array();
    $list_config[] = array('title'=>'Đối tác','field'=>'name','type'=>'text','align'=>'left');
	$list_config[] = array('title'=>'Địa chỉ','field'=>'address','type'=>'text','align'=>'left');
    $list_config[] = array('title'=>'Người liên lạc','field'=>'name_contact','type'=>'text','align'=>'left');
    $list_config[] = array('title'=>'Sô điện thoại','field'=>'hotline','type'=>'text','align'=>'left');
    
    $list_config[] = array('title'=>'Ordering','field'=>'ordering','ordering'=> 1, 'type'=>'edit_text','arr_params'=>array('size'=>3));
	
    $list_config[] = array('title'=>'Created time','field'=>'created_time','ordering'=> 1, 'type'=>'datetime');
    $list_config[] = array('title'=>'Published','field'=>'published','ordering'=> 1, 'type'=>'published');
	$list_config[] = array('title'=>'Edit','type'=>'edit');
	$list_config[] = array('title'=>'Id','field'=>'id','ordering'=> 1, 'type'=>'text');
	
	TemplateHelper::genarate_form_liting($this->module,$this -> view,$list,$fitler_config,$list_config,$sort_field,$sort_direct,$pagination);
?>
<script>
	$(function() {
		$( "#text0" ).datepicker({
		  clickInput:true,
          dateFormat: 'dd-mm-yy',
          changeMonth: true,
          numberOfMonths: 2,
          changeYear: true,
          maxDate:  " + d ",
          showMonthAfterYear: true
        });
		$( "#text1" ).datepicker({
		  clickInput:true,
          dateFormat: 'dd-mm-yy',
          changeMonth: true,
          numberOfMonths: 2,
          changeYear: true,
          maxDate:  " + d ",
          showMonthAfterYear: true
        });
	});
</script>