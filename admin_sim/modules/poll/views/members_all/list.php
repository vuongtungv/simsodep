<?php  
	global $toolbar;
	$toolbar->setTitle(FSText :: _('Kết quả khảo sát') );
//	$toolbar->addButton('add',FSText :: _('Add'),'','add.png'); 
	$toolbar->addButton('edit',FSText :: _('Xem kết quả'),FSText :: _('You must select at least one record'),'edit.png'); 
//	$toolbar->addButton('remove',FSText :: _('Remove'),FSText :: _('You must select at least one record'),'remove.png'); 
//	$toolbar->addButton('published',FSText :: _('Published'),FSText :: _('You must select at least one record'),'published.png');
//	$toolbar->addButton('unpublished',FSText :: _('Unpublished'),FSText :: _('You must select at least one record'),'unpublished.png');
	
	//	FILTER
	$filter_config  = array();
	$fitler_config['search'] = 1; 
	$fitler_config['filter_count'] = 0;

	$filter_categories = array();
	$filter_categories['title'] = FSText::_('Khảo sát'); 
	$filter_categories['list'] = @$categories; 
	$filter_categories['field'] = 'treename'; 
	
	$fitler_config['filter'][] = $filter_categories;																																																																																																																																																																																																																																																																																																																																																																																																																						

	//	CONFIG	
	$list_config = array();
	$list_config[] = array('title'=>'Câu hỏi','field'=>'name','ordering'=> 1, 'type'=>'text','col_width' => '50%','arr_params'=>array('size'=> 30));
	$list_config[] = array('title'=>'Số lượt khảo sát','field'=>'total_poll','ordering'=> 1, 'type'=>'text','arr_params'=>array('size'=> 3));
	$list_config[] = array('title'=>'Xem kết quả','type'=>'edit');
//	$list_config[] = array('title'=>'Created time','field'=>'created_time','ordering'=> 1, 'type'=>'datetime');
	$list_config[] = array('title'=>'Id','field'=>'id','ordering'=> 1, 'type'=>'text');
	
	TemplateHelper::genarate_form_liting($this->module,$this -> view,$list,$fitler_config,$list_config,$sort_field,$sort_direct,$pagination);
		?>
