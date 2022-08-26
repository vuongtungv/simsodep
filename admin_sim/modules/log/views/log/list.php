<?php  
	global $toolbar;
	$toolbar->setTitle(FSText :: _('Lịch sử tác động') );
	// $toolbar->addButton('save_all',FSText :: _('Save'),'','save.png'); 
    // $toolbar->addButton('add',FSText :: _('Add'),'','add.png');
    // $toolbar->addButton('edit',FSText :: _('Edit'),FSText :: _('You must select at least one record'),'edit.png'); 
	$toolbar->addButton('remove',FSText :: _('Remove'),FSText :: _('You must select at least one record'),'remove.png'); 

	//	FILTER
	$filter_config  = array();
	$fitler_config['search'] = 1; 

	//	CONFIG	
	$list_config = array();
//	$list_config[] = array('title'=>'Họ tên','field'=>'fullname','ordering'=> 1, 'type'=>'text');
//	$list_config[] = array('title'=>'Email','field'=>'email','ordering'=> 1, 'type'=>'text');
//	$list_config[] = array('title'=>'Sim ký gửi','field'=>'deposit_sim','ordering'=> 1, 'type'=>'text');
//	 $list_config[] = array('title'=>'% môi giới','field'=>'percent_brokers','ordering'=> 1, 'type'=>'text');
	$list_config[] = array('title'=>'Title','field'=>'title','ordering'=> 1,'type'=>'text');
	$list_config[] = array('title'=>'User thực hiện','field'=>'user_name','ordering'=> 1,'type'=>'text');
	$list_config[] = array('title'=>'Đại lý','field'=>'agnecy_name','ordering'=> 1,'type'=>'text');
    // $list_config[] = array('title'=>'Ordering','field'=>'ordering','ordering'=> 1, 'type'=>'edit_text','arr_params'=>array('size'=>3));
	//$list_config[] = array('title'=>'Published','field'=>'published','ordering'=> 1, 'type'=>'published');
	// $list_config[] = array('title'=>'Xem','type'=>'edit');
	$list_config[] = array('title'=>'Created time','field'=>'created_time','ordering'=> 1, 'type'=>'date');
	// $list_config[] = array('title'=>'Id','field'=>'id','ordering'=> 1, 'type'=>'text');
	
	TemplateHelper::genarate_form_liting($this->module,$this -> view,$list,$fitler_config,$list_config,$sort_field,$sort_direct,$pagination);
?>
