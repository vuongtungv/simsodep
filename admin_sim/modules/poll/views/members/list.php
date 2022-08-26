<?php  
	global $toolbar;
	$toolbar->setTitle(FSText :: _('Hỏi đáp') );
//	$toolbar->addButton('add',FSText :: _('Add'),'','add.png'); 
	$toolbar->addButton('edit',FSText :: _('Edit'),FSText :: _('You must select at least one record'),'edit.png'); 
	$toolbar->addButton('remove',FSText :: _('Remove'),FSText :: _('You must select at least one record'),'remove.png'); 
//	$toolbar->addButton('published',FSText :: _('Published'),FSText :: _('You must select at least one record'),'published.png');
//	$toolbar->addButton('unpublished',FSText :: _('Unpublished'),FSText :: _('You must select at least one record'),'unpublished.png');
	
	//	FILTER
	$filter_config  = array();
	$fitler_config['search'] = 1; 
	$fitler_config['filter_count'] = 1;

	$filter_categories = array();
	$filter_categories['title'] = FSText::_('Đợt Khảo sát'); 
	$filter_categories['list'] = @$promotion; 
	$filter_categories['field'] = 'title'; 
	
	$fitler_config['filter'][] = $filter_categories;																																																																																																																																																																																																																																																																																																																																																																																																																						

	//	CONFIG	
	$list_config = array();
	$list_config[] = array('title'=>'Name','field'=>'name','ordering'=> 1, 'type'=>'text','col_width' => '25%','arr_params'=>array('size'=> 30));
	$list_config[] = array('title'=>'Email','field'=>'email','ordering'=> 1, 'type'=>'text','col_width' => '25%','arr_params'=>array('size'=> 30));
	$list_config[] = array('title'=>'Đợt khảo sát','field'=>'promotion_id','ordering'=> 1, 'type'=>'edit_selectbox','col_width' => '25%','arr_params'=>array('arry_select'=>$promotion,'field_value'=>'id','field_label'=>'title','size'=>1));
//	$list_config[] = array('title'=>'Published','field'=>'published','ordering'=> 1, 'type'=>'published');
	$list_config[] = array('title'=>'Xem','type'=>'edit');
	$list_config[] = array('title'=>'Created time','field'=>'created_time','ordering'=> 1, 'type'=>'datetime');
	$list_config[] = array('title'=>'Id','field'=>'id','ordering'=> 1, 'type'=>'text');
	
	TemplateHelper::genarate_form_liting($this->module,$this -> view,$list,$fitler_config,$list_config,$sort_field,$sort_direct,$pagination);
		?>
