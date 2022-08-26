<?php  
	global $toolbar;
	$toolbar->setTitle(FSText :: _('Danh sách chiết khấu / tăng giảm giá Sim') );
	$toolbar->addButton('export',FSText :: _('Export'),'','Excel-icon.png');
	$toolbar->addButton('add',FSText :: _('Add'),'','add.png'); 
	$toolbar->addButton('duplicate',FSText :: _('Duplicate'),FSText :: _('You must select at least one record'),'edit.png'); 
	$toolbar->addButton('remove',FSText :: _('Remove'),FSText :: _('You must select at least one record'),'remove.png'); 
	$toolbar->addButton('published',FSText :: _('Published'),FSText :: _('You must select at least one record'),'published.png');
	$toolbar->addButton('unpublished',FSText :: _('Unpublished'),FSText :: _('You must select at least one record'),'unpublished.png');
    
    $filter_config  = array();
	$fitler_config['search'] = 1; 
    
    $list_config[] = array('title'=>'Tên loại','field'=>'name', 'type'=>'text','col_width' => '20%','align'=>'left'); 
    $list_config[] = array('title'=>'User tạo','field'=>'user_create_name', 'type'=>'text','col_width' => '20%','align'=>'left'); 
    $list_config[] = array('title'=>'User cập nhật','field'=>'user_update_name', 'type'=>'text','col_width' => '20%','align'=>'left'); 
	$list_config[] = array('title'=>'Published','field'=>'published','ordering'=> 1, 'type'=>'published');
    $list_config[] = array('title'=>'Edit','type'=>'edit');
	$list_config[] = array('title'=>'Ngày tạo','field'=>'created_time','ordering'=> 1, 'type'=>'datetime');
	// $list_config[] = array('title'=>'Id','field'=>'id','ordering'=> 1, 'type'=>'text');
    
    TemplateHelper::genarate_form_liting($this->module,$this -> view,$list,$fitler_config,$list_config,$sort_field,$sort_direct,$pagination);
?>