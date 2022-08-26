<?php  
	global $toolbar;
	$toolbar->setTitle(FSText :: _('Danh sách khóa học') );
	// $toolbar->addButton('duplicate',FSText :: _('Duplicate'),'','duplicate.png');
	// $toolbar->addButton('save_all',FSText :: _('Save'),'','save.png'); 
	$toolbar->addButton('add',FSText :: _('Add'),'','add.png'); 
	// $toolbar->addButton('edit',FSText :: _('Edit'),FSText :: _('You must select at least one record'),'edit.png'); 
	$toolbar->addButton('remove',FSText :: _('Remove'),FSText :: _('You must select at least one record'),'remove.png'); 
	// $toolbar->addButton('published',FSText :: _('Published'),FSText :: _('You must select at least one record'),'published.png');
	// $toolbar->addButton('unpublished',FSText :: _('Unpublished'),FSText :: _('You must select at least one record'),'unpublished.png');
	
	//	FILTER
	$filter_config  = array();
	$fitler_config['search'] = 1; 
	$fitler_config['filter_count'] = 1;

	$filter_categories = array();
	$filter_categories['title'] = FSText::_('Categories'); 
	$filter_categories['list'] = @$categories; 
	$filter_categories['field'] = 'name'; 
	
	$fitler_config['filter'][] = $filter_categories;																																							
	//	CONFIG	
	$list_config = array();
	$list_config[] = array('title'=>'Tên khóa học','field'=>'coursename','ordering'=> 1, 'type'=>'text_link','col_width' => '20%','align'=>'left','link'=>'index.php?module=course&view=cat&id=id','arr_params'=>array('size'=> 30));
	// $list_config[] = array('title'=>'Image','field'=>'image','type'=>'image','no_col'=>1,'arr_params'=>array('search'=>'/original/','replace'=>'/small/'));
	$list_config[] = array('title'=>'Danh mục','field'=>'course_id','ordering'=> 1, 'type'=>'edit_selectbox','col_width' => '25%','arr_params'=>array('arry_select'=>$categories,'field_value'=>'id','field_label'=>'name','size'=>10));
    $list_config[] = array('title'=>'Ngày tạo','field'=>'date_created','ordering'=> 1, 'type'=>'date');
	$list_config[] = array('title'=>'Ngày sửa','field'=>'lastedit_date','ordering'=> 1, 'type'=>'date');
	$list_config[] = array('title'=>'Người sửa','field'=>'lastedit_name','ordering'=> 1, 'type'=>'text');
	$list_config[] = array('title'=>'Ordering','field'=>'ordering','ordering'=> 1, 'type'=>'edit_text','arr_params'=>array('size'=>3));
    // $list_config[] = array('title'=>'Hoạt động','field'=>'active','ordering'=> 1, 'type'=>'change_status','arr_params'=>array('function'=>'active'));
    $list_config[] = array('title'=>'Hoạt động','field'=>'published','ordering'=> 1, 'type'=>'published');
	$list_config[] = array('title'=>'Edit','type'=>'edit');
	// $list_config[] = array('title'=>'Id','field'=>'id','ordering'=> 1, 'type'=>'text');
	
	TemplateHelper::genarate_form_liting($this->module,$this -> view,$list,$fitler_config,$list_config,$sort_field,$sort_direct,$pagination);
		?>