<?php  
	global $toolbar;
	$toolbar->setTitle(FSText :: _('Danh sách') );
	$toolbar->addButton('duplicate',FSText :: _('Duplicate'),'','duplicate.png');
	// $toolbar->addButton('save_all',FSText :: _('Save'),'','save.png'); 
	$toolbar->addButton('add',FSText :: _('Add'),'','add.png'); 
	$toolbar->addButton('edit',FSText :: _('Edit'),FSText :: _('You must select at least one record'),'edit.png'); 
	$toolbar->addButton('remove',FSText :: _('Remove'),FSText :: _('You must select at least one record'),'remove.png'); 
	$toolbar->addButton('published',FSText :: _('Published'),FSText :: _('You must select at least one record'),'published.png');
	$toolbar->addButton('unpublished',FSText :: _('Unpublished'),FSText :: _('You must select at least one record'),'unpublished.png');
	//	FILTER
	$filter_config  = array();
	$fitler_config['search'] = 1; 
																																																																																																																																																																																																																																																																																																																																																																																																																					

	//	CONFIG	
	$list_config = array();
	$list_config[] = array('title'=>'Trang Seo','field'=>'module_seo','ordering'=> 1, 'type'=>'edit_selectbox','col_width' => '15%','arr_params'=>array('arry_select'=>$this -> array_cat,'field_value'=>'id','field_label'=>'name','size'=>1));
	$list_config[] = array('title'=>'Chi tiết','field'=>'name_type','ordering'=> 1, 'type'=>'edit_text','col_width' => '15%','arr_params'=>array('size'=> 30));
	$list_config[] = array('title'=>'Title','field'=>'title','ordering'=> 1, 'type'=>'edit_text','col_width' => '20%','arr_params'=>array('size'=> 30));
	$list_config[] = array('title'=>'Mô tả','field'=>'description','ordering'=> 1, 'type'=>'edit_text','col_width' => '20%','arr_params'=>array('size'=> 30));
	$list_config[] = array('title'=>'User Tạo','field'=>'user_create_name','ordering'=> 1, 'type'=>'text','col_width' => '10%','arr_params'=>array('size'=> 30));
	$list_config[] = array('title'=>'User cập nhật','field'=>'user_update_name','ordering'=> 1, 'type'=>'text','col_width' => '10%','arr_params'=>array('size'=> 30));
	// $list_config[] = array('title'=>'Image','field'=>'image','type'=>'image','no_col'=>1,'arr_params'=>array('search'=>'/original/','replace'=>'/small/'));
	// $list_config[] = array('title'=>'Ordering','field'=>'ordering','ordering'=> 1, 'type'=>'edit_text','arr_params'=>array('size'=>3));
	$list_config[] = array('title'=>'Published','field'=>'published','ordering'=> 1, 'type'=>'published');
	$list_config[] = array('title'=>'Edit','type'=>'edit');
	$list_config[] = array('title'=>'Created time','field'=>'created_time','ordering'=> 1, 'type'=>'datetime');
	// $list_config[] = array('title'=>'Id','field'=>'id','ordering'=> 1, 'type'=>'text');
	
	TemplateHelper::genarate_form_liting($this->module,$this -> view,$list,$fitler_config,$list_config,$sort_field,$sort_direct,$pagination);
		?>
	