<?php
	global $toolbar;
	$toolbar->setTitle(FSText :: _('Ký gửi sim') );
	$toolbar->addButton('save_all',FSText :: _('Save'),'','save.png');
    $toolbar->addButton('add',FSText :: _('Add'),'','add.png');
    $toolbar->addButton('edit',FSText :: _('Edit'),FSText :: _('You must select at least one record'),'edit.png'); 
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
	$list_config[] = array('title'=>'Tên gói cước','field'=>'title','ordering'=> 1,'type'=>'text');
	$list_config[] = array('title'=>'Nhà mạng','field'=>'network','ordering'=> 1,'type'=>'text');
	$list_config[] = array('title'=>'Giá','field'=>'price','ordering'=> 1,'type'=>'text');
	$list_config[] = array('title'=>'Cú pháp','field'=>'rules_regis','ordering'=> 1,'type'=>'text');
//	$list_config[] = array('title'=>'Đầu số đăng ký','field'=>'frist_number_regis','ordering'=> 1,'type'=>'text');
    $list_config[] = array('title'=>'Ordering','field'=>'ordering','ordering'=> 1, 'type'=>'edit_text','arr_params'=>array('size'=>3));
	//$list_config[] = array('title'=>'Published','field'=>'published','ordering'=> 1, 'type'=>'published');
	$list_config[] = array('title'=>'Xem','type'=>'edit');
	$list_config[] = array('title'=>'Created time','field'=>'created_time','ordering'=> 1, 'type'=>'datetime');
	$list_config[] = array('title'=>'Id','field'=>'id','ordering'=> 1, 'type'=>'text');
	
	TemplateHelper::genarate_form_liting($this->module,$this -> view,$list,$fitler_config,$list_config,$sort_field,$sort_direct,$pagination);
?>
