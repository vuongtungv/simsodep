<?php  

	global $toolbar;
	$toolbar->setTitle(FSText :: _('Video bài học') );
    
    // $toolbar->addButton('save_all',FSText :: _('Save'),'','save.png'); 
	$toolbar->addButton('add',FSText :: _('Add'),'','add.png');
	// $toolbar->addButton('edit',FSText :: _('Edit'),FSText :: _('You must select at least one record'),'edit.png');
	// $toolbar->addButton('duplicate',FSText :: _('Duplicate'),'','duplicate.png'); 
	$toolbar->addButton('remove',FSText :: _('Remove'),FSText :: _('You must select at least one record'),'remove.png'); 
	$toolbar->addButton('published',FSText :: _('Published'),FSText :: _('You must select at least one record'),'published.png');
	$toolbar->addButton('unpublished',FSText :: _('Unpublished'),FSText :: _('You must select at least one record'),'unpublished.png');

	//	FILTER
	$filter_config  = array();
	$fitler_config['search'] = 0; 
	$fitler_config['filter_count'] = 0;
	
	//	CONFIG	
	$list_config = array();
	$list_config[] = array('title'=>'Tên Video','field'=>'name','ordering'=> 1, 'type'=>'text','align'=>'left');
//	$list_config[] = array('title'=>'Image','field'=>'image','type'=>'image','arr_params'=>array('search'=>'/original/','replace'=>'/resized/'));
	$list_config[] = array('title'=>'Khóa học','field'=>'course_name','ordering'=> 1, 'type'=>'text','col_width' => '20%');
	$list_config[] = array('title'=>'Published','field'=>'published','ordering'=> 1, 'type'=>'published');
    $list_config[] = array('title'=>'Edit','type'=>'edit');
	$list_config[] = array('title'=>'Id','field'=>'id','ordering'=> 1, 'type'=>'text');
	
	TemplateHelper::genarate_form_liting($this->module,$this -> view,$list,@$fitler_config,$list_config,$sort_field,$sort_direct,$pagination);
?>
